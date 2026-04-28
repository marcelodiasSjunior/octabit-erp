<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTOs\Client\CreateClientDTO;
use App\Enums\ClientStatus;
use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            'email'    => ['required', 'email', 'max:255'],
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
            
            // Mapear campos para o DTO de criação de cliente/lead
            $dto = new CreateClientDTO(
                name: $data['nome'],
                email: $data['email'],
                phone: $data['telefone'] ?? '',
                status: ClientStatus::Lead,
                document: '', // Não temos o documento na landing page
                notes: isset($data['mensagem']) ? "Mensagem da Landing Page: " . $data['mensagem'] : "Lead vindo da Landing Page",
            );

            $this->clientService->create($dto);

            return response()->json([
                'success' => true,
                'message' => 'Lead cadastrado com sucesso.'
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
