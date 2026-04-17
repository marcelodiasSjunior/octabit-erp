<?php
$page_title       = 'Planos | OctaBit';
$page_description = 'Escolha o nível de transformação digital da sua empresa. Planos Essencial, Profissional e Empresarial com acompanhamento contínuo.';
$current_page     = 'planos';
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== SUB-HERO ====== -->
<section class="hero hero--light hero--sub">
    <div class="container">
        <span class="hero__badge">Planos Recorrentes</span>
        <h1 class="hero__title"><?= e($config['plans']['title']) ?></h1>
        <p class="hero__subtitle"><?= e($config['plans']['subtitle']) ?></p>
    </div>
</section>

<!-- ====== PLANOS ====== -->
<section class="section">
    <div class="container">
        <div class="plans">
            <?php foreach ($config['plans']['list'] as $i => $plan): ?>
            <div class="plan<?= $plan['featured'] ? ' plan--featured' : '' ?> reveal reveal-delay-<?= $i + 1 ?>">
                <div class="plan__name"><?= e($plan['name']) ?></div>
                <div class="plan__price">
                    <strong><?= formatBRL($plan['monthly']) ?></strong>
                    <span>/mês</span>
                </div>
                <p class="plan__desc"><?= e($plan['goal']) ?></p>
                <div class="plan__setup">Implantação a partir de <?= formatBRL($plan['setup']) ?></div>
                <ul class="plan__features">
                    <?php foreach ($plan['benefits'] as $b): ?>
                    <li><?= e($b) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= e(whatsappURL("Olá! Tenho interesse no plano {$plan['name']}. Podemos conversar?")) ?>"
                   class="btn <?= $plan['featured'] ? 'btn--primary' : 'btn--outline' ?> btn--full"
                   target="_blank" rel="noopener">
                    Falar sobre o plano <?= e($plan['name']) ?> →
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12 reveal">
            <p style="color:var(--zinc-500);font-size:var(--text-sm);max-width:480px;margin:0 auto var(--sp-4);">
                Valores podem variar conforme complexidade. O diagnóstico gratuito ajuda a definir o plano ideal.
            </p>
            <a href="/contato" class="btn btn--outline">Agendar diagnóstico gratuito →</a>
        </div>
    </div>
</section>

<!-- ====== DIFERENCIAL ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Por que recorrente?</span>
            <h2>A OctaBit acompanha sua evolução</h2>
            <p class="section__desc">Não vendemos projetos pontuais — construímos parceria de crescimento</p>
        </div>
        <div class="grid-3">
            <div class="card reveal reveal-delay-1">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-refresh-cw"/></svg>
                </div>
                <h3>Melhoria Contínua</h3>
                <p>Sua estrutura digital evolui junto com seu negócio, sem parar no tempo.</p>
            </div>
            <div class="card reveal reveal-delay-2">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-shield"/></svg>
                </div>
                <h3>Suporte Dedicado</h3>
                <p>Não é preciso abrir chamado — somos parceiros, não fornecedores distantes.</p>
            </div>
            <div class="card reveal reveal-delay-3">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-trending-up"/></svg>
                </div>
                <h3>Visão Estratégica</h3>
                <p>Acompanhamos indicadores e recomendamos ações que geram resultado real.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php
$cta_title = 'Pronto para estruturar o crescimento?';
$cta_subtitle = 'O diagnóstico é gratuito e sem compromisso.';
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
