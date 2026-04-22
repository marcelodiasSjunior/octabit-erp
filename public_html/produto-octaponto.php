<?php
$page_title       = 'OctaPonto — Controle de Jornada e Ponto Eletrônico | OctaBit';
$page_description = 'Registro de ponto pelo celular com biometria facial, banco de horas, escalas, férias e relatórios automáticos. Gestão de pessoas simplificada.';
$current_page     = 'produtos';
$header_dark      = true;
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== HERO ====== -->
<section class="hero hero--dark hero--sub">
    <div class="container">
        <span class="hero__badge">Gestão de Pessoas</span>
        <h1 class="hero__title">Controle de jornada<br>sem complicação</h1>
        <p class="hero__subtitle">Seus colaboradores registram o ponto pelo celular com reconhecimento facial. Você acompanha tudo em tempo real, com relatórios automáticos e zero papel.</p>
        <div class="hero__actions">
            <a href="<?= whatsappURL('Olá! Quero conhecer o OctaPonto.') ?>" class="btn btn--primary btn--lg" target="_blank">Quero conhecer →</a>
            <a href="#funcionalidades" class="btn btn--ghost btn--lg">Ver funcionalidades</a>
        </div>
    </div>
</section>

<!-- ====== PROOF BAR ====== -->
<div class="proof-bar">
    <div class="container">
        <div class="proof-bar__grid">
            <div class="proof-bar__item reveal reveal-delay-1">
                <div class="proof-bar__number">Facial</div>
                <div class="proof-bar__label">Reconhecimento facial<br><strong>Registro seguro pelo celular</strong></div>
            </div>
            <div class="proof-bar__item reveal reveal-delay-2">
                <div class="proof-bar__number">100%</div>
                <div class="proof-bar__label">Digital<br><strong>Sem relógio de ponto físico</strong></div>
            </div>
            <div class="proof-bar__item reveal reveal-delay-3">
                <div class="proof-bar__number">24/7</div>
                <div class="proof-bar__label">Acesso ao painel<br><strong>Relatórios em tempo real</strong></div>
            </div>
        </div>
    </div>
</div>

<!-- ====== FUNCIONALIDADES PRINCIPAIS ====== -->
<section class="section" id="funcionalidades">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Funcionalidades</span>
            <h2>Tudo que sua empresa precisa para gestão de pessoas</h2>
            <p class="section__desc">Do registro de ponto à aprovação de férias, tudo integrado em uma única plataforma.</p>
        </div>

        <div class="bento">
            <div class="bento__card bento__card--lg reveal">
                <div class="bento__inner">
                    <div>
                        <div class="bento__icon">
                            <svg viewBox="0 0 24 24"><use href="#icon-activity"/></svg>
                        </div>
                        <h3>Registro de Ponto com Reconhecimento Facial</h3>
                        <p>Colaborador registra entrada, saída para almoço, retorno e saída final pelo aplicativo no celular. Geolocalização e reconhecimento facial garantem a autenticidade de cada registro.</p>
                    </div>
                    <div class="bento__visual"><img src="/img/produtos/octaponto/dashboard.jpg" alt="Painel OctaPonto — Dashboard de frequência" loading="lazy"></div>
                </div>
            </div>

            <div class="bento__card reveal reveal-delay-1">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-shield"/></svg>
                </div>
                <h3>Biometria Facial</h3>
                <p>Reconhecimento facial integrado com inteligência artificial. Impede fraudes e garante que quem registrou é realmente o colaborador.</p>
            </div>

            <div class="bento__card reveal reveal-delay-2">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-bar-chart-2"/></svg>
                </div>
                <h3>Banco de Horas</h3>
                <p>Cálculo automático de horas extras, atrasos e saldo de banco de horas. Acompanhe o acumulado de cada colaborador sem planilhas.</p>
            </div>

            <div class="bento__card reveal reveal-delay-1">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-users"/></svg>
                </div>
                <h3>Escalas e Jornadas</h3>
                <p>Configure escalas fixas ou rotativas, horários flexíveis e turnos personalizados. O sistema calcula tudo automaticamente conforme a jornada de cada colaborador.</p>
            </div>

            <div class="bento__card reveal reveal-delay-2">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-clipboard"/></svg>
                </div>
                <h3>Férias e Atestados</h3>
                <p>Colaborador solicita férias ou envia atestado médico direto pelo app. O gestor aprova ou recusa com um clique no painel administrativo.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== MAIS RECURSOS ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Mais recursos</span>
            <h2>Cada detalhe pensado para o seu dia a dia</h2>
        </div>

        <div class="feature-row reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Avaliações</span>
                <h3>Feedback e desempenho</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Registre avaliações de desempenho, acompanhe o histórico de feedbacks e tenha um panorama claro da evolução de cada membro da equipe.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octaponto/frequencia.jpg" alt="Dashboard de frequência" loading="lazy">
            </div>
        </div>

        <div class="feature-row feature-row--reverse reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Atividades</span>
                <h3>Registro de atividades diárias</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Colaboradores registram as atividades do dia no app. Gestores acompanham a produtividade da equipe em tempo real e geram relatórios periódicos.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octaponto/atividades.jpg" alt="Registro de atividades" loading="lazy">
            </div>
        </div>

        <div class="feature-row reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow">Multi-empresa</span>
                <h3>Uma conta, várias empresas</h3>
                <p style="color:var(--zinc-500);line-height:1.7">Gerencie múltiplas empresas ou filiais em uma única conta. Cada empresa tem seus próprios colaboradores, escalas e configurações independentes.</p>
            </div>
            <div class="feature-row__visual">
                <img src="/img/produtos/octaponto/funcionarios.jpg" alt="Gestão de funcionários" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- ====== COMO FUNCIONA (Timeline) ====== -->
<section class="section">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Como funciona</span>
            <h2>Pronto em 3 passos</h2>
        </div>

        <div class="timeline reveal">
            <div class="timeline__step">
                <div class="timeline__num">1</div>
                <h4>Cadastre sua empresa</h4>
                <p>Crie sua conta, configure as escalas e adicione seus colaboradores</p>
            </div>
            <div class="timeline__step">
                <div class="timeline__num">2</div>
                <h4>Convide a equipe</h4>
                <p>Cada colaborador baixa o app e se cadastra com reconhecimento facial</p>
            </div>
            <div class="timeline__step">
                <div class="timeline__num">3</div>
                <h4>Acompanhe tudo</h4>
                <p>Ponto, banco de horas, férias e relatórios no painel administrativo</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== APP MOBILE ====== -->
<section class="section section--dark">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow section__eyebrow--light">Aplicativo</span>
            <h2>Na mão do colaborador</h2>
            <p class="section__desc section__desc--center" style="color:var(--zinc-400)">O aplicativo mobile permite que seus colaboradores registrem o ponto, consultem o banco de horas, solicitem férias e acompanhem suas atividades — tudo pelo celular.</p>
        </div>

        <div class="grid grid--3">
            <div class="card reveal reveal-delay-1" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-activity"/></svg>
                </div>
                <h3 style="color:var(--white)">Bater ponto</h3>
                <p style="color:var(--zinc-400)">Com biometria facial e geolocalização. Um toque e o ponto está registrado.</p>
            </div>
            <div class="card reveal reveal-delay-2" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-bar-chart-2"/></svg>
                </div>
                <h3 style="color:var(--white)">Consultar banco</h3>
                <p style="color:var(--zinc-400)">Saldo de horas, extras e atrasos visíveis a qualquer momento.</p>
            </div>
            <div class="card reveal reveal-delay-3" style="background:var(--zinc-900);border-color:rgba(255,255,255,.08)">
                <div class="card__icon" style="background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.2)">
                    <svg viewBox="0 0 24 24"><use href="#icon-clipboard"/></svg>
                </div>
                <h3 style="color:var(--white)">Solicitar férias</h3>
                <p style="color:var(--zinc-400)">Envie solicitações de férias e atestados direto pelo app, sem formulários.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php
$cta_title       = 'Simplifique a gestão de ponto da sua empresa';
$cta_subtitle    = 'Converse com nosso time e veja como o OctaPonto se adapta à sua operação.';
$cta_button_text = 'Falar sobre o OctaPonto';
$cta_button_href = whatsappURL('Olá! Quero saber mais sobre o OctaPonto.');
$cta_dark        = false;
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
