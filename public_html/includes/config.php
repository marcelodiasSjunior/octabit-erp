<?php
/**
 * OctaBit — Configuração centralizada
 * Todos os dados, textos e configurações do site.
 */

$config = [
    'brand' => [
        'name'      => 'OctaBit',
        'tagline'   => 'Estruturação Digital Estratégica',
        'logo'      => '/img/logo.svg',
        'url'       => 'https://octabit.tech',
        'instagram' => 'https://instagram.com/octabit.tech',
    ],

    'contact' => [
        'whatsapp_number'  => '5541987762489',
        'whatsapp_url'     => 'https://wa.me/5541987762489',
        'email'            => 'octabit@octabit.tech',
    ],

    'integrations' => [
        'google_apps_script' => 'https://script.google.com/macros/s/AKfycbzq79u0pQJwfx2qY39DiFP5TrZjgiWQOlqFzsQL2bueC2JJMlTsY7aPTIXccWp90-zcow/exec',
        'ga4_id'             => '',
        'meta_pixel_id'      => '',
    ],

    'nav' => [
        ['text' => 'Início',    'href' => '/'],
        ['text' => 'Serviços',  'href' => '/servicos'],
        ['text' => 'Soluções',  'href' => '/solucoes'],
        ['text' => 'Planos',    'href' => '/planos'],
        ['text' => 'Sobre',     'href' => '/sobre'],
        ['text' => 'Contato',   'href' => '/contato'],
    ],

    'hero' => [
        'badge'    => 'Estruturação Digital Estratégica',
        'title'    => 'Transforme sua empresa com tecnologia estratégica',
        'subtitle' => 'A OctaBit estrutura, moderniza e impulsiona pequenas empresas através do método PTE-I — com presença profissional, automações úteis e dados claros para decisão.',
        'cta_primary'   => 'Agendar diagnóstico gratuito',
        'cta_secondary' => 'Ver planos',
    ],

    'problem' => [
        'title' => 'Sua empresa está limitada pela falta de estrutura?',
        'items' => [
            'Horas perdidas com tarefas manuais e repetitivas',
            'Erros que custam caro por falta de automação',
            'Dependência de pessoas, não de processos',
            'Concorrentes mais organizados e mais rápidos',
        ],
    ],

    'solution' => [
        'title' => 'O Método OctaBit resolve isso',
        'steps' => [
            ['icon' => 'search',      'title' => 'Diagnóstico',      'desc' => 'Mapeamos processos, dores e objetivos para criar um roteiro personalizado.'],
            ['icon' => 'tool',        'title' => 'Implantação',      'desc' => 'Estruturamos a tecnologia, automatizamos tarefas e organizamos a operação.'],
            ['icon' => 'bar-chart-2', 'title' => 'Acompanhamento',   'desc' => 'Monitoramos resultados e ajustamos a rota para garantir crescimento contínuo.'],
        ],
    ],

    'method' => [
        'title'    => 'Método PTE-I',
        'subtitle' => 'Quatro eixos que organizam o crescimento da sua empresa',
        'steps'    => [
            ['icon' => 'globe',       'letter' => 'P', 'title' => 'Presença',     'desc' => 'Site profissional, SEO e posicionamento para tornar sua empresa visível e confiável.'],
            ['icon' => 'cpu',         'letter' => 'T', 'title' => 'Tecnologia',   'desc' => 'Ferramentas, sistemas e infraestrutura que sustentam a operação com estabilidade.'],
            ['icon' => 'trending-up', 'letter' => 'E', 'title' => 'Escala',       'desc' => 'Automações e integrações que reduzem dependência operacional e preparam crescimento.'],
            ['icon' => 'activity',    'letter' => 'I', 'title' => 'Inteligência', 'desc' => 'Dashboards, métricas e relatórios para decisões rápidas e estratégicas.'],
        ],
    ],

    'services' => [
        'title'    => 'Serviços que estruturam seu negócio',
        'subtitle' => 'Da base digital à inteligência de negócio',
        'items'    => [
            ['icon' => 'globe',      'title' => 'Presença Digital',          'desc' => 'Site profissional, SEO técnico e hospedagem segura para tornar sua empresa visível e encontrável.'],
            ['icon' => 'bar-chart-2','title' => 'Inteligência de Dados',     'desc' => 'Dashboards de vendas e BI para transformar intuição em decisão baseada em dados reais.'],
            ['icon' => 'zap',        'title' => 'Automação de Processos',    'desc' => 'Automações operacionais e integrações entre canais para ganhar velocidade com consistência.'],
            ['icon' => 'users',      'title' => 'Acompanhamento Estratégico','desc' => 'Recomendações práticas e monitoramento contínuo para evoluir resultados sem improviso.'],
        ],
    ],

    'target_audience' => [
        'title' => 'Para quem é a OctaBit?',
        'items' => [
            ['icon' => 'briefcase',  'text' => 'Pequenas empresas com 2 a 20 funcionários'],
            ['icon' => 'trending-up','text' => 'Faturamento entre R$ 20 mil e R$ 200 mil/mês'],
            ['icon' => 'clipboard',  'text' => 'Processos manuais e falta de organização digital'],
            ['icon' => 'target',     'text' => 'Querem crescer com previsibilidade e controle'],
        ],
    ],

    'authority' => [
        'title' => 'Resultados que já entregamos',
        'items' => [
            ['number' => 'Top 3',  'label' => 'Posicionamento Local',   'desc' => 'Cliente saiu da página 10 para as primeiras posições em buscas locais.'],
            ['number' => '-70%',   'label' => 'Redução de Retrabalho',  'desc' => 'Automações liberaram tempo para foco em vendas e atendimento.'],
            ['number' => '+35%',   'label' => 'Crescimento em 3 meses', 'desc' => 'Com estrutura digital organizada, cliente aumentou faturamento.'],
        ],
    ],

    'portfolio' => [
        'title' => 'Casos reais',
        'items' => [
            ['name' => 'KS Oficina',        'desc' => 'Ganho rápido de presença orgânica e posicionamento local com base digital bem executada e SEO básico.', 'tag' => 'Presença Digital'],
            ['name' => 'Sabor à Domicílio',  'desc' => 'Integração entre operação, automação via WhatsApp e painel administrativo completo.', 'tag' => 'Automação + Operação'],
            ['name' => 'OctaPonto',          'desc' => 'Produto próprio de controle de jornada, demonstrando capacidade técnica de construir soluções robustas.', 'tag' => 'Produto Próprio'],
        ],
    ],

    'catalog' => [
        'title'    => 'Catálogo de Soluções',
        'subtitle' => 'Escolha o que sua empresa precisa agora',
        'items'    => [
            [
                'id'          => 'presenca-digital',
                'name'        => 'Estruturação de Presença Digital',
                'desc'        => 'Site profissional com SEO técnico, analytics e hospedagem segura. A base para ser encontrado online.',
                'price'       => 'Sob consulta',
                'icon'        => 'globe',
                'whatsapp_msg'=> 'Olá! Tenho interesse na solução de Presença Digital.',
            ],
            [
                'id'          => 'bi-vendas',
                'name'        => 'BI e Dashboard de Vendas',
                'desc'        => 'Painel de indicadores com faturamento, ticket médio, canais e conversão. Dados claros para decisão.',
                'price'       => 'A partir de R$ 1.900',
                'icon'        => 'bar-chart-2',
                'whatsapp_msg'=> 'Olá! Tenho interesse na solução de BI e Dashboard.',
            ],
            [
                'id'          => 'automacao-whatsapp',
                'name'        => 'Automação Comercial WhatsApp',
                'desc'        => 'Fluxos de atendimento e captação automatizados para melhorar conversão e velocidade de resposta.',
                'price'       => 'A partir de R$ 1.400',
                'icon'        => 'zap',
                'whatsapp_msg'=> 'Olá! Tenho interesse na solução de Automação WhatsApp.',
            ],
            [
                'id'          => 'integracoes',
                'name'        => 'Integrações e Processos Internos',
                'desc'        => 'Conectamos sistemas e canais para reduzir retrabalho e garantir consistência operacional.',
                'price'       => 'Sob consulta',
                'icon'        => 'link',
                'whatsapp_msg'=> 'Olá! Tenho interesse na solução de Integrações.',
            ],
        ],
    ],

    'plans' => [
        'title'    => 'Escolha o nível de transformação da sua empresa',
        'subtitle' => 'Cada plano representa um estágio de maturidade digital',
        'list'     => [
            [
                'id'       => 'essencial',
                'name'     => 'Essencial',
                'setup'    => 600,
                'monthly'  => 497,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Base digital profissional',
                'benefits' => [
                    'Site institucional profissional',
                    'Hospedagem e monitoramento',
                    'Google Analytics + dashboard básico',
                    'Suporte técnico e melhorias',
                    'Acompanhamento estratégico anual',
                ],
            ],
            [
                'id'       => 'profissional',
                'name'     => 'Profissional',
                'setup'    => 1200,
                'monthly'  => 997,
                'featured' => true,
                'badge'    => 'Mais Escolhido',
                'goal'     => 'Estruturação para crescimento',
                'benefits' => [
                    'Tudo do plano Essencial',
                    'BI profissional e indicadores de vendas',
                    'Automações simples e integrações',
                    'Análise mensal com plano de ação',
                    'Acompanhamento trimestral',
                ],
            ],
            [
                'id'       => 'empresarial',
                'name'     => 'Empresarial',
                'setup'    => 2500,
                'monthly'  => 1997,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Evolução operacional completa',
                'benefits' => [
                    'Tudo do plano Profissional',
                    'Automações avançadas e integrações complexas',
                    'BI avançado sob medida',
                    'Acompanhamento estratégico mensal',
                    'Prioridade máxima de atendimento',
                ],
            ],
        ],
    ],

    'about' => [
        'title' => 'Seu parceiro estratégico de crescimento',
        'text'  => 'A OctaBit atua na interseção entre negócio, tecnologia e operação. Nosso foco é tirar o cliente do improviso e construir uma base que aguenta escala. Não vendemos sites ou sistemas — vendemos estrutura de crescimento contínuo.',
        'mission' => 'Estruturar e organizar pequenas empresas através da tecnologia, criando base para crescimento com mais controle e clareza.',
        'vision'  => 'Construir uma operação escalável e reconhecida por transformar pequenas empresas em negócios mais profissionais e preparados para crescer.',
    ],

    'lead_magnet' => [
        'title'    => 'Diagnóstico de Maturidade Digital',
        'subtitle' => 'Descubra em 5 minutos o nível de maturidade digital da sua empresa e receba um relatório personalizado com recomendações práticas.',
        'button'   => 'Quero meu diagnóstico gratuito',
    ],

    'footer' => [
        'copyright' => '© 2026 OctaBit. Todos os direitos reservados.',
        'text'      => 'Estruturação digital estratégica para pequenas empresas.',
    ],
];

// Helper: format currency
function formatBRL($value) {
    return 'R$ ' . number_format($value, 0, ',', '.');
}

// Helper: WhatsApp URL with message
function whatsappURL($message = '') {
    global $config;
    $url = $config['contact']['whatsapp_url'];
    if ($message) {
        $url .= '?text=' . urlencode($message);
    }
    return $url;
}

// Helper: safe output
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
