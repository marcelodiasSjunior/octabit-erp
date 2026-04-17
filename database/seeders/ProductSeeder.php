<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            // ── Produtos SaaS / plataformas adaptáveis ────────────────────
            [
                'name'        => 'Sistema de Pedidos via WhatsApp',
                'type'        => 'saas',
                'price'       => 297.00,
                'description' => implode("\n", [
                    'Plataforma completa de pedidos e entregas por WhatsApp. Adaptável para qualquer segmento (alimentação, e-commerce, serviços).',
                    '',
                    'Inclui:',
                    '• Bot de atendimento e captação de pedidos no WhatsApp',
                    '• Painel administrativo para gestão de pedidos, regiões e clientes',
                    '• Cardápio/catálogo configurável com imagens e preços',
                    '• Gestão de regiões de entrega com taxas e dias configuráveis',
                    '• Controle de rotas e motoristas',
                    '• Aprovação de comprovantes de pagamento',
                    '• Histórico completo de pedidos por cliente',
                    '',
                    'Case de referência: Sabor à Domicílio.',
                ]),
                'active'      => true,
            ],
            [
                'name'        => 'Site Institucional com Conversão WhatsApp',
                'type'        => 'saas',
                'price'       => 97.00,
                'description' => implode("\n", [
                    'Site profissional otimizado para conversão de visitantes em contatos via WhatsApp. Adaptável para qualquer tipo de negócio local.',
                    '',
                    'Inclui:',
                    '• Design moderno e responsivo',
                    '• Catálogo de produtos/serviços com fotos e preços',
                    '• Botões de contato direto no WhatsApp por produto/serviço',
                    '• SEO técnico básico (meta tags, sitemap, schema)',
                    '• Google Analytics integrado',
                    '• Painel simples para atualização de conteúdo',
                    '• Hospedagem inclusa no primeiro ano',
                    '',
                    'Case de referência: KS Oficina (ksoficina.com.br).',
                ]),
                'active'      => true,
            ],
            [
                'name'        => 'OctaBit ERP/CRM',
                'type'        => 'saas',
                'price'       => 497.00,
                'description' => implode("\n", [
                    'Sistema de gestão empresarial completo com módulo CRM. Desenvolvido para pequenas e médias empresas que precisam de controle operacional e visibilidade financeira.',
                    '',
                    'Módulos:',
                    '• CRM — clientes, histórico de interações, serviços e produtos vinculados',
                    '• Contratos — gestão com upload de arquivos e controle de vigência',
                    '• Financeiro — contas a receber e a pagar, fluxo de caixa',
                    '• Catálogo — serviços e produtos com precificação',
                    '• Dashboard executivo com indicadores-chave',
                    '',
                    'Tecnologia: Laravel 11, PHP 8.2, MySQL, Redis. Implantado com Docker.',
                ]),
                'active'      => true,
            ],

            // ── Produtos de licença/entrega única ─────────────────────────
            [
                'name'        => 'OctaPonto — Controle de Jornada',
                'type'        => 'saas',
                'price'       => 197.00,
                'description' => implode("\n", [
                    'Sistema de controle de ponto e jornada de trabalho. Produto próprio OctaBit, demonstrando capacidade técnica de construir soluções robustas.',
                    '',
                    'Funcionalidades:',
                    '• Registro de ponto via app ou web',
                    '• Gestão de turnos e escalas',
                    '• Relatórios de horas trabalhadas e banco de horas',
                    '• Integração com folha de pagamento',
                    '• Painel do gestor com visão em tempo real',
                ]),
                'active'      => true,
            ],
            [
                'name'        => 'Landing Page de Alta Conversão',
                'type'        => 'one_time',
                'price'       => 1200.00,
                'description' => implode("\n", [
                    'Página de vendas ou captação de leads otimizada para conversão. Ideal para lançamentos, campanhas sazonais ou captação de leads qualificados.',
                    '',
                    'Inclui:',
                    '• Design focado em conversão (headline, prova social, CTA)',
                    '• Integração com WhatsApp e formulário de captura',
                    '• Pixel de rastreamento (Meta/Google)',
                    '• Entrega em até 7 dias úteis',
                    '• 30 dias de suporte pós-entrega',
                ]),
                'active'      => true,
            ],
            [
                'name'        => 'Automatização de Atendimento WhatsApp',
                'type'        => 'one_time',
                'price'       => 1400.00,
                'description' => implode("\n", [
                    'Implantação de fluxo de atendimento automatizado via WhatsApp Business API. Reduz carga operacional e aumenta velocidade de resposta.',
                    '',
                    'Inclui:',
                    '• Mapeamento e desenho dos fluxos de atendimento',
                    '• Configuração de mensagens automáticas e menus',
                    '• Integração com sistema de agendamento ou pedidos',
                    '• Treinamento da equipe',
                    '• 30 dias de acompanhamento pós-implantação',
                ]),
                'active'      => true,
            ],
        ];

        foreach ($products as $data) {
            Product::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
