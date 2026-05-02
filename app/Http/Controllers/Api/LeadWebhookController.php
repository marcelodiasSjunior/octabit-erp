<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTOs\Client\CreateClientDTO;
use App\Enums\ClientStatus;
use App\Http\Controllers\Controller;
use App\Services\ClientService;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

final class LeadWebhookController extends Controller
{
    public function __construct(
        private readonly ClientService $clientService,
        private readonly TagService    $tagService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        Log::info('Lead Webhook received:', $request->all());

        $validator = Validator::make($request->all(), [
            'nome'     => ['required', 'string', 'max:255'],
            'email'    => ['nullable', 'string', 'max:255'],
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
            
            // Garantir que a tag 'Site Octa' existe via Service
            $siteTag = $this->tagService->firstOrCreate('Site Octa', [
                'color' => 'blue', 
                'description' => 'Leads vindos do site octabit.tech'
            ]);

            // Lógica para tratar e-mail ausente
            $email = $data['email'];
            if (empty($email)) {
                $cleanPhone = preg_replace('/\D/', '', $data['telefone'] ?? '000');
                $email = ($cleanPhone ?: Str::slug($data['nome'])) . '@lead.octabit.tech';
            }

            // Verificar se o lead já existe via Service
            $existing = $this->clientService->findExistingLead($email, $data['telefone'] ?? null);

            if ($existing) {
                if ($existing->trashed()) {
                    $this->clientService->restore($existing->id);
                    $existing->update(['name' => $data['nome']]);
                    Log::info("Lead restaurado e nome atualizado: ID {$existing->id}");
                }

                $this->clientService->syncTags($existing->id, [$siteTag->id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Lead já cadastrado anteriormente.',
                    'id'      => $existing->id
                ], 200);
            }
            
            $dto = new CreateClientDTO(
                name: $data['nome'],
                email: $email,
                document: null,
                status: ClientStatus::Lead,
                phone: $data['telefone'] ?? '',
                notes: isset($data['mensagem']) ? "Mensagem da Landing Page: " . $data['mensagem'] : "Lead vindo da Landing Page (" . ($data['origem'] ?? 'home') . ")",
                tags: [$siteTag->id],
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
