<?php
/**
 * OctaBit — Configuração centralizada
 * Todos os dados, textos e configurações do site.
 */

$config = [
    'brand' => [
        'name'      => 'OctaBit',
        'tagline'   => 'Tecnologia para pequenas empresas com operação',
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
        ['text' => 'Produtos',  'href' => '/produtos'],
        ['text' => 'Serviços',  'href' => '/servicos'],
        ['text' => 'Planos',    'href' => '/planos'],
        ['text' => 'Sobre',     'href' => '/sobre'],
        ['text' => 'Contato',   'href' => '/contato'],
    ],

    'hero' => [
        'badge'    => 'Para lojas, oficinas, deliveries e empresas com equipe',
        'title'    => 'Ponto no papel e vendas sem controle? A gente resolve.',
        'subtitle' => '3 sistemas simples que organizam equipe, vendas e clientes — com WhatsApp integrado. Funciona no celular, sem precisar de TI.',
        'cta_primary'   => 'Testar grátis por 14 dias',
        'cta_secondary' => 'Ver os produtos',
    ],

    'problem' => [
        'title' => 'Reconhece alguma dessas situações?',
        'items' => [
            'Funcionário chega atrasado e você só descobre no final do mês — registro de ponto ainda é no papel',
            'Venda feita no WhatsApp que nunca virou registro e você perdeu o controle',
            'Não sabe se o mês fechou positivo sem sentar e somar tudo na planilha',
            'Cliente mandou mensagem e ninguém respondeu — perdeu a venda',
        ],
    ],

    'solution' => [
        'title' => '3 sistemas que resolvem sua operação',
        'steps' => [
            ['icon' => 'activity',    'title' => 'Organize sua equipe',    'desc' => 'Registro de ponto com reconhecimento facial pelo celular. Banco de horas, escalas e férias automáticos.'],
            ['icon' => 'zap',         'title' => 'Controle suas vendas',   'desc' => 'Pedidos, pagamentos, rotas de entrega e WhatsApp integrado. Tudo num painel.'],
            ['icon' => 'briefcase',   'title' => 'Gerencie seus clientes', 'desc' => 'Orçamentos, cobranças, contratos e histórico de cada cliente. CRM simples que funciona.'],
        ],
    ],

    'services' => [
        'title'    => 'Também estruturamos sua presença digital',
        'subtitle' => 'Além dos sistemas, colocamos sua empresa no Google e automatizamos seu atendimento',
        'items'    => [
            [
                'icon'  => 'globe',
                'title' => 'Seu negócio no Google em 15 dias',
                'desc'  => 'Site profissional com domínio, e-mail e posicionamento. Seus clientes te encontram quando buscam.',
                'deliverables' => [
                    'Site pronto com sua marca e conteúdo',
                    'Aparecendo nas buscas do Google',
                    'Domínio, e-mail e hospedagem incluídos',
                    'Atualizações e suporte contínuo',
                ],
            ],
            [
                'icon'  => 'bar-chart-2',
                'title' => 'Painel com seus números no celular',
                'desc'  => 'Faturamento, vendas e indicadores num dashboard visual. Sem abrir planilha.',
                'deliverables' => [
                    'Painel com faturamento, ticket médio e conversão',
                    'Dados atualizados automaticamente',
                    'Visão por período, produto ou canal',
                    'Acesso pelo celular ou computador',
                ],
            ],
            [
                'icon'  => 'zap',
                'title' => 'WhatsApp atendendo 24h — sem você',
                'desc'  => 'Respostas automáticas, qualificação de leads e envio de promoções enquanto você foca na operação.',
                'deliverables' => [
                    'Respostas automáticas no WhatsApp',
                    'Qualificação de leads sem intervenção',
                    'Envio automático de promoções e avisos',
                    'Relatórios e notificações automáticas',
                ],
            ],
            [
                'icon'  => 'tool',
                'title' => 'Integração entre seus sistemas',
                'desc'  => 'Conectamos suas ferramentas e eliminamos retrabalho. Tudo conversando entre si.',
                'deliverables' => [
                    'Integração entre sistemas existentes',
                    'Automação de processos repetitivos',
                    'Manutenção e evolução contínua',
                    'Treinamento para sua equipe operar',
                ],
            ],
        ],
    ],

    'target_audience' => [
        'title' => 'Para quem é a OctaBit?',
        'items' => [
            ['icon' => 'shopping-bag', 'text' => 'Lojas e comércios que controlam vendas no caderno ou planilha'],
            ['icon' => 'truck',        'text' => 'Deliveries e distribuidoras com pedidos desorganizados no WhatsApp'],
            ['icon' => 'tool',         'text' => 'Oficinas e prestadores de serviço sem controle de clientes'],
            ['icon' => 'users',        'text' => 'Qualquer empresa com equipe que ainda faz registro de ponto no papel'],
        ],
    ],

    'authority' => [
        'title' => 'Resultados que já entregamos',
        'items' => [
            ['number' => '8+',   'label' => 'Meses de retenção média',   'desc' => 'Clientes que ficam porque veem resultado real.'],
            ['number' => '-70%', 'label' => 'Menos retrabalho',          'desc' => 'Redução média de trabalho manual com automações.'],
            ['number' => '30',   'label' => 'Dias para o 1º resultado',  'desc' => 'Da contratação ao sistema funcionando.'],
        ],
    ],

    'portfolio' => [
        'title' => 'Empresas que já organizaram a operação',
        'items' => [
            ['name' => 'KS Oficina',        'desc' => 'Oficina mecânica que saiu da invisibilidade digital para o Top 3 do Google local com site profissional e SEO.', 'tag' => 'Oficina · Presença Digital', 'quote' => 'Saímos do zero no digital para o Top 3 do Google em menos de 3 meses.', 'author' => 'Proprietário'],
            ['name' => 'Sabor à Domicílio',  'desc' => 'Delivery que reduziu 70% do retrabalho com sistema de pedidos via WhatsApp e painel de controle.', 'tag' => 'Delivery · Automação + Vendas', 'quote' => 'Antes era tudo no papel e no WhatsApp. Hoje o sistema faz 70% do trabalho sozinho.', 'author' => 'Fundadora'],
        ],
    ],

    'catalog' => [
        'title'    => 'Soluções prontas',
        'subtitle' => 'Projetos com escopo definido. Fale com a gente para saber mais.',
        'items'    => [
            [
                'id'          => 'site-profissional',
                'name'        => 'Site Profissional',
                'desc'        => 'Site pronto com domínio, e-mail, hospedagem e posicionamento no Google. Sua empresa visível para quem procura.',
                'icon'        => 'globe',
                'whatsapp_msg'=> 'Olá! Tenho interesse em um site profissional.',
            ],
            [
                'id'          => 'painel-vendas',
                'name'        => 'Painel de Vendas',
                'desc'        => 'Dashboard com seus números de faturamento, vendas e conversão. Atualização automática, acesso pelo celular.',
                'icon'        => 'bar-chart-2',
                'whatsapp_msg'=> 'Olá! Tenho interesse no Painel de Vendas.',
            ],
            [
                'id'          => 'automacao-whatsapp',
                'name'        => 'Automação de WhatsApp',
                'desc'        => 'Seu WhatsApp atendendo, respondendo dúvidas e qualificando clientes automaticamente, 24h por dia.',
                'icon'        => 'zap',
                'whatsapp_msg'=> 'Olá! Tenho interesse na Automação de WhatsApp.',
            ],
            [
                'id'          => 'sistema-sob-medida',
                'name'        => 'Sistema sob medida',
                'desc'        => 'Sistema exclusivo para resolver um problema específico da sua operação, integrado ao que você já usa.',
                'icon'        => 'cpu',
                'whatsapp_msg'=> 'Olá! Tenho interesse em um sistema sob medida.',
            ],
        ],
    ],

    'plans' => [
        'title'     => 'Escolha o plano certo para o tamanho da sua operação',
        'subtitle'  => 'Do controle básico à operação no piloto automático',
        'guarantee' => 'Sem fidelidade após 3 meses · Teste grátis por 14 dias',
        'list'      => [
            [
                'id'       => 'essencial',
                'name'     => 'Essencial',
                'setup'    => 600,
                'monthly'  => 497,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Para quem precisa sair do papel',
                'benefits' => [
                    'Registro de ponto com reconhecimento facial pelo celular',
                    'Site profissional no Google',
                    'E-mail @suaempresa.com.br',
                    'Suporte técnico incluído',
                    'Relatório trimestral de resultados',
                ],
            ],
            [
                'id'       => 'profissional',
                'name'     => 'Profissional',
                'setup'    => 1200,
                'monthly'  => 997,
                'featured' => true,
                'badge'    => 'Mais Escolhido',
                'goal'     => 'Para quem quer controlar vendas e equipe',
                'benefits' => [
                    'Tudo do Essencial',
                    'Sistema de vendas e pedidos (OctaVendas)',
                    'WhatsApp atendendo clientes 24/7',
                    'Painel com faturamento e vendas no celular',
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
                'goal'     => 'Para quem quer a operação no piloto automático',
                'benefits' => [
                    'Tudo do Profissional',
                    'CRM completo (OctaCRM)',
                    'Automações ilimitadas: pedidos, cobranças, relatórios',
                    'Dashboard cruzando todas suas fontes de dados',
                    'Prioridade máxima + acompanhamento semanal',
                ],
            ],
        ],
    ],

    'about' => [
        'title' => 'Tecnologia que entende operação',
        'text'  => 'A OctaBit cria sistemas para pequenas empresas que têm equipe, operação e clientes — mas ainda controlam tudo no papel, planilha ou WhatsApp. Nossos produtos (OctaPonto, OctaVendas e OctaCRM) foram feitos para quem precisa de resultado, não de complexidade.',
        'mission' => 'Organizar a operação de pequenas empresas com tecnologia simples, acessível e que funciona desde o primeiro dia.',
        'vision'  => 'Ser a plataforma de referência para pequenas empresas organizarem equipe, vendas e clientes sem precisar de TI.',
    ],

    'products' => [
        'title'    => 'Nossos Produtos',
        'subtitle' => 'Sistemas prontos para usar, feitos para quem tem operação e equipe',
        'items'    => [
            [
                'name'  => 'OctaPonto',
                'desc'  => 'Gestão de RH simplificada. Registro de ponto com reconhecimento facial pelo celular, banco de horas, escalas, férias e relatórios automáticos. Para qualquer empresa com funcionários.',
                'tag'   => 'Gestão de RH',
                'icon'  => 'activity',
                'cta'   => 'Conhecer o OctaPonto',
                'url'   => '/produtos/octaponto',
            ],
            [
                'name'  => 'OctaVendas',
                'desc'  => 'Gestão de vendas e pedidos. Controle de pedidos, rotas de entrega, integração com WhatsApp e aprovação de pagamentos. Para lojas, deliveries e distribuidoras.',
                'tag'   => 'Gestão de Vendas',
                'icon'  => 'zap',
                'cta'   => 'Conhecer o OctaVendas',
                'url'   => '/produtos/octavendas',
            ],
            [
                'name'  => 'OctaCRM',
                'desc'  => 'CRM para prestadores de serviço. Clientes, orçamentos, cobranças, contratos e histórico. Para oficinas, clínicas e escritórios.',
                'tag'   => 'Gestão de Clientes',
                'icon'  => 'briefcase',
                'cta'   => 'Conhecer o OctaCRM',
                'url'   => '/produtos/octacrm',
            ],
        ],
    ],

    'lead_magnet' => [
        'title'    => 'Teste grátis por 14 dias',
        'subtitle' => 'Escolha o sistema que resolve seu problema e comece a usar hoje. Sem cartão, sem compromisso.',
        'button'   => 'Começar teste grátis',
    ],

    'faq' => [
        'title' => 'Dúvidas frequentes',
        'items' => [
            ['q' => 'Funciona para meu tipo de empresa?',              'a' => 'Se você tem equipe, vende produtos/serviços ou precisa controlar clientes, sim. Atendemos lojas, oficinas, deliveries, distribuidoras, clínicas e qualquer pequena empresa com operação.'],
            ['q' => 'Preciso ter equipe de TI?',                       'a' => 'Não. Os sistemas são prontos para usar e a gente cuida de toda a configuração. Seu papel é aprovar e usar.'],
            ['q' => 'Quanto tempo leva para começar a usar?',           'a' => 'O teste é imediato. A implantação completa fica pronta em 7 a 30 dias, dependendo da complexidade.'],
            ['q' => 'Posso usar só o OctaPonto sem os outros?',         'a' => 'Sim. Cada produto funciona de forma independente. Você começa com o que precisa e adiciona os outros quando quiser.'],
            ['q' => 'Posso cancelar quando quiser?',                    'a' => 'Sim. Após os 3 primeiros meses de implantação, você pode cancelar a qualquer momento sem multa.'],
            ['q' => 'E se eu não gostar do resultado?',                 'a' => 'Trabalhamos com teste grátis de 14 dias. Se não funcionar para você, é só não continuar.'],
            ['q' => 'Minha equipe vai conseguir usar?',                 'a' => 'Sim. Os sistemas foram feitos para serem simples. Se sua equipe usa WhatsApp, consegue usar nossos produtos.'],
            ['q' => 'Como funciona o pagamento?',                       'a' => 'Implantação é paga à vista ou em até 3x. A mensalidade começa após o teste grátis e é cobrada via boleto ou Pix.'],
        ],
    ],

    'footer' => [
        'copyright' => '© 2026 OctaBit. Todos os direitos reservados.',
        'text'      => 'Sistemas para pequenas empresas com operação: ponto, vendas e clientes.',
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
