<?php
/**
 * OctaBit — Configuração centralizada
 * Todos os dados, textos e configurações do site.
 */

$config = [
    'brand' => [
        'name'      => 'OctaBit',
        'tagline'   => 'Sistemas para pequenas empresas',
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
        'badge'    => 'Para lojas, oficinas, deliveries e negócios com equipe',
        'title'    => 'Sua operação organizada em 30 dias, sem complicar sua rotina.',
        'subtitle' => 'Registro de ponto com reconhecimento facial, vendas com WhatsApp sob controle e clientes organizados em um CRM simples.',
        'cta_primary'   => 'Testar grátis por 14 dias',
        'cta_secondary' => 'Ver os produtos',
    ],

    'problem' => [
        'title' => 'Sua empresa cresce, mas a operação não acompanha?',
        'items' => [
            'Equipe sem controle claro de jornada e produtividade',
            'Vendas espalhadas em conversas e anotações sem padrão',
            'Clientes sem histórico, follow-up e prioridade definidos',
            'Você resolve tudo no braço e falta tempo para crescer',
        ],
    ],

    'solution' => [
        'title' => 'Da desorganização para o controle em 3 passos',
        'steps' => [
            ['icon' => 'search',      'title' => 'Diagnóstico rápido', 'desc' => 'Mapeamos a principal dor operacional e definimos o sistema certo para começar.'],
            ['icon' => 'tool',        'title' => 'Implantação guiada', 'desc' => 'Configuramos, treinamos sua equipe e colocamos a operação para rodar sem ruído.'],
            ['icon' => 'bar-chart-2', 'title' => 'Acompanhamento',     'desc' => 'Ajustamos processos com base em dados para manter ganho real mês a mês.'],
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
        'title'    => 'O que fazemos pela sua empresa',
        'subtitle' => 'Resultados reais, sem complicação',
        'items'    => [
            [
                'icon'  => 'globe',
                'title' => 'Clientes te encontrando no Google',
                'desc'  => 'Criamos seu site profissional com domínio próprio, e-mail e posicionamento para seus clientes te encontrarem.',
                'deliverables' => [
                    'Site pronto com sua marca e conteúdo',
                    'Aparecendo nas buscas do Google',
                    'Domínio, e-mail e hospedagem incluídos',
                    'Atualizações e suporte contínuo',
                ],
            ],
            [
                'icon'  => 'bar-chart-2',
                'title' => 'Adeus planilha: números em tempo real',
                'desc'  => 'Você acompanha faturamento, vendas e indicadores num painel visual atualizado automaticamente.',
                'deliverables' => [
                    'Painel com faturamento, ticket médio e conversão',
                    'Dados atualizados automaticamente',
                    'Visão por período, produto ou canal',
                    'Acesso pelo celular ou computador',
                ],
            ],
            [
                'icon'  => 'zap',
                'title' => 'WhatsApp organizado e produtivo',
                'desc'  => 'Seu WhatsApp responde, qualifica e organiza pedidos enquanto você foca no que importa.',
                'deliverables' => [
                    'Respostas automáticas no WhatsApp',
                    'Qualificação de leads sem intervenção',
                    'Envio automático de promoções e avisos',
                    'Relatórios e notificações automáticas',
                ],
            ],
            [
                'icon'  => 'tool',
                'title' => 'Sistema sob medida para sua operação',
                'desc'  => 'Quando nenhuma ferramenta pronta resolve, criamos a solução que encaixa na sua operação.',
                'deliverables' => [
                    'Sistema exclusivo para sua empresa',
                    'Integração com ferramentas que você já usa',
                    'Manutenção e evolução contínua',
                    'Treinamento para sua equipe operar',
                ],
            ],
        ],
    ],

    'target_audience' => [
        'title' => 'Para quem é a OctaBit?',
        'items' => [
            ['icon' => 'briefcase',  'text' => 'Pequenas empresas com 2 a 20 funcionários'],
            ['icon' => 'trending-up','text' => 'Negócios que querem sair do improviso e ganhar previsibilidade'],
            ['icon' => 'clipboard',  'text' => 'Processos manuais e falta de organização digital'],
            ['icon' => 'target',     'text' => 'Querem crescer com previsibilidade e controle'],
        ],
    ],

    'authority' => [
        'title' => 'Resultados que já entregamos',
        'items' => [
            ['number' => '10+',  'label' => 'Clientes satisfeitos',      'desc' => 'Operações organizadas com ganhos reais no dia a dia.'],
            ['number' => '70%',  'label' => 'Menos trabalho manual',     'desc' => 'Tempo devolvido para foco em venda e gestão.'],
            ['number' => '30',   'label' => 'Dias para o 1º resultado',  'desc' => 'Da implantação ao impacto visível na operação.'],
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
        'title'    => 'Soluções prontas',
        'subtitle' => 'Projetos com escopo e preço definidos',
        'items'    => [
            [
                'id'          => 'site-profissional',
                'name'        => 'Site Profissional',
                'desc'        => 'Site pronto com domínio, e-mail, hospedagem e posicionamento no Google. Sua empresa visível para quem procura.',
                'price'       => 'A partir de R$ 1.200',
                'icon'        => 'globe',
                'whatsapp_msg'=> 'Olá! Tenho interesse em um site profissional.',
            ],
            [
                'id'          => 'painel-vendas',
                'name'        => 'Painel de Vendas',
                'desc'        => 'Dashboard com seus números de faturamento, vendas e conversão. Atualização automática, acesso pelo celular.',
                'price'       => 'A partir de R$ 1.900',
                'icon'        => 'bar-chart-2',
                'whatsapp_msg'=> 'Olá! Tenho interesse no Painel de Vendas.',
            ],
            [
                'id'          => 'automacao-whatsapp',
                'name'        => 'Automação de WhatsApp',
                'desc'        => 'Seu WhatsApp atendendo, respondendo dúvidas e qualificando clientes automaticamente, 24h por dia.',
                'price'       => 'A partir de R$ 1.400',
                'icon'        => 'zap',
                'whatsapp_msg'=> 'Olá! Tenho interesse na Automação de WhatsApp.',
            ],
            [
                'id'          => 'sistema-sob-medida',
                'name'        => 'Sistema sob medida',
                'desc'        => 'Sistema exclusivo para resolver um problema específico da sua operação, integrado ao que você já usa.',
                'price'       => 'Sob consulta',
                'icon'        => 'cpu',
                'whatsapp_msg'=> 'Olá! Tenho interesse em um sistema sob medida.',
            ],
        ],
    ],

    'plans' => [
        'title'     => 'Escolha o nível de transformação da sua empresa',
        'subtitle'  => 'Cada plano representa um estágio de maturidade digital',
        'guarantee' => 'Sem fidelidade após 3 meses · Comece com o que resolve sua maior dor hoje',
        'list'      => [
            [
                'id'       => 'essencial',
                'name'     => 'Essencial',
                'setup'    => 600,
                'monthly'  => 497,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Deixe de ser invisível e organize sua base digital',
                'benefits' => [
                    'Site pronto com sua marca e conteúdo',
                    'Domínio, e-mail profissional e hospedagem',
                    'Posicionamento básico no Google',
                    'Suporte técnico e ajustes incluídos',
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
                'goal'     => 'Visível, automatizado e com dados na mão',
                'benefits' => [
                    'Tudo do plano Essencial',
                    'Painel com seus números de vendas em tempo real',
                    'Até 2 automações (ex: WhatsApp automático, relatórios)',
                    'Integração com ferramentas que você já usa',
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
                'goal'     => 'Operação no piloto automático, com controle total',
                'benefits' => [
                    'Tudo do plano Profissional',
                    'Sistema exclusivo para sua operação',
                    'Automações avançadas ilimitadas',
                    'Painel completo com múltiplas fontes de dados',
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

    'products' => [
        'title'    => 'Nossos Produtos',
        'subtitle' => 'Ferramentas prontas para usar, com planos acessíveis',
        'items'    => [
            [
                'name'  => 'OctaPonto',
                'desc'  => 'Controle de jornada e ponto eletrônico. Registro de entrada e saída pelo celular, relatórios automáticos e gestão de equipes.',
                'tag'   => 'Gestão de Pessoas',
                'icon'  => 'activity',
                'image' => '/img/produtos/octaponto/dashboard.jpg',
                'cta'   => 'Conhecer o OctaPonto',
                'url'   => '/produtos/octaponto',
            ],
            [
                'name'  => 'OctaVendas',
                'desc'  => 'Gestão comercial pelo WhatsApp. Controle de pedidos, acompanhamento de vendas e CRM simplificado para quem vende todo dia.',
                'tag'   => 'Vendas e CRM',
                'icon'  => 'zap',
                'image' => '/img/produtos/octavendas/dashboard.jpg',
                'cta'   => 'Conhecer o OctaVendas',
                'url'   => '/produtos/octavendas',
            ],
            [
                'name'  => 'OctaCRM',
                'desc'  => 'CRM para prestadores de serviço. Clientes, orçamentos, cobranças, contratos e histórico em um só lugar.',
                'tag'   => 'Gestão de Clientes',
                'icon'  => 'briefcase',
                'image' => '/img/produtos/octacrm/dashboard.jpg',
                'cta'   => 'Conhecer o OctaCRM',
                'url'   => '/produtos/octacrm',
            ],
        ],
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
        'text'      => 'Sistemas práticos para organizar equipe, vendas e clientes.',
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
