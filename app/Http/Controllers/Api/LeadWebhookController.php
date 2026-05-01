<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTOs\Client\CreateClientDTO;
use App\Enums\ClientStatus;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Tag;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

final class LeadWebhookController extends Controller
{
    public function __construct(
        private readonly ClientService $clientService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        Log::info('Lead Webhook received:', $request->all());

        $validator = Validator::make($request->all(), [
            'nome'     => ['required', 'string', 'max:255'],
            'email'    => ['nullable', 'string', 'max:255'], // Tornado opcional
            'telefone' => ['nullable', 'string', 'max:20'],
            'mensagem' => ['nullable', 'string'],
            'origem'   => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $data = $validator->validated();
            
            // Garantir que a tag 'Site Octa' existe
            $siteTag = Tag::firstOrCreate(
                ['name' => 'Site Octa'],
                ['color' => 'blue', 'description' => 'Leads vindos do site octabit.tech']
            );

            // Lógica para tratar e-mail ausente
            $email = $data['email'];
            if (empty($email)) {
                // Gerar um email baseado no telefone ou nome para satisfazer o banco
                $cleanPhone = preg_replace('/\D/', '', $data['telefone'] ?? '000');
                $email = ($cleanPhone ?: Str::slug($data['nome'])) . '@lead.octabit.tech';
            }

            // Verificar se o lead já existe (pelo email ou telefone), incluindo registros excluídos (soft deleted)
            $existing = Client::withTrashed()
                ->where(function($q) use ($email, $data) {
                    $q->where('email', $email);
                    if (!empty($data['telefone'])) {
                        $q->orWhere('phone', $data['telefone']);
                    }
                })->first();

            if ($existing) {
                // Se o registro estava excluído, vamos restaurá-lo em vez de criar um novo
                if ($existing->trashed()) {
                    $existing->restore();
                    // Atualizar o nome apenas se foi restaurado (solicitação do item 2 e 3)
                    $existing->update(['name' => $data['nome']]);
                    Log::info("Lead restaurado e nome atualizado: ID {$existing->id}");
                }

                // Garantir que o lead existente tenha a tag do site
                $existing->tags()->syncWithoutDetaching([$siteTag->id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Lead já cadastrado anteriormente.',
                    'id'      => $existing->id
                ], 200);
            }
            
            // Mapear campos para o DTO de criação de cliente/lead
            $dto = new CreateClientDTO(
                name: $data['nome'],
                email: $email,
                document: null, // Mudado de '' para null para evitar erro de UNIQUE constraint
                status: ClientStatus::Lead,
                phone: $data['telefone'] ?? '',
                notes: isset($data['mensagem']) ? "Mensagem da Landing Page: " . $data['mensagem'] : "Lead vindo da Landing Page (" . ($data['origem'] ?? 'home') . ")",
                tags: [$siteTag->id], // Adicionando a tag do site
            );

            $client = $this->clientService->create($dto);

            return response()->json([
                'success' => true,
                'message' => 'Lead cadastrado com sucesso.',
                'id'      => $client->id
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook de lead: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro interno ao processar o lead.'
            ], 500);
        }
    }
}
