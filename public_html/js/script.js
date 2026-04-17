// ===== RENDERIZADOR BASEADO EM CONFIGURAÇÃO =====

document.addEventListener("DOMContentLoaded", function () {
    console.log("🚀 Iniciando renderização da OctaBit...");

    if (typeof OCTABIT_CONFIG === 'undefined') {
        console.error("❌ ERRO: OCTABIT_CONFIG não encontrado!");
        return;
    }

    function renderizarTudo() {
        renderizarHeader();
        renderizarHero();
        renderizarProblemaSolucao();
        renderizarMetodologia();        // nova
        renderizarServicosEParaQuem();
        renderizarDemonstracao();        // nova
        renderizarSobreEAutoridade();
        renderizarCasos();               // nova
        renderizarPlanos();
        renderizarLeadMagnet();           // nova
        renderizarContato();
        renderizarFooter();

        inicializarEventos();
        inicializarAnimacoes();
        ajustarHeroMobile();
        setupCarrosselIndicator();

        if (typeof feather !== 'undefined') {
            try {
                feather.replace();
            } catch (e) {
                console.warn("Erro ao substituir ícones:", e);
            }
        } else {
            console.warn("Feather Icons não carregou - ícones não serão exibidos");
        }
    }

    setTimeout(renderizarTudo, 100);
});

// ===== FUNÇÕES DE RENDERIZAÇÃO =====

function renderizarHeader() {
    const config = OCTABIT_CONFIG;
    const header = document.getElementById('header-container');
    const email = OCTABIT_CONFIG.email;

    if (!header) return;

    let menuItems = '';
    config.header.menu.forEach(item => {
        menuItems += `<a href="${item.link}">${item.texto}</a>`;
    });

    header.innerHTML = `
        <img src="${config.header.logo}" class="logo" alt="OctaBit" onerror="this.src='https://via.placeholder.com/110x40?text=OctaBit'">
        <div class="menu-toggle" onclick="toggleMenu()" aria-label="Abrir menu">☰</div>
        <nav id="menu">
            ${menuItems}
            <a href="mailto:${email.endereco}" title="Enviar e-mail">
                <i data-feather="mail" width="18" height="18"></i>
            </a>
            <a href="#lead-magnet" class="nav-cta" onclick="event.preventDefault(); document.getElementById('lead-magnet').scrollIntoView({behavior:'smooth'}); return false;">${config.header.cta}</a>
        </nav>
    `;
}

function renderizarHero() {
    const container = document.getElementById('hero-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.hero;
    container.innerHTML = `
        <h1>${config.titulo}</h1>
        <p>${config.subtitulo}</p>
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <button onclick="document.getElementById('lead-magnet').scrollIntoView({behavior:'smooth'})">${config.botao}</button>
            <button onclick="abrirWhats()" style="background: transparent; border: 2px solid #3b82f6; color: #3b82f6;">${config.botaoSecundario}</button>
        </div>
    `;
}

function renderizarProblemaSolucao() {
    const container = document.getElementById('problema-solucao-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.problemaSolucao;
    const problema = config.problema;
    const solucao = config.solucao;

    let problemaCards = '';
    problema.cards.forEach(card => {
        problemaCards += `
            <div class="card x-card">
                <span class="x-icon">
                    <i data-feather="x" width="16" height="16"></i>
                </span>
                <span>${card}</span>
            </div>
        `;
    });

    let solucaoPassos = '';
    solucao.passos.forEach(passo => {
        solucaoPassos += `
            <div class="card">
                <div class="card-icon">
                    <i data-feather="${passo.icone}" width="32" height="32"></i>
                </div>
                <h3>${passo.titulo}</h3>
                <p>${passo.descricao}</p>
            </div>
        `;
    });

    container.innerHTML = `
        <h2>${problema.titulo}</h2>
        <div class="grid grid-2" style="margin-bottom: 30px;">
            ${problemaCards}
        </div>
        <h2>${solucao.titulo}</h2>
        <div class="grid grid-3">
            ${solucaoPassos}
        </div>
    `;
}

function renderizarMetodologia() {
    const container = document.getElementById('metodologia-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.metodologia;
    let passosHTML = '';

    config.passos.forEach(passo => {
        passosHTML += `
            <div class="card">
                <div class="card-icon">
                    <i data-feather="${passo.icone}" width="32" height="32"></i>
                </div>
                <h3>${passo.titulo}</h3>
                <p>${passo.descricao}</p>
            </div>
        `;
    });

    container.innerHTML = `
        <h2>${config.titulo}</h2>
        <p class="subtitulo">${config.subtitulo}</p>
        <div class="grid">
            ${passosHTML}
        </div>
        <div style="text-align: center; margin-top: 40px;">
            <button onclick="abrirWhats()">${config.cta}</button>
        </div>
    `;
}

function renderizarServicosEParaQuem() {
    const container = document.getElementById('servicos-paraquem-container');
    if (!container) return;

    const servicos = OCTABIT_CONFIG.servicos;
    const paraQuem = OCTABIT_CONFIG.paraQuem;

    let servicosHTML = '';
    servicos.itens.forEach(item => {
        servicosHTML += `
            <div class="card">
                <div class="card-icon">
                    <i data-feather="${item.icone}" width="32" height="32"></i>
                </div>
                <h3>${item.titulo}</h3>
                <p>${item.descricao}</p>
            </div>
        `;
    });

    let paraQuemHTML = '';
    paraQuem.itens.forEach(item => {
        paraQuemHTML += `
            <div class="card para-quem-card">
                <div class="card-icon">
                    <i data-feather="${item.icone}" width="32" height="32"></i>
                </div>
                <p>${item.texto}</p>
            </div>
        `;
    });

    container.innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr; gap: 30px;">
            <div>
                <h2>${servicos.titulo}</h2>
                <p class="subtitulo">${servicos.subtitulo}</p>
                <div class="grid">
                    ${servicosHTML}
                </div>
            </div>
            <div>
                <h2>${paraQuem.titulo}</h2>
                <div class="grid grid-2">
                    ${paraQuemHTML}
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 40px;">
            <button onclick="abrirWhats()">Quero estruturar meu negócio →</button>
        </div>
    `;

    setTimeout(() => {
        const wrapper = container.querySelector('div[style*="display: grid"]');
        if (window.innerWidth >= 768) {
            wrapper.style.gridTemplateColumns = '1fr 1fr';
        } else {
            wrapper.style.gridTemplateColumns = '1fr';
        }
    }, 0);

    window.addEventListener('resize', () => {
        const wrapper = container.querySelector('div[style*="display: grid"]');
        if (!wrapper) return;
        if (window.innerWidth >= 768) {
            wrapper.style.gridTemplateColumns = '1fr 1fr';
        } else {
            wrapper.style.gridTemplateColumns = '1fr';
        }
    });
}

function renderizarDemonstracao() {
    const container = document.getElementById('demonstracao-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.demonstracao;
    let itensHTML = '';

    config.itens.forEach(item => {
        itensHTML += `
            <div class="card" style="padding: 0; overflow: hidden;">
                <img src="${item.imagem}" alt="${item.titulo}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 16px 16px 0 0;">
                <div style="padding: 20px;">
                    <h3>${item.titulo}</h3>
                    <p>${item.descricao}</p>
                </div>
            </div>
        `;
    });

    container.innerHTML = `
        <h2>${config.titulo}</h2>
        <div class="grid grid-3">
            ${itensHTML}
        </div>
    `;
}

function renderizarSobreEAutoridade() {
    const container = document.getElementById('sobre-autoridade-container');
    if (!container) return;

    const sobre = OCTABIT_CONFIG.sobre;
    const autoridade = OCTABIT_CONFIG.autoridade;
    const logo = OCTABIT_CONFIG.header.logo;

    const sobreHTML = `
        <div class="sobre-card" style="height: 100%;">
            <div class="sobre-icon">
                <img src="${logo}" alt="OctaBit logo">
            </div>
            <h2>${sobre.titulo}</h2>
            <p class="sobre-descricao">${sobre.descricao}</p>
        </div>
    `;

    let autoridadeCards = '';
    autoridade.cards.forEach(card => {
        autoridadeCards += `
            <div class="autoridade-card">
                <div class="card-icon" style="margin-bottom: 10px;">
                    <i data-feather="${card.icone}" width="32" height="32"></i>
                </div>
                <div class="autoridade-numero">${card.numero}</div>
                <div class="autoridade-label">${card.label}</div>
                <p class="autoridade-desc">${card.descricao}</p>
            </div>
        `;
    });

    container.innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr; gap: 30px;">
            <div>
                ${sobreHTML}
            </div>
            <div>
                <h2>${autoridade.titulo}</h2>
                <div class="grid">
                    ${autoridadeCards}
                </div>
            </div>
        </div>
    `;

    setTimeout(() => {
        const wrapper = container.querySelector('div[style*="display: grid"]');
        if (window.innerWidth >= 768) {
            wrapper.style.gridTemplateColumns = '1fr 1fr';
        } else {
            wrapper.style.gridTemplateColumns = '1fr';
        }
    }, 0);

    window.addEventListener('resize', () => {
        const wrapper = container.querySelector('div[style*="display: grid"]');
        if (!wrapper) return;
        if (window.innerWidth >= 768) {
            wrapper.style.gridTemplateColumns = '1fr 1fr';
        } else {
            wrapper.style.gridTemplateColumns = '1fr';
        }
    });
}

function renderizarCasos() {
    const container = document.getElementById('casos-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.casos;
    let casosHTML = '';

    config.lista.forEach(caso => {
        casosHTML += `
            <div class="card" style="text-align: left;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #1e293b; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="${caso.foto}" alt="${caso.nome}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                        <h3 style="margin: 0;">${caso.nome}</h3>
                        <p style="color: #a855f7; font-size: 0.9rem;">${caso.resultado}</p>
                    </div>
                </div>
                <p style="font-style: italic; color: #cbd5e1;">"${caso.depoimento}"</p>
            </div>
        `;
    });

    container.innerHTML = `
        <h2>${config.titulo}</h2>
        <div class="grid grid-3">
            ${casosHTML}
        </div>
    `;
}

function renderizarPlanos() {
    const container = document.getElementById('planos-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.planos;
    let planosHTML = '';

    config.lista.forEach(plano => {
        let beneficiosHTML = '';
        plano.beneficios.forEach(b => {
            beneficiosHTML += `<li>${b}</li>`;
        });

        const destaqueClass = plano.destaque ? 'destaque' : '';
        const seloHTML = plano.destaque ? `<div class="plano-destaque">${plano.selo || '★ Mais escolhido'}</div>` : '';
        const planoId = plano.nome.toLowerCase().normalize("NFD").replace(/[^a-z]/g, '');

        planosHTML += `
            <div class="plan ${destaqueClass}">
                ${seloHTML}
                <h3>${plano.nome}</h3>
                <p class="setup">Setup R$${plano.implantacao}</p>
                <p class="price">R$${plano.mensalidade}<span>/mês</span></p>
                <ul>
                    ${beneficiosHTML}
                </ul>
                <button onclick="abrirModal('${planoId}')">Ver detalhes</button>
            </div>
        `;
    });

    container.innerHTML = `
        <h2>${config.titulo}</h2>
        <p class="planos-sub">${config.subtitulo}</p>
        <div class="grid">
            ${planosHTML}
        </div>
        <div style="text-align: center; margin-top: 40px;">
            <button onclick="abrirWhats()">${config.botao}</button>
        </div>
    `;
}

function renderizarLeadMagnet() {
    const container = document.getElementById('lead-magnet-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.leadMagnet;
    const scriptUrl = OCTABIT_CONFIG.googleAppsScriptUrl;

    container.innerHTML = `
        <div class="sobre-card" style="max-width: 700px;">
            <!-- Ícone profissional (substitui a lupa) -->
            <div class="sobre-icon" style="width: 70px; height: 70px; margin: 0 auto 20px;">
                <i data-feather="${config.icone}" width="36" height="36" style="stroke: #3b82f6;"></i>
            </div>
            
            <h2>${config.titulo}</h2>
            <p>${config.subtitulo}</p>
            
            <form id="lead-magnet-form" class="contato-form" style="margin-top: 20px;">
                <div class="form-group">
                    <input type="text" name="nome" placeholder="Seu nome" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Seu e-mail" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="telefone" placeholder="Seu WhatsApp">
                </div>
                <button type="submit">${config.botao}</button>
                <div id="lead-magnet-mensagem" class="form-mensagem" style="display: none;"></div>
            </form>
        </div>
    `;

    const form = document.getElementById('lead-magnet-form');
    if (form && scriptUrl) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const data = {
                nome: formData.get('nome'),
                email: formData.get('email'),
                telefone: formData.get('telefone'),
                origem: 'lead-magnet'
            };

            const msgDiv = document.getElementById('lead-magnet-mensagem');
            msgDiv.style.display = 'block';
            msgDiv.className = 'form-mensagem';
            msgDiv.textContent = 'Enviando...';

            try {
                const response = await fetch(scriptUrl, {
                    method: 'POST',
                    mode: 'no-cors',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                msgDiv.className = 'form-mensagem sucesso';
                msgDiv.textContent = 'Recebemos seu contato! Em breve enviaremos o diagnóstico.';
                form.reset();
            } catch (error) {
                msgDiv.className = 'form-mensagem erro';
                msgDiv.textContent = 'Erro ao enviar. Tente novamente.';
                console.error(error);
            }
        });
    }
}

function renderizarContato() {
    const container = document.getElementById('contato-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.contato;
    const email = OCTABIT_CONFIG.email;
    const scriptUrl = OCTABIT_CONFIG.googleAppsScriptUrl;

    container.innerHTML = `
        <h2>${config.titulo}</h2>
        <p>${config.subtitulo}</p>
        <button onclick="abrirWhats()" style="margin-bottom: 20px;">${config.botao}</button>

        <div style="margin-top: 20px;">
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 10px;">ou envie um e-mail</p>
            <a href="mailto:${email.endereco}?subject=Contato%20OctaBit" class="email-link">
                <i data-feather="mail" width="16" height="16"></i>
                ${email.display}
            </a>
        </div>

        <h3 style="margin-top: 40px;">${config.formTitulo}</h3>
        <form id="contato-form" class="contato-form">
            <div class="form-group">
                <input type="text" name="nome" placeholder="Seu nome" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Seu e-mail" required>
            </div>
            <div class="form-group">
                <input type="tel" name="telefone" placeholder="Seu WhatsApp (opcional)">
            </div>
            <div class="form-group">
                <textarea name="mensagem" placeholder="Sua mensagem" required></textarea>
            </div>
            <button type="submit">Enviar mensagem</button>
            <div id="form-mensagem" class="form-mensagem" style="display: none;"></div>
        </form>

        <p style="color: #475569; font-size: 0.8rem; margin-top: 25px;">
            Respondemos em até 2 horas úteis
        </p>
    `;

    const form = document.getElementById('contato-form');
    if (form && scriptUrl) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const data = {
                nome: formData.get('nome'),
                email: formData.get('email'),
                telefone: formData.get('telefone'),
                mensagem: formData.get('mensagem')
            };

            const msgDiv = document.getElementById('form-mensagem');
            msgDiv.style.display = 'block';
            msgDiv.className = 'form-mensagem';
            msgDiv.textContent = 'Enviando...';

            try {
                const response = await fetch(scriptUrl, {
                    method: 'POST',
                    mode: 'no-cors',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                msgDiv.className = 'form-mensagem sucesso';
                msgDiv.textContent = 'Mensagem enviada! Em breve entraremos em contato.';
                form.reset();
            } catch (error) {
                msgDiv.className = 'form-mensagem erro';
                msgDiv.textContent = 'Erro ao enviar. Tente novamente ou use WhatsApp/e-mail.';
                console.error(error);
            }
        });
    } else if (!scriptUrl) {
        console.warn('Google Apps Script URL não configurada. Formulário não funcionará.');
    }
}

function renderizarFooter() {
    const container = document.getElementById('footer-container');
    if (!container) return;

    const config = OCTABIT_CONFIG.footer;
    const logo = OCTABIT_CONFIG.header.logo;
    const email = OCTABIT_CONFIG.email;
    const whatsapp = OCTABIT_CONFIG.whatsapp;

    container.innerHTML = `
        <div style="text-align: center; padding: 40px 20px 20px;">
            <img src="${logo}" class="footer-logo" alt="OctaBit">

            <div class="footer-contatos">
                <a href="${whatsapp.url}" target="_blank" class="footer-link">
                    <i data-feather="message-circle" width="16" height="16"></i>
                    WhatsApp
                </a>
                <a href="mailto:${email.endereco}" class="footer-link">
                    <i data-feather="mail" width="16" height="16"></i>
                    ${email.display}
                </a>
                <span class="footer-link" style="border: none;">
                    <i data-feather="phone" width="16" height="16"></i>
                    (41) 98776-2489
                </span>
            </div>

            <p class="footer-copyright">${config.copyright}</p>
            <p class="footer-texto">${config.texto}</p>
        </div>
    `;
}

// ===== FUNÇÕES DE UTILIDADE =====

function abrirWhats() {
    if (OCTABIT_CONFIG && OCTABIT_CONFIG.whatsapp) {
        window.open(OCTABIT_CONFIG.whatsapp.url, "_blank");
    }
}

function abrirWhatsPlano(plano) {
    if (OCTABIT_CONFIG && OCTABIT_CONFIG.whatsapp) {
        const mensagem = `Olá! Vi o Plano ${plano} da OctaBit e quero agendar um diagnóstico.`;
        const url = `https://wa.me/${OCTABIT_CONFIG.whatsapp.numero}?text=${encodeURIComponent(mensagem)}`;
        window.open(url, '_blank');
    }
}

function toggleMenu() {
    const menu = document.getElementById("menu");
    const toggle = document.querySelector(".menu-toggle");
    if (!menu || !toggle) return;

    menu.classList.toggle("active");
    toggle.textContent = menu.classList.contains("active") ? "✕" : "☰";
}

function inicializarEventos() {
    const menuLinks = document.querySelectorAll("#menu a");
    menuLinks.forEach(link => {
        link.addEventListener("click", function() {
            const menu = document.getElementById("menu");
            const toggle = document.querySelector(".menu-toggle");
            if (menu) menu.classList.remove("active");
            if (toggle) toggle.textContent = "☰";
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener("click", function(e) {
            const href = this.getAttribute("href");
            if (href && href !== "#") {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerHeight = window.innerWidth <= 767 ? 70 : 80;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
}

function inicializarAnimacoes() {
    if (!window.IntersectionObserver) {
        document.querySelectorAll(".fade").forEach(el => el.classList.add("show"));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            }
        });
    }, { threshold: 0.1, rootMargin: "0px 0px -30px 0px" });

    document.querySelectorAll(".fade").forEach(el => observer.observe(el));
}

function ajustarHeroMobile() {
    if (window.innerWidth <= 768) {
        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.minHeight = (window.innerHeight - 140) + 'px';
        }
    }
}

function setupCarrosselIndicator() {}

// ===== FUNÇÕES DOS MODAIS =====

function abrirModal(plano) {
    const modal = document.getElementById(`modal-${plano}`);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        if (typeof feather !== 'undefined') {
            setTimeout(() => feather.replace(), 50);
        }
    } else {
        abrirWhatsPlano(plano);
    }
}

function fecharModal(plano) {
    const modal = document.getElementById(`modal-${plano}`);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

document.addEventListener('click', function (event) {
    if (event.target && event.target.classList && event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        document.body.style.overflow = '';
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => {
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    }
});

let touchStartY = 0;
document.addEventListener('touchstart', function(e) {
    if (e.changedTouches && e.changedTouches[0]) {
        touchStartY = e.changedTouches[0].screenY;
    }
});

document.addEventListener('touchend', function(e) {
    const modals = document.querySelectorAll('.modal[style*="display: block"]');
    if (modals.length && e.changedTouches && e.changedTouches[0]) {
        if (e.changedTouches[0].screenY - touchStartY > 60) {
            modals.forEach(modal => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            });
        }
    }
});

window.addEventListener('load', ajustarHeroMobile);
window.addEventListener('resize', ajustarHeroMobile);