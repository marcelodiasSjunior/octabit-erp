<?php
$page_title       = 'OctaBit | Estruturação Digital para Pequenas Empresas';
$page_description = 'Estruturação digital e arquitetura operacional para pequenas empresas. Sites, automação, dashboards e acompanhamento estratégico.';
$current_page     = 'home';
$header_dark      = true;
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== HERO (Dark, Linear-style) ====== -->
<section class="hero hero--dark">
    <div class="container">
        <span class="hero__badge"><?= e($config['hero']['badge']) ?></span>
        <h1 class="hero__title"><span class="gradient-text"><?= e($config['hero']['title']) ?></span></h1>
        <p class="hero__subtitle"><?= e($config['hero']['subtitle']) ?></p>
        <div class="hero__actions">
            <a href="/contato" class="btn btn--primary btn--lg"><?= e($config['hero']['cta_primary']) ?> →</a>
            <a href="/planos" class="btn btn--ghost btn--lg"><?= e($config['hero']['cta_secondary']) ?></a>
        </div>
    </div>
</section>

<!-- ====== PROOF BAR ====== -->
<section class="proof-bar">
    <div class="container">
        <div class="proof-bar__grid">
            <?php foreach ($config['authority']['items'] as $stat): ?>
            <div class="proof-bar__item reveal">
                <span class="proof-bar__number"><?= e($stat['number']) ?></span>
                <span class="proof-bar__label"><?= e($stat['label']) ?><br><?= e($stat['desc']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== FEATURE BENTO GRID ====== -->
<section class="section" id="servicos-preview">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Serviços</span>
            <h2><?= e($config['services']['title']) ?></h2>
            <p class="section__desc"><?= e($config['services']['subtitle']) ?></p>
        </div>

        <div class="bento">
            <?php foreach ($config['services']['items'] as $i => $srv): ?>
            <?php if ($i === 0): ?>
            <div class="bento__card bento__card--lg reveal">
                <div class="bento__inner">
                    <div>
                        <div class="bento__icon">
                            <svg viewBox="0 0 24 24"><use href="#icon-<?= e($srv['icon']) ?>"/></svg>
                        </div>
                        <h3><?= e($srv['title']) ?></h3>
                        <p><?= e($srv['desc']) ?></p>
                    </div>
                    <div class="bento__visual">Presença Digital</div>
                </div>
            </div>
            <?php else: ?>
            <div class="bento__card reveal reveal-delay-<?= $i ?>">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-<?= e($srv['icon']) ?>"/></svg>
                </div>
                <h3><?= e($srv['title']) ?></h3>
                <p><?= e($srv['desc']) ?></p>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-8 reveal">
            <a href="/servicos" class="btn btn--outline">Conhecer o método PTE-I →</a>
        </div>
    </div>
</section>

<!-- ====== HOW IT WORKS (Timeline) ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Como funciona</span>
            <h2>Do diagnóstico ao resultado</h2>
            <p class="section__desc">Um processo claro e transparente em três etapas</p>
        </div>

        <div class="timeline">
            <?php foreach ($config['solution']['steps'] as $i => $step): ?>
            <div class="timeline__step reveal reveal-delay-<?= $i + 1 ?>">
                <div class="timeline__num"><?= $i + 1 ?></div>
                <h4><?= e($step['title']) ?></h4>
                <p><?= e($step['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== CASES (Dark section) ====== -->
<section class="section section--dark">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow"><?= e($config['portfolio']['title']) ?></span>
            <h2 style="color:var(--white)">Provas reais de capacidade</h2>
            <p class="section__desc" style="color:var(--zinc-400)">Não são promessas — são resultados entregues</p>
        </div>

        <div class="grid-3">
            <?php foreach ($config['portfolio']['items'] as $i => $case): ?>
            <div class="case-card reveal reveal-delay-<?= $i + 1 ?>">
                <div class="case-card__tag"><?= e($case['tag']) ?></div>
                <h3><?= e($case['name']) ?></h3>
                <p><?= e($case['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== PRICING PREVIEW ====== -->
<section class="section">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Planos</span>
            <h2><?= e($config['plans']['title']) ?></h2>
            <p class="section__desc"><?= e($config['plans']['subtitle']) ?></p>
        </div>

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
                    <?php foreach (array_slice($plan['benefits'], 0, 3) as $b): ?>
                    <li><?= e($b) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= e(whatsappURL("Olá! Tenho interesse no plano {$plan['name']}.")) ?>"
                   class="btn <?= $plan['featured'] ? 'btn--primary' : 'btn--outline' ?> btn--full"
                   target="_blank" rel="noopener">
                    Escolher <?= e($plan['name']) ?> →
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-8 reveal">
            <a href="/planos" class="btn btn--outline">Ver detalhes completos →</a>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php include __DIR__ . '/includes/cta-section.php'; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
