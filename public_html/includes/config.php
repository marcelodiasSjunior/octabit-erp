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
        ['text' => 'Catálogo',  'href' => '/solucoes'],
        ['text' => 'Planos',    'href' => '/planos'],
        ['text' => 'Sobre',     'href' => '/sobre'],
        ['text' => 'Contato',   'href' => '/contato'],
    ],

    'hero' => [
        'badge'    => 'Estruturação Digital Estratégica',
        'title'    => 'Chega de improvisar. Estruture seu negócio com tecnologia que funciona',
        'subtitle' => 'Em 30 dias, seu negócio com site profissional, processos automatizados e dashboard de resultados — sem precisar de equipe de TI.',
        'cta_primary'   => 'Receber diagnóstico gratuito',
        'cta_secondary' => 'Ver como funciona',
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
        'title'    => 'O que entregamos na prática',
        'subtitle' => 'Soluções concretas, não promessas',
        'items'    => [
            [
                'icon'  => 'globe',
                'title' => 'Sites e Sistemas',
                'desc'  => 'Desenvolvemos seu site institucional, landing page ou sistema web sob medida.',
                'deliverables' => [
                    'Site em WordPress, Laravel ou HTML/CSS puro',
                    'SEO técnico para aparecer no Google',
                    'Hospedagem configurada (Hostinger ou VPS)',
                    'Certificado SSL, domínio e e-mail profissional',
                ],
            ],
            [
                'icon'  => 'bar-chart-2',
                'title' => 'Dashboards e BI',
                'desc'  => 'Painéis visuais com seus dados reais para você tomar decisões rápidas.',
                'deliverables' => [
                    'Dashboard em Looker Studio, Power BI ou Metabase',
                    'Indicadores: faturamento, ticket médio, conversão',
                    'Integração com Google Sheets, banco de dados ou API',
                    'Atualização automática dos dados',
                ],
            ],
            [
                'icon'  => 'zap',
                'title' => 'Automações e Integrações',
                'desc'  => 'Eliminamos tarefas manuais e conectamos seus sistemas.',
                'deliverables' => [
                    'Chatbots e fluxos via WhatsApp (BotConversa)',
                    'Scripts sob medida em Python',
                    'Integração entre sistemas (API, webhooks)',
                    'Automação de relatórios e notificações',
                ],
            ],
            [
                'icon'  => 'tool',
                'title' => 'Manutenção e Evolução',
                'desc'  => 'Cuidamos do que já existe e evoluímos junto com seu negócio.',
                'deliverables' => [
                    'Manutenção de sites e sistemas existentes',
                    'Customizações em plataformas prontas',
                    'Monitoramento de uptime e performance',
                    'Reuniões de acompanhamento e plano de ação',
                ],
            ],
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
            ['number' => '12+',   'label' => 'Empresas estruturadas',  'desc' => 'Pequenas empresas com presença digital e processos organizados.'],
            ['number' => '-70%',  'label' => 'Menos retrabalho',       'desc' => 'Redução média de trabalho manual com automações e integrações.'],
            ['number' => 'Top 3', 'label' => 'Google Local',           'desc' => 'Posição alcançada por cliente com SEO e presença digital.'],
        ],
    ],

    'portfolio' => [
        'title' => 'Nossos clientes',
        'items' => [
            ['name' => 'KS Oficina',        'desc' => 'Oficina mecânica que saiu da invisibilidade digital para o Top 3 do Google local com site profissional e SEO.', 'tag' => 'Cliente · Presença Digital', 'quote' => 'Saímos do zero no digital para o Top 3 do Google em menos de 3 meses.', 'author' => 'Proprietário'],
            ['name' => 'Sabor à Domicílio',  'desc' => 'Delivery que reduziu 70% do retrabalho com automação de pedidos via WhatsApp e painel administrativo.', 'tag' => 'Cliente · Automação', 'quote' => 'Antes era tudo no papel e no WhatsApp. Hoje o sistema faz 70% do trabalho sozinho.', 'author' => 'Fundadora'],
            ['name' => 'OctaPonto',          'desc' => 'Produto próprio de controle de jornada, demonstrando capacidade técnica de construir soluções robustas.', 'tag' => 'Produto Próprio'],
        ],
    ],

    'catalog' => [
        'title'    => 'Catálogo de Soluções',
        'subtitle' => 'Projetos pontuais com escopo e preço definidos',
        'items'    => [
            [
                'id'          => 'presenca-digital',
                'name'        => 'Site Profissional',
                'desc'        => 'Site institucional ou landing page com domínio, hospedagem, SSL e SEO configurado. WordPress, Laravel ou HTML puro.',
                'price'       => 'A partir de R$ 1.200',
                'icon'        => 'globe',
                'whatsapp_msg'=> 'Olá! Tenho interesse em um site profissional.',
            ],
            [
                'id'          => 'bi-vendas',
                'name'        => 'Dashboard de Vendas',
                'desc'        => 'Painel em Looker Studio ou Power BI com faturamento, ticket médio, conversão e canais. Conectado ao seu Google Sheets ou banco de dados.',
                'price'       => 'A partir de R$ 1.900',
                'icon'        => 'bar-chart-2',
                'whatsapp_msg'=> 'Olá! Tenho interesse no Dashboard de Vendas.',
            ],
            [
                'id'          => 'automacao-whatsapp',
                'name'        => 'Automação WhatsApp',
                'desc'        => 'Chatbot e fluxos de atendimento via BotConversa. Respostas automáticas, qualificação de leads e envio de notícias/promoções.',
                'price'       => 'A partir de R$ 1.400',
                'icon'        => 'zap',
                'whatsapp_msg'=> 'Olá! Tenho interesse na Automação de WhatsApp.',
            ],
            [
                'id'          => 'integracoes',
                'name'        => 'Integrações e Scripts',
                'desc'        => 'Conectamos seus sistemas via API ou webhooks. Scripts Python para automação de relatórios, importação de dados ou tarefas repetitivas.',
                'price'       => 'Sob consulta',
                'icon'        => 'link',
                'whatsapp_msg'=> 'Olá! Tenho interesse em integrações entre sistemas.',
            ],
        ],
    ],

    'plans' => [
        'title'     => 'Escolha o nível de transformação da sua empresa',
        'subtitle'  => 'Cada plano representa um estágio de maturidade digital',
        'guarantee' => 'Sem fidelidade após 3 meses · Diagnóstico gratuito sem compromisso',
        'list'      => [
            [
                'id'       => 'essencial',
                'name'     => 'Essencial',
                'setup'    => 600,
                'monthly'  => 497,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Base digital profissional',
                'benefits' => [
                    'Site institucional (WordPress ou HTML)',
                    'Hospedagem + SSL + domínio configurado',
                    'Google Analytics + relatório mensal básico',
                    'Suporte técnico + correções e ajustes',
                    '1 reunião de acompanhamento por trimestre',
                ],
            ],
            [
                'id'       => 'profissional',
                'name'     => 'Profissional',
                'setup'    => 1200,
                'monthly'  => 997,
                'featured' => true,
                'badge'    => 'Mais Escolhido',
                'goal'     => 'Site + dados + automação básica',
                'benefits' => [
                    'Tudo do plano Essencial',
                    'Dashboard em Looker Studio ou Power BI',
                    'Até 2 automações (ex: chatbot WhatsApp, relatório automático)',
                    'Integração com Google Sheets ou banco de dados',
                    'Reunião mensal com plano de ação',
                ],
            ],
            [
                'id'       => 'empresarial',
                'name'     => 'Empresarial',
                'setup'    => 2500,
                'monthly'  => 1997,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Operação digital completa',
                'benefits' => [
                    'Tudo do plano Profissional',
                    'Sistema web sob medida (Laravel/PHP)',
                    'Automações avançadas + scripts Python',
                    'BI com múltiplas fontes de dados',
                    'Prioridade máxima + acompanhamento semanal',
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

    'faq' => [
        'title' => 'Dúvidas frequentes',
        'items' => [
            ['q' => 'Preciso ter equipe de TI?',                       'a' => 'Não. A OctaBit cuida da implementação e manutenção. Seu único papel é aprovar e usar.'],
            ['q' => 'Quanto tempo leva para ver resultados?',           'a' => 'Os primeiros ganhos aparecem nas primeiras semanas. Resultados consistentes se consolidam em 2 a 3 meses.'],
            ['q' => 'Posso cancelar quando quiser?',                    'a' => 'Sim. Após os 3 primeiros meses de implantação, você pode cancelar a qualquer momento sem multa.'],
            ['q' => 'Qual a diferença entre planos e soluções avulsas?','a' => 'Os planos incluem acompanhamento contínuo e evolução mensal. Soluções avulsas são projetos pontuais com entrega definida.'],
            ['q' => 'Funciona para qualquer tipo de empresa?',          'a' => 'Nosso foco são pequenas empresas com 2 a 20 funcionários que querem sair do improviso e crescer com estrutura.'],
            ['q' => 'E se eu não gostar do resultado?',                 'a' => 'Trabalhamos com ciclos de entrega e validação. Se o resultado não atender, ajustamos até ficar certo. Após os 3 primeiros meses, você pode cancelar sem multa.'],
            ['q' => 'Qual o prazo de entrega?',                         'a' => 'O site fica pronto em 7 a 15 dias úteis. Automações e dashboards são implantados em paralelo, com entregas semanais.'],
            ['q' => 'Como funciona o pagamento?',                       'a' => 'Implantação é paga à vista ou em até 3x. A mensalidade começa após a entrega e é cobrada via boleto ou Pix.'],
        ],
    ],

    'footer' => [
        'copyright' => '© 2026 OctaBit. Todos os direitos reservados.',
        'text'      => 'Estruturação digital estratégica para pequenas empresas.',
        'cnpj'      => '', // Preencher com CNPJ real
    ],
];

// Helper: format currency
function formatBRL($value) {
    return 'R$ ' . number_format($value, 0, ',', '.');
}

// Helper: WhatsApp URL with message and source tracking
function whatsappURL($message = '', $source = '') {
    global $config;
    $url = $config['contact']['whatsapp_url'];
    if ($message) {
        if ($source) $message .= " [via: {$source}]";
        $url .= '?text=' . urlencode($message);
    }
    return $url;
}

// Helper: safe output
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
