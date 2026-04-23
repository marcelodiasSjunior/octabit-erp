<?php
$page_title       = 'OctaVendas — Gestão Comercial e Rotas de Entrega | OctaBit';
$page_description = 'Sistema de gestão comercial com controle de pedidos, rotas otimizadas, integração WhatsApp e aprovação de pagamentos. Ideal para delivery e vendas recorrentes.';
$current_page     = 'produtos';
$header_dark      = true;
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== HERO ====== -->
<section class="hero hero--dark hero--sub">
    <div class="container">
        <span class="hero__badge">Gestão Comercial</span>
        <h1 class="hero__title">Venda, entregue e<br>receba — sem perder nada</h1>
        <p class="hero__subtitle">Controle pedidos, organize rotas de entrega, acompanhe pagamentos e atenda clientes pelo WhatsApp. Tudo em um painel feito para quem vende todo dia.</p>
        <div class="hero__actions">
            <a href="<?= whatsappURL('Olá! Quero conhecer o OctaVendas.') ?>" class="btn btn--primary btn--lg" target="_blank">Quero conhecer →</a>
            <a href="#funcionalidades" class="btn btn--ghost btn--lg">Ver funcionalidades</a>
        </div>
    </div>
</section>

<!-- ====== PROOF BAR ====== -->
<div class="proof-bar">
    <div class="container">
        <div class="proof-bar__grid">
            <div class="proof-bar__item reveal reveal-delay-1">
                <div class="proof-bar__number">0</div>
                <div class="proof-bar__label">Pedidos perdidos<br><strong>Tudo registrado e rastreável</strong></div>
            </div>
            <div class="proof-bar__item reveal reveal-delay-2">
                <div class="proof-bar__number">GPS</div>
                <div class="proof-bar__label">Rotas otimizadas<br><strong>Entrega mais rápida, menos custo</strong></div>
            </div>
            <div class="proof-bar__item reveal reveal-delay-3">
                <div class="proof-bar__number">WhatsApp</div>
                <div class="proof-bar__label">Integração nativa<br><strong>Pedidos direto do chat</strong></div>
            </div>
        </div>
    </div>
</div>

<section class="section section--sm product-summary">
    <div class="container">
        <div class="grid grid--3">
            <div class="card summary-card reveal reveal-delay-1">
                <h3>Para quem é</h3>
                <p>Operações de venda por WhatsApp com entrega por bairro, rota ou motorista.</p>
            </div>
            <div class="card summary-card reveal reveal-delay-2">
                <h3>O que resolve</h3>
                <p>Pedido perdido, entrega desorganizada, validação manual de região e retrabalho no atendimento.</p>
            </div>
            <div class="card summary-card reveal reveal-delay-3">
                <h3>Resultado prático</h3>
                <p>Venda mais fluida, rota mais eficiente e operação de entrega com menos ruído.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== FUNCIONALIDADES PRINCIPAIS ====== -->
<section class="section" id="funcionalidades">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Funcionalidades</span>
            <h2>Da venda à entrega, com controle real</h2>
            <p class="section__desc">Pedidos, rotas, pagamento e atendimento conectados no mesmo fluxo.</p>
        </div>

        <div class="bento">
            <div class="bento__card bento__card--lg reveal">
                <div class="bento__inner">
                    <div>
                        <div class="bento__icon">
                            <svg viewBox="0 0 24 24"><use href="#icon-clipboard"/></svg>
                        </div>
                        <h3>Gestão de Pedidos</h3>
                        <p>Receba pedidos, organize por região e acompanhe status sem planilhas ou mensagens soltas.</p>
                    </div>
                    <div class="bento__visual"><img src="/img/produtos/octavendas/dashboard.jpg?v=2" alt="Painel OctaVendas — Dashboard de pedidos" loading="lazy"></div>
                </div>
            </div>

            <div class="bento__card reveal reveal-delay-1">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-target"/></svg>
                </div>
                <h3>Rotas Otimizadas</h3>
                <p>Agrupa entregas por região e gera rota pronta para o motorista no Google Maps.</p>
            </div>

            <div class="bento__card reveal reveal-delay-2">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-zap"/></svg>
                </div>
                <h3>Integração WhatsApp</h3>
                <p>Pedido entra pelo WhatsApp, a região é validada e tudo cai no painel automaticamente.</p>
            </div>

            <div class="bento__card reveal reveal-delay-1">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-shield"/></svg>
                </div>
                <h3>Aprovação de Pagamentos</h3>
                <p>Comprovante chega pelo WhatsApp e você aprova no painel com poucos cliques.</p>
            </div>

            <div class="bento__card reveal reveal-delay-2">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-users"/></svg>
                </div>
                <h3>Gestão de Motoristas</h3>
                <p>Motorista recebe rota clara e você acompanha a execução da operação em tempo real.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== REGIÕES E BAIRROS ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Operação por região</span>
            <h2>Organize vendas por bairro e dia da semana</h2>
        </div>

        <div class="feature-row reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Bairros & Agendamento</span>
                <h3>Cada bairro, no dia certo</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Cadastre bairros com os dias da semana de atendimento. O sistema projeta automaticamente as datas do mês e valida quando o cliente faz o pedido.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octavendas/bairros.jpg?v=2" alt="Cadastro de bairros" loading="lazy">
            </div>
        </div>

        <div class="feature-row feature-row--reverse reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Taxa inteligente</span>
                <h3>Taxa de entrega por volume</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Defina uma taxa base por região. A partir de um volume configurado de itens, o sistema adiciona automaticamente a taxa extra. Transparente para o cliente, controlável para você.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octavendas/pedidos.jpg?v=2" alt="Painel de pedidos" loading="lazy">
            </div>
        </div>

        <div class="feature-row reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Notificações</span>
                <h3>Avise o cliente automaticamente</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Quando o admin inicia a rota do dia, o bot notifica cada cliente automaticamente pelo WhatsApp com o status da entrega. Sem ligar, sem mandar mensagem manual.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octavendas/rotas.jpg?v=2" alt="Gestão de rotas" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- ====== COMO FUNCIONA ====== -->
<section class="section">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Como funciona</span>
            <h2>Venda funcionando em 3 passos</h2>
        </div>

        <div class="timeline reveal">
            <div class="timeline__step">
                <div class="timeline__num">1</div>
                <h4>Configure regiões</h4>
                <p>Cadastre bairros, dias de atendimento, motoristas e taxas de entrega</p>
            </div>
            <div class="timeline__step">
                <div class="timeline__num">2</div>
                <h4>Receba pedidos</h4>
                <p>Pedidos entram pelo WhatsApp ou painel. O sistema valida região e data automaticamente</p>
            </div>
            <div class="timeline__step">
                <div class="timeline__num">3</div>
                <h4>Entregue com rota</h4>
                <p>Processe os pedidos do dia, gere a rota otimizada e acompanhe cada entrega</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== IDEAL PARA ====== -->
<section class="section section--dark">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow section__eyebrow--light">Ideal para</span>
            <h2>Feito para quem vende e entrega</h2>
        </div>

        <div class="grid grid--3 ideal-for-grid">
            <div class="card reveal reveal-delay-1" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-zap"/></svg>
                </div>
                <h3 style="color:var(--white)">Delivery e cestas</h3>
                <p style="color:var(--zinc-400)">Cestas, marmitas, hortifruti, kits — qualquer operação de entrega recorrente por região.</p>
            </div>
            <div class="card reveal reveal-delay-2" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-users"/></svg>
                </div>
                <h3 style="color:var(--white)">Vendas por WhatsApp</h3>
                <p style="color:var(--zinc-400)">Negócios que recebem pedidos pelo WhatsApp e precisam de organização sem perder a agilidade.</p>
            </div>
            <div class="card reveal reveal-delay-3" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-target"/></svg>
                </div>
                <h3 style="color:var(--white)">Operação com rotas</h3>
                <p style="color:var(--zinc-400)">Empresas com motoristas e entregas por bairro que precisam de rotas otimizadas e rastreáveis.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php
$cta_title       = 'Organize suas vendas e entregas de uma vez';
$cta_subtitle    = 'Converse com nosso time e veja como o OctaVendas se adapta ao seu negócio.';
$cta_button_text = 'Falar sobre o OctaVendas';
$cta_button_href = whatsappURL('Olá! Quero saber mais sobre o OctaVendas.');
$cta_dark        = false;
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
