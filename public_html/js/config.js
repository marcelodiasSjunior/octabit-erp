// ===== CONFIGURAÇÕES DA OCTABIT - VERSÃO FINAL COM MELHORIAS =====
const OCTABIT_CONFIG = {
    // Contato
    whatsapp: {
        numero: "5541987762489",
        url: "https://wa.me/5541987762489"
    },
    email: {
        endereco: "octabit@octabit.tech",
        display: "octabit@octabit.tech"
    },

    // Google Apps Script URL (ATUALIZADA)
    googleAppsScriptUrl: "https://script.google.com/macros/s/AKfycbzq79u0pQJwfx2qY39DiFP5TrZjgiWQOlqFzsQL2bueC2JJMlTsY7aPTIXccWp90-zcow/exec",

    // Header
    header: {
        logo: "img/logo.svg",
        menu: [
            { texto: "Problema", link: "#problema-solucao" },
            { texto: "Metodologia", link: "#metodologia" },
            { texto: "Serviços", link: "#servicos-paraquem" },
            // { texto: "Casos", link: "#casos" },
            { texto: "Planos", link: "#planos" }
        ],
        cta: "Diagnóstico gratuito →"
    },

    // HERO
    hero: {
        titulo: "Sua empresa ainda depende de planilhas e processos manuais?",
        subtitulo: "A gente organiza tudo em até 30 dias. Estruturação digital completa: sites, automações, dashboards e acompanhamento estratégico. Resultados previsíveis e controle total.",
        botao: "Quero meu diagnóstico gratuito →",
        botaoSecundario: "Falar com especialista"
    },

    // Seção combinada: Problema + Como funciona
    problemaSolucao: {
        problema: {
            titulo: "O problema que sua empresa enfrenta",
            cards: [
                "Horas perdidas com tarefas repetitivas",
                "Erros manuais que custam caro",
                "Dependência de pessoas, não de processos",
                "Concorrentes mais organizados e rápidos"
            ]
        },
        solucao: {
            titulo: "Como resolvemos em 3 passos",
            passos: [
                {
                    icone: "search",
                    titulo: "1. Diagnóstico Profundo",
                    descricao: "Mapeamos seus processos, dores e objetivos para criar um roteiro personalizado."
                },
                {
                    icone: "tool",
                    titulo: "2. Implantação Estratégica",
                    descricao: "Estruturamos a tecnologia, automatizamos tarefas e organizamos sua operação."
                },
                {
                    icone: "bar-chart-2",
                    titulo: "3. Acompanhamento Contínuo",
                    descricao: "Monitoramos os resultados e ajustamos a rota para garantir o crescimento."
                }
            ]
        }
    },

    // Seção Metodologia Exclusiva
    metodologia: {
        titulo: "Nossa Metodologia Exclusiva: PTE-I",
        subtitulo: "Posicionamento, Tecnologia, Engenharia e Inteligência – um processo testado para alavancar seu negócio.",
        passos: [
            {
                icone: "eye",
                titulo: "Posicionamento",
                descricao: "Definimos sua identidade visual, mensagem e presença digital para atrair os clientes certos."
            },
            {
                icone: "settings",
                titulo: "Tecnologia",
                descricao: "Implementamos site, sistemas e infraestrutura que fazem seu negócio funcionar."
            },
            {
                icone: "trending-up",
                titulo: "Engenharia",
                descricao: "Automatizamos processos e integramos ferramentas para eliminar tarefas manuais."
            },
            {
                icone: "cpu",
                titulo: "Inteligência",
                descricao: "Entregamos dados, métricas e insights para decisões mais assertivas."
            }
        ],
        cta: "Quero aplicar o método →"
    },

    // Seção Serviços
    servicos: {
        titulo: "Serviços que estruturam seu negócio",
        subtitulo: "Da base digital à inteligência de dados.",
        itens: [
            {
                icone: "globe",
                titulo: "Estruturação de Presença Digital",
                descricao: "Criação de sites profissionais, SEO técnico, hospedagem segura e integração com ferramentas de rastreamento."
            },
            {
                icone: "bar-chart-2",
                titulo: "Inteligência de Dados e Métricas",
                descricao: "Dashboards de vendas, BI, métricas de conversão e canais de aquisição para decisões baseadas em dados."
            },
            {
                icone: "zap",
                titulo: "Automação de Processos",
                descricao: "Automações operacionais, integrações entre sistemas, automação de WhatsApp e tarefas administrativas."
            },
            {
                icone: "users",
                titulo: "Acompanhamento Estratégico",
                descricao: "Monitoramento contínuo, consultorias periódicas e melhorias iterativas para evolução constante."
            }
        ]
    },

    // Seção Para quem é (ICP)
    paraQuem: {
        titulo: "Para quem é a OctaBit?",
        itens: [
            {
                icone: "briefcase",
                texto: "Pequenas empresas com 2 a 20 funcionários"
            },
            {
                icone: "trending-up",
                texto: "Faturamento entre R$ 20 mil e R$ 200 mil por mês"
            },
            {
                icone: "clipboard",
                texto: "Processos manuais, planilhas e falta de organização digital"
            },
            {
                icone: "target",
                texto: "Querem crescer com previsibilidade e controle"
            }
        ]
    },

    // Seção Demonstração Visual
    demonstracao: {
        titulo: "Veja na prática como a OctaBit transforma negócios",
        itens: [
            {
                imagem: "https://placehold.co/600x400/1e293b/3b82f6?text=Dashboard+de+Vendas",
                titulo: "Dashboard de Vendas em Tempo Real",
                descricao: "Acompanhe faturamento, ticket médio e conversão de forma clara e intuitiva."
            },
            {
                imagem: "https://placehold.co/600x400/1e293b/3b82f6?text=Automação+WhatsApp",
                titulo: "Automação de WhatsApp",
                descricao: "Respostas automáticas, envio de mensagens em massa e integração com CRM."
            },
            {
                imagem: "https://placehold.co/600x400/1e293b/3b82f6?text=Site+Profissional",
                titulo: "Site Profissional Otimizado",
                descricao: "Design responsivo, SEO técnico e integração com analytics."
            }
        ]
    },

    // Seção Sobre
    sobre: {
        titulo: "Estruturar pequenas empresas através da tecnologia",
        descricao: "A OctaBit nasceu para organizar o caos digital de pequenas empresas. Combinamos presença digital, automação e inteligência de dados para que empreendedores tenham controle total do negócio e possam crescer com clareza. Tratamos o seu negócio como se fosse nosso.",
        icone: "briefcase"
    },

    // Seção Autoridade/Resultados
    autoridade: {
        titulo: "Resultados que o mercado comprova",
        cards: [
            {
                icone: "bar-chart-2",
                numero: "+40%",
                label: "Aumento de faturamento",
                descricao: "Empresas com presença digital estruturada crescem em média 40% mais rápido"
            },
            {
                icone: "trending-down",
                numero: "-30%",
                label: "Redução de custos",
                descricao: "Automação de processos reduz custos operacionais em até 30%"
            },
            {
                icone: "users",
                numero: "80%",
                label: "Consumidores online",
                descricao: "80% dos clientes pesquisam online antes de comprar de um negócio local"
            }
        ]
    },

    // Seção Casos de Sucesso
    casos: {
        titulo: "Quem já estruturou o crescimento com a OctaBit",
        lista: [
            {
                nome: "KS Oficina",
                depoimento: "Antes a gente controlava tudo em planilha e vivia perdido. Hoje consigo ver os serviços, faturamento e clientes em um só lugar. Já economiza um bom tempo no dia a dia.",
                resultado: "+35% de faturamento em 3 meses",
                foto: "img/cliente1.jpg" // placeholder
            },
            {
                nome: "Mercearia do João",
                depoimento: "Com o dashboard, identifiquei que 70% das vendas vinham de apenas 5 produtos. Foquei neles e aumentei meu estoque, resultando em um crescimento de 50%.",
                resultado: "+50% em vendas",
                foto: "img/cliente2.jpg"
            },
            {
                nome: "Consultoria RH Plus",
                depoimento: "A automação de processos reduziu meu tempo administrativo de 20h para 5h por semana. Agora posso focar em atender mais clientes.",
                resultado: "Redução de 75% do tempo administrativo",
                foto: "img/cliente3.jpg"
            }
        ]
    },

    // Planos
    planos: {
        titulo: "Escolha o plano que estrutura seu crescimento",
        subtitulo: "Cada plano representa um estágio de transformação digital. Comece onde sua empresa precisa.",
        botao: "Quero começar minha transformação →",
        lista: [
            {
                nome: "ESSENCIAL",
                implantacao: 900,
                mensalidade: 697,
                destaque: false,
                beneficios: [
                    "Presença Digital: site institucional (template OctaBit), hospedagem profissional, monitoramento de uptime",
                    "Dados Básicos: Google Analytics configurado, dashboard básico",
                    "Suporte técnico e pequenas melhorias",
                    "Acompanhamento estratégico anual"
                ]
            },
            {
                nome: "PROFISSIONAL",
                implantacao: 1500,
                mensalidade: 1497,
                destaque: true,
                selo: "★ Mais escolhido",
                beneficios: [
                    "Tudo do ESSENCIAL",
                    "Inteligência de Dados: dashboard de vendas, ticket médio, canais de aquisição, métricas de conversão",
                    "Automações simples e integrações básicas",
                    "Análise mensal e recomendações estratégicas",
                    "Acompanhamento estratégico trimestral"
                ]
            },
            {
                nome: "EMPRESARIAL",
                implantacao: 3000,
                mensalidade: 2997,
                destaque: false,
                beneficios: [
                    "Tudo do PROFISSIONAL",
                    "Automações avançadas e integrações complexas",
                    "BI avançado: dashboards personalizados, métricas avançadas",
                    "Acompanhamento estratégico mensal",
                    "Prioridade máxima de atendimento"
                ]
            }
        ]
    },

    // Seção Lead Magnet
    leadMagnet: {
        titulo: "Diagnóstico de Maturidade Digital",
        subtitulo: "Preencha o formulário abaixo e receba gratuitamente um relatório personalizado com o nível de maturidade digital da sua empresa e recomendações práticas para crescer com tecnologia.",
        botao: "Quero meu diagnóstico gratuito →",
        icone: "bar-chart-2" // Ícone profissional do Feather

    },

    // Contato
    contato: {
        titulo: "Pronto para estruturar o crescimento da sua empresa?",
        subtitulo: "Comece sua transformação digital hoje.",
        botao: "Falar com um especialista →",
        formTitulo: "Ou envie uma mensagem diretamente"
    },

    // Footer
    footer: {
        copyright: "© 2025 OctaBit. Todos os direitos reservados.",
        texto: "Estruturação digital estratégica para pequenas empresas."
    },

    // SEO
    seo: {
        titulo: "OctaBit | Estruturação Digital para Pequenas Empresas",
        descricao: "Estruturação digital e arquitetura operacional para pequenas empresas. Sites, automação, dashboards e acompanhamento estratégico. Cresça com controle e previsibilidade.",
        keywords: "estruturação digital, automação para pequenas empresas, site para negócio local, dashboards de vendas, bi para pequenas empresas, acompanhamento estratégico",
        author: "OctaBit"
    }
};