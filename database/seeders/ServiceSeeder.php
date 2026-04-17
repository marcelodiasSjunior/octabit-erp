<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [

            // ── Planos mensais recorrentes ────────────────────────────────
            [
                'name'        => 'Plano Essencial',
                'type'        => 'hybrid',
                'base_price'  => 497.00,
                'setup_price' => 600.00,
                'description' => 'Base digital profissional. Inclui site institucional, hospedagem e monitoramento, Google Analytics + dashboard básico, suporte técnico e melhorias mensais, e acompanhamento estratégico anual.',
                'active'      => true,
            ],
            [
                'name'        => 'Plano Profissional',
                'type'        => 'hybrid',
                'base_price'  => 997.00,
                'setup_price' => 1200.00,
                'description' => 'Estruturação para crescimento. Tudo do Essencial + BI profissional e indicadores de vendas, automações simples e integrações, análise mensal com plano de ação, e acompanhamento trimestral.',
                'active'      => true,
            ],
            [
                'name'        => 'Plano Empresarial',
                'type'        => 'hybrid',
                'base_price'  => 1997.00,
                'setup_price' => 2500.00,
                'description' => 'Evolução operacional completa. Tudo do Profissional + automações avançadas e integrações complexas, BI avançado sob medida, acompanhamento estratégico mensal e prioridade máxima de atendimento.',
                'active'      => true,
            ],

            // ── Serviços avulsos recorrentes ──────────────────────────────
            [
                'name'        => 'Hospedagem e Monitoramento',
                'type'        => 'recurring',
                'base_price'  => 97.00,
                'setup_price' => null,
                'description' => 'Hospedagem segura, SSL, backups automáticos e monitoramento de disponibilidade. Inclui até 1 domínio e 10 GB de armazenamento.',
                'active'      => true,
            ],
            [
                'name'        => 'Suporte Técnico Mensal',
                'type'        => 'recurring',
                'base_price'  => 297.00,
                'setup_price' => null,
                'description' => 'Banco de horas mensal para atendimento técnico, ajustes em sistemas, atualizações e pequenas melhorias. 4 horas/mês inclusas.',
                'active'      => true,
            ],
            [
                'name'        => 'Acompanhamento Estratégico',
                'type'        => 'recurring',
                'base_price'  => 497.00,
                'setup_price' => null,
                'description' => 'Reunião mensal de análise de indicadores + plano de ação. Inclui dashboard de performance, relatório de progresso e recomendações priorizadas.',
                'active'      => true,
            ],

            // ── Serviços pontuais ─────────────────────────────────────────
            [
                'name'        => 'Diagnóstico de Maturidade Digital',
                'type'        => 'one_time',
                'base_price'  => 0.00,
                'setup_price' => null,
                'description' => 'Mapeamento dos processos, dores e objetivos da empresa. Entrega relatório personalizado com nível de maturidade digital e roteiro de evolução. Gratuito para novos clientes.',
                'active'      => true,
            ],
            [
                'name'        => 'Implantação de Automações',
                'type'        => 'one_time',
                'base_price'  => 1400.00,
                'setup_price' => null,
                'description' => 'Implantação de fluxos de automação operacional (WhatsApp, e-mail, notificações, integrações). Preço a partir de R$ 1.400 conforme escopo definido no diagnóstico.',
                'active'      => true,
            ],
            [
                'name'        => 'BI e Dashboard de Vendas',
                'type'        => 'one_time',
                'base_price'  => 1900.00,
                'setup_price' => null,
                'description' => 'Construção de painel de indicadores com faturamento, ticket médio, canais e conversão. Conecta às principais fontes de dados da empresa. A partir de R$ 1.900.',
                'active'      => true,
            ],
            [
                'name'        => 'Integrações e Processos Internos',
                'type'        => 'one_time',
                'base_price'  => 0.00,
                'setup_price' => null,
                'description' => 'Conexão de sistemas e canais para reduzir retrabalho e garantir consistência operacional. Escopo e preço definidos após diagnóstico.',
                'active'      => true,
            ],
        ];

        foreach ($services as $data) {
            Service::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
