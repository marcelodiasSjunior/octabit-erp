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
        'badge'    => 'Sistemas práticos para organizar seu dia a dia',
        'title'    => 'Gestão de equipe, vendas e clientes em um só lugar.',
        'subtitle' => 'Simplificamos sua rotina substituindo processos manuais por tecnologia prática. Mais controle para você, mais agilidade para seu time.',
        'cta_primary'   => 'Testar gratuitamente',
        'cta_secondary' => 'Conhecer Soluções',
    ],

    'problem' => [
        'title' => 'Sua gestão ainda depende de tarefas manuais?',
        'items' => [
            'Equipe: falta de clareza sobre jornada e produtividade diária',
            'Vendas: informações espalhadas que dificultam o acompanhamento',
            'Clientes: histórico fragmentado e falta de avisos automáticos',
            'Tempo: excesso de rotinas operacionais que travam o crescimento',
        ],
    ],

    'solution' => [
        'title' => 'Centralize sua operação com agilidade',
        'steps' => [
            ['icon' => 'search',      'title' => 'Análise de Fluxo', 'desc' => 'Entendemos sua rotina para identificar onde a tecnologia pode economizar tempo e reduzir erros.'],
            ['icon' => 'tool',        'title' => 'Implantação Ágil', 'desc' => 'Configuramos o sistema e treinamos seu time. Você começa a ver os benefícios em poucos dias.'],
            ['icon' => 'bar-chart-2', 'title' => 'Evolução e Suporte', 'desc' => 'Acompanhamos seu crescimento com ajustes contínuos e métricas claras para sua decisão.'],
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
        'title'    => 'Serviços de software sob medida para o seu negócio',
        'subtitle' => 'Atuamos como software house para tirar projetos do papel, evoluir operações e construir produtos digitais com aderência ao que sua empresa realmente precisa.',
        'items'    => [
            [
                'icon'  => 'globe',
                'title' => 'Sites institucionais e comerciais',
                'desc'  => 'Criamos sites institucionais, páginas comerciais e estruturas web com foco em presença digital, credibilidade e geração de oportunidades.',
                'deliverables' => [
                    'Site alinhado à marca e ao posicionamento da empresa',
                    'Estrutura pronta para institucional, captação ou vendas',
                    'Publicação, ajustes e evolução contínua',
                    'Base preparada para SEO e integrações futuras',
                ],
            ],
            [
                'icon'  => 'cpu',
                'title' => 'Sistemas web sob demanda',
                'desc'  => 'Desenvolvemos sistemas mais complexos conforme a necessidade do cliente, com regras de negócio, painéis administrativos e fluxos personalizados.',
                'deliverables' => [
                    'Levantamento da necessidade e arquitetura da solução',
                    'Fluxos, permissões e cadastros sob medida',
                    'Painel administrativo e operação centralizada',
                    'Evolução contínua conforme o negócio amadurece',
                ],
            ],
            [
                'icon'  => 'zap',
                'title' => 'Automações, integrações e eficiência operacional',
                'desc'  => 'Integramos sistemas, APIs e processos para reduzir retrabalho, conectar ferramentas e automatizar rotinas críticas da operação.',
                'deliverables' => [
                    'Integração entre plataformas e ferramentas existentes',
                    'Automação de processos internos e atendimento',
                    'Sincronização de dados entre operação, vendas e gestão',
                    'Redução de tarefas manuais e gargalos operacionais',
                ],
            ],
            [
                'icon'  => 'tool',
                'title' => 'Aplicativos mobile e produtos digitais',
                'desc'  => 'Projetamos e desenvolvemos aplicativos mobile e outros produtos digitais quando a solução precisa estar na mão do usuário ou da equipe.',
                'deliverables' => [
                    'Apps voltados ao uso interno ou ao cliente final',
                    'Experiência alinhada ao contexto real de uso',
                    'Backend, painel e integrações quando necessário',
                    'Suporte técnico e roadmap de evolução',
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
            ['number' => '100+',  'label' => 'Operações reorganizadas',      'desc' => 'Equipes mais produtivas, operações mais lucrativas.'],
            ['number' => '70%',   'label' => 'Menos retrabalho manual',     'desc' => 'Horas recuperadas para foco em vendas e crescimento.'],
            ['number' => '2-3',   'label' => 'Semanas para resultado visível',  'desc' => 'Do diagnóstico ao impacto real na operação.'],
        ],
    ],

    'portfolio' => [
        'title' => 'Nossos clientes',
        'items' => [
            ['name' => 'KS Oficina',        'desc' => 'Oficina mecânica que saiu da invisibilidade digital para o Top 3 do Google local com site profissional e SEO.', 'tag' => 'Cliente · Presença Digital', 'quote' => 'Saímos do zero no digital para o Top 3 do Google em menos de 3 meses.', 'author' => 'Proprietário'],
            ['name' => 'Sabor à Domicílio',  'desc' => 'Delivery que reduziu 70% do retrabalho com automação de pedidos via WhatsApp e painel administrativo.', 'tag' => 'Cliente · Automação', 'quote' => 'Antes era tudo no papel e no WhatsApp. Hoje o sistema faz 70% do trabalho sozinho.', 'author' => 'Fundador'],
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
        'title'     => 'Consultoria recorrente PTE-I com execução guiada',
        'subtitle'  => 'Planos para evoluir templates institucionais, dashboards BI e automações leves com rotina clara de acompanhamento.',
        'guarantee' => '✓ Sem fidelidade após 3 meses · ✓ Dados sempre seus · ✓ Cancela quando quiser',
        'list'      => [
            [
                'id'       => 'essencial',
                'name'     => 'Começar',
                'setup'    => 600,
                'monthly'  => 497,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Para estruturar uma base digital confiável com escopo objetivo e acompanhamento mensal',
                'benefits' => [
                    '1 template institucional configurado para seu contexto',
                    'Ajustes mensais em conteúdo e layout de baixa complexidade',
                    'Dashboard BI inicial com indicadores essenciais',
                    '1 automação leve para rotina operacional',
                    '1 reunião mensal de acompanhamento e próximos passos',
                ],
            ],
            [
                'id'       => 'profissional',
                'name'     => 'Crescer',
                'setup'    => 1200,
                'monthly'  => 997,
                'featured' => true,
                'badge'    => 'Mais Escolhido',
                'goal'     => 'Para ganhar ritmo de melhoria contínua com mais visibilidade e automação da operação',
                'benefits' => [
                    'Tudo do plano Começar',
                    'Evolução do template em até duas frentes por mês',
                    'Dashboard BI gerencial com leitura comparativa',
                    'Até 2 automações leves ativas e monitoradas',
                    'Priorização quinzenal com base no método PTE-I',
                    '2 reuniões por mês para análise e decisão',
                ],
            ],
            [
                'id'       => 'empresarial',
                'name'     => 'Escalar',
                'setup'    => 2500,
                'monthly'  => 1997,
                'featured' => false,
                'badge'    => null,
                'goal'     => 'Para operar com governança estratégica, previsibilidade e decisões orientadas por dados',
                'benefits' => [
                    'Tudo do plano Crescer',
                    'Roadmap trimestral com metas e marcos PTE-I',
                    'Painel BI executivo com visão integrada da operação',
                    'Ajustes e automações leves priorizados por impacto',
                    'Acompanhamento semanal para destravar decisões críticas',
                    'Suporte prioritário para temas do plano vigente',
                ],
            ],
        ],
    ],

    'differentiation' => [
        'title' => 'Por que escolher OctaBit vs outras agências?',
        'items' => [
            [
                'icon'  => 'trending-up',
                'title' => '90 dias para resultado tangível',
                'desc'  => 'Não vendemos sites bonitos. Vendemos crescimento. 40-50% aumento em faturamento, operação organizada e você liberado para vender.',
            ],
            [
                'icon'  => 'zap',
                'title' => 'Implementação rápida (1 semana)',
                'desc'  => 'Outras agências levam meses. Entregamos funcionando em uma semana, com sua equipe treinada e primeira automação rodando.',
            ],
            [
                'icon'  => 'briefcase',
                'title' => 'Acompanhamento real (não é um projeto)',
                'desc'  => 'Não é "entrega e tchau". Você tem especialista disponível, ajustes contínuos, evolução mês a mês. Crescimento sem limite.',
            ],
            [
                'icon'  => 'activity',
                'title' => 'Sem fidelidade, sem tramoia',
                'desc'  => 'Após 3 meses você pode cancelar quando quiser. Sem contrato, sem multa, sem dados presos. Você fica porque vale a pena, não por contrato.',
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
        'subtitle' => 'Soluções prontas que resolvem seu problema real',
        'items'    => [
            [
                'name'  => 'OctaPonto',
                'desc'  => 'Seu time registra ponto pelo celular, você vê tudo em tempo real + economiza até R$200/mês em retrabalho manual.',
                'tag'   => 'Gestão de Pessoas',
                'icon'  => 'activity',
                'image' => '/img/produtos/octaponto/dashboard.jpg',
                'cta'   => 'Testar agora',
                'url'   => '/produtos/octaponto',
            ],
            [
                'name'  => 'OctaVendas',
                'desc'  => 'WhatsApp respondendo clientes 24h + toda venda registrada = você vende mais enquanto dorme. Aumento médio de 30% em vendas.',
                'tag'   => 'Vendas e CRM',
                'icon'  => 'zap',
                'image' => '/img/produtos/octavendas/dashboard.jpg',
                'cta'   => 'Testar agora',
                'url'   => '/produtos/octavendas',
            ],
            [
                'name'  => 'OctaCRM',
                'desc'  => 'Cliente nunca esquecido, próximo passo sempre claro = taxa de conversão +40%. Feche mais orçamentos, sem esforço.',
                'tag'   => 'Gestão de Clientes',
                'icon'  => 'briefcase',
                'image' => '/img/produtos/octacrm/dashboard.jpg',
                'cta'   => 'Testar agora',
                'url'   => '/produtos/octacrm',
            ],
        ],
    ],

    'results' => [
        'title'    => 'Seu resultado esperado',
        'subtitle' => 'Qual será sua situação após 90 dias com OctaBit',
        'items'    => [
            [
                'period' => '30 dias',
                'goal'   => 'Operação visível e controlável',
                'outcomes' => [
                    '✓ Equipe registrando ponto automaticamente',
                    '✓ Você vendo dados em tempo real no painel',
                    '✓ WhatsApp respondendo clientes 24h',
                    '✓ Primeira automação funcionando e economizando tempo',
                ],
            ],
            [
                'period' => '60 dias',
                'goal'   => 'Crescimento visível em faturamento',
                'outcomes' => [
                    '✓ 15-20% mais vendas (automação de qualificação)',
                    '✓ 30-40% menos retrabalho (tudo automatizado)',
                    '✓ Time mais produtivo (sem tarefas manuais)',
                    '✓ Clientes com histórico e follow-up automático',
                ],
            ],
            [
                'period' => '90 dias',
                'goal'   => 'Operação que roda sem você',
                'outcomes' => [
                    '✓ 40-50% de crescimento acumulado em vendas',
                    '✓ Você saindo de tarefas operacionais',
                    '✓ Dashboard mostrando tudo que importa em tempo real',
                    '✓ Sistema escalável: pronto para duplicar sem caos',
                ],
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
            ['q' => 'Quanto tempo leva para ver resultados? Preciso esperar 90 dias?',           'a' => 'Não. Os primeiros resultados aparecem nas 2 primeiras semanas: painel funcionando, equipe registrando ponto, WhatsApp respondendo. Aos 30 dias você já vê impacto em faturamento. Aos 90 dias é transformação completa.'],
            ['q' => 'Qual é o custo exato? Tem taxa escondida?',                       'a' => 'Não tem taxa escondida. Você paga: (1) Setup único (R$ 600-2.500) = implementação e treinamento, (2) Mensal (R$ 497-1.997) = acesso ao sistema + suporte + atualizações. Tudo transparente desde o início. Sem fidelidade após 3 meses.'],
            ['q' => 'Posso cancelar quando quiser? E perco os dados?',                    'a' => 'Sim, cancela quando quiser (após 3 meses de implementação). Seus dados continuam sendo seus — ninguém retém nada. Você pode levar para outro sistema ou continuar usando.'],
            ['q' => 'Como funciona a implementação? Quanto tempo minha operação fica parada?',                       'a' => 'Zero downtime. Implementamos em paralelo com sua operação atual. Você escolhe quando ativa cada automação: semana 1 registra ponto, semana 2 WhatsApp, semana 3 painel. Sem interrupção, sem risco.'],
            ['q' => 'Preciso ter equipe de TI ou conhecimento técnico?',                       'a' => 'Não. A OctaBit cuida de tudo: implementação, manutenção, updates, integração com suas ferramentas. Seu time só aprende a usar. Nosso especialista fica disponível para ajustar quando precisar.'],
            ['q' => 'E se eu não gostar do resultado? Vocês garantem?',                 'a' => 'Sim. Trabalhamos com ciclos de entrega semanal e validação conjunta. Se a entrega não atender, ajustamos. Se após 3 meses o resultado não for o esperado, você cancela sem multa. Somos pagos por resultado, não por contrato.'],
            ['q' => 'Minha empresa é muito pequena/grande demais para vocês?',          'a' => 'Nosso foco principal são pequenas empresas com 2 a 20 funcionários que querem estrutura de empresa maior. Empresas menores precisam de menos features (preço menor). Empresas maiores geralmente precisam de sistema sob medida — conversa conosco.'],
            ['q' => 'Funciona para meu tipo de negócio? (Loja, Oficina, Delivery, etc)',          'a' => 'Funciona. Já implementamos com sucesso em lojas, oficinas, deliveries, prestadores de serviço e consultórios. Se seu negócio tem equipe e vendas, a OctaBit organiza. Cada um com sua configuração específica.'],
            ['q' => 'Como é feito o acompanhamento? Fico sozinho depois?',                       'a' => 'Não. Plano Crescer = reunião mensal. Plano Escalar = acompanhamento semanal + estratégia de crescimento. Você não fica sozinho — temos especialista disponível para ajustar processos e ensinar sua equipe.'],
            ['q' => 'Qual é a diferença entre um plano e uma solução avulsa?',          'a' => 'Planos são subscrição contínua com evolução mês a mês (você cresce com o sistema). Soluções avulsas são projetos pontuais com entrega única (ex: site profissional, painel específico). Plano = transformação contínua; Avulso = projeto fechado.'],
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
