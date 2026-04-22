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
        'title'    => 'O que fazemos pela sua empresa',
        'subtitle' => 'Resultados reais, sem complicação',
        'items'    => [
            [
                'icon'  => 'globe',
                'title' => 'Sua empresa visível no Google',
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
                'title' => 'Seus números na tela, em tempo real',
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
                'title' => 'Atendimento e vendas no automático',
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
                'title' => 'Sistemas sob medida para seu negócio',
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
        'guarantee' => 'Sem fidelidade após 3 meses · Diagnóstico gratuito sem compromisso',
        'list'      => [
            [
                'id'       => 'essencial',
                'name'     => 'Essencial',
                'setup'    => 600,
                'monthly'  => 497,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Sua empresa visível e profissional',
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
                'goal'     => 'Visível + dados + atendimento automático',
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
                'goal'     => 'Operação totalmente organizada',
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
                'cta'   => 'Conhecer o OctaPonto',
                'url'   => '#',
            ],
            [
                'name'  => 'OctaVendas',
                'desc'  => 'Gestão comercial pelo WhatsApp. Controle de pedidos, acompanhamento de vendas e CRM simplificado para quem vende todo dia.',
                'tag'   => 'Vendas e CRM',
                'icon'  => 'zap',
                'cta'   => 'Conhecer o OctaVendas',
                'url'   => '#',
            ],
            [
                'name'  => 'OctaSite',
                'desc'  => 'Sites institucionais prontos. Escolha um modelo, personalize com sua marca e publique em minutos. Domínio e hospedagem inclusos.',
                'tag'   => 'Presença Digital',
                'icon'  => 'globe',
                'cta'   => 'Conhecer o OctaSite',
                'url'   => '#',
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
