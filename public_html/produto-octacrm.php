<?php
$page_title       = 'OctaCRM — CRM e Gestão Financeira para Prestadores de Serviço | OctaBit';
$page_description = 'CRM completo com gestão de clientes, orçamentos, cobranças, contratos e histórico de interações. Painel profissional para prestadores de serviço.';
$current_page     = 'produtos';
$header_dark      = true;
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== HERO ====== -->
<section class="hero hero--dark hero--sub">
    <div class="container">
        <span class="hero__badge">CRM & Financeiro</span>
        <h1 class="hero__title">Clientes, cobranças e<br>contratos em um só lugar</h1>
        <p class="hero__subtitle">Gerencie todo o ciclo do cliente — do primeiro contato à cobrança recorrente — com um CRM feito para prestadores de serviço que querem crescer sem perder o controle.</p>
        <div class="hero__actions">
            <a href="<?= whatsappURL('Olá! Quero conhecer o OctaCRM.') ?>" class="btn btn--primary btn--lg" target="_blank">Quero conhecer →</a>
            <a href="#funcionalidades" class="btn btn--ghost btn--lg">Ver funcionalidades</a>
        </div>
    </div>
</section>

<!-- ====== PROOF BAR ====== -->
<div class="proof-bar">
    <div class="container">
        <div class="proof-bar__grid">
            <div class="proof-bar__item reveal reveal-delay-1">
                <div class="proof-bar__number">360°</div>
                <div class="proof-bar__label">Visão do cliente<br><strong>Tudo em um único perfil</strong></div>
            </div>
            <div class="proof-bar__item reveal reveal-delay-2">
                <div class="proof-bar__number">0</div>
                <div class="proof-bar__label">Cobranças esquecidas<br><strong>Alertas automáticos de vencimento</strong></div>
            </div>
            <div class="proof-bar__item reveal reveal-delay-3">
                <div class="proof-bar__number">100%</div>
                <div class="proof-bar__label">Histórico registrado<br><strong>Ligações, e-mails e reuniões</strong></div>
            </div>
        </div>
    </div>
</div>

<section class="section section--sm product-summary">
    <div class="container">
        <div class="grid grid--3">
            <div class="card summary-card reveal reveal-delay-1">
                <h3>Para quem é</h3>
                <p>Prestadores de serviço que precisam organizar relacionamento, contratos e cobrança.</p>
            </div>
            <div class="card summary-card reveal reveal-delay-2">
                <h3>O que resolve</h3>
                <p>Cliente sem histórico, orçamento perdido, contrato fora do radar e cobrança atrasada.</p>
            </div>
            <div class="card summary-card reveal reveal-delay-3">
                <h3>Resultado prático</h3>
                <p>Pipeline previsível, cobrança organizada e visão completa do ciclo de cada cliente.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== FUNCIONALIDADES PRINCIPAIS ====== -->
<section class="section" id="funcionalidades">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Funcionalidades</span>
            <h2>CRM simples para operar melhor</h2>
            <p class="section__desc">Lead, proposta, contrato e cobrança em uma jornada única.</p>
        </div>

        <div class="bento">
            <div class="bento__card bento__card--lg reveal">
                <div class="bento__inner">
                    <div>
                        <div class="bento__icon">
                            <svg viewBox="0 0 24 24"><use href="#icon-users"/></svg>
                        </div>
                        <h3>Gestão de Clientes</h3>
                        <p>Perfil único por cliente com status, contatos e histórico para evitar perda de contexto.</p>
                    </div>
                    <div class="bento__visual"><img src="/img/produtos/octacrm/dashboard.jpg" alt="Painel OctaCRM — Dashboard de clientes" loading="lazy"></div>
                </div>
            </div>

            <div class="bento__card reveal reveal-delay-1">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-clipboard"/></svg>
                </div>
                <h3>Orçamentos</h3>
                <p>Crie proposta, acompanhe status e converta em contrato sem retrabalho.</p>
            </div>

            <div class="bento__card reveal reveal-delay-2">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-bar-chart-2"/></svg>
                </div>
                <h3>Contas a Receber</h3>
                <p>Controle cobranças por status e período, com visão rápida do que entrou e do que está pendente.</p>
            </div>

            <div class="bento__card reveal reveal-delay-1">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-briefcase"/></svg>
                </div>
                <h3>Contratos</h3>
                <p>Contratos com status claro e serviços vinculados para evitar ruídos no atendimento.</p>
            </div>

            <div class="bento__card reveal reveal-delay-2">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-message-circle"/></svg>
                </div>
                <h3>Histórico de Interações</h3>
                <p>Histórico de contato centralizado para qualquer pessoa do time entender o cenário em segundos.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== MAIS RECURSOS ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Mais recursos</span>
            <h2>Tudo integrado no mesmo painel</h2>
        </div>

        <div class="feature-row reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Catálogo</span>
                <h3>Serviços e produtos cadastrados</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Cadastre seus serviços (recorrentes, únicos ou híbridos) e produtos com preços, descrições e categorias. Vincule ao perfil do cliente para saber exatamente o que ele consome.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octacrm/clientes.jpg" alt="Gestão de clientes" loading="lazy">
            </div>
        </div>

        <div class="feature-row feature-row--reverse reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Dashboard</span>
                <h3>KPIs que importam</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Dashboard com indicadores em tempo real: clientes ativos, leads, valores recebidos, a receber e cobranças por status. Tudo visível assim que você faz login.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octacrm/orcamentos.jpg" alt="Orçamentos" loading="lazy">
            </div>
        </div>

        <div class="feature-row reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Financeiro</span>
                <h3>Contas a pagar e receber</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Controle completo de entradas e saídas. Saiba quanto tem a receber, quanto já recebeu e quais cobranças estão vencidas — sem precisar abrir uma planilha.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octacrm/contas_receber.jpg" alt="Contas a receber" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- ====== COMO FUNCIONA ====== -->
<section class="section">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Como funciona</span>
            <h2>Comece a usar em minutos</h2>
        </div>

        <div class="timeline reveal">
            <div class="timeline__step">
                <div class="timeline__num">1</div>
                <h4>Configure seu CRM</h4>
                <p>Cadastre seus serviços, produtos e configure as categorias do seu negócio</p>
            </div>
            <div class="timeline__step">
                <div class="timeline__num">2</div>
                <h4>Adicione clientes</h4>
                <p>Importe ou cadastre seus clientes com status, contato e histórico</p>
            </div>
            <div class="timeline__step">
                <div class="timeline__num">3</div>
                <h4>Gerencie tudo</h4>
                <p>Orçamentos, contratos, cobranças e interações — tudo no painel</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== IDEAL PARA ====== -->
<section class="section section--dark">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow section__eyebrow--light">Ideal para</span>
            <h2>Feito para quem presta serviço</h2>
        </div>

        <div class="grid grid--3 ideal-for-grid">
            <div class="card reveal reveal-delay-1" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-tool"/></svg>
                </div>
                <h3 style="color:var(--white)">Agências e consultorias</h3>
                <p style="color:var(--zinc-400)">Gerencie carteira de clientes, contratos de recorrência e cobranças mensais de forma profissional.</p>
            </div>
            <div class="card reveal reveal-delay-2" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-briefcase"/></svg>
                </div>
                <h3 style="color:var(--white)">Freelancers e MEIs</h3>
                <p style="color:var(--zinc-400)">Controle clientes, serviços prestados e cobranças sem depender de planilhas ou anotações soltas.</p>
            </div>
            <div class="card reveal reveal-delay-3" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-users"/></svg>
                </div>
                <h3 style="color:var(--white)">Empresas de serviço</h3>
                <p style="color:var(--zinc-400)">Escritórios, oficinas, estúdios — qualquer empresa que precisa organizar clientes e cobranças em um lugar só.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php
$cta_title       = 'Organize seus clientes e cobranças de verdade';
$cta_subtitle    = 'Converse com nosso time e veja como o OctaCRM se adapta à sua operação.';
$cta_button_text = 'Falar sobre o OctaCRM';
$cta_button_href = whatsappURL('Olá! Quero saber mais sobre o OctaCRM.');
$cta_dark        = false;
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
