<?php
$page_title       = 'Sobre | OctaBit';
$page_description = 'Conheça a OctaBit — sua parceira de estruturação digital e crescimento operacional. Missão, valores e cases de sucesso.';
$current_page     = 'sobre';
$header_dark      = true;
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== SUB-HERO (Dark) ====== -->
<section class="hero hero--dark hero--sub">
    <div class="container">
        <span class="hero__badge">Sobre a OctaBit</span>
        <h1 class="hero__title"><span class="gradient-text">Mais que tecnologia, entregamos estrutura de crescimento</span></h1>
        <p class="hero__subtitle"><?= e($config['about']['text']) ?></p>
    </div>
</section>

<!-- ====== MISSÃO & VISÃO ====== -->
<section class="section">
    <div class="container">
        <div class="about-grid">
            <div class="about-card reveal">
                <h3>Missão</h3>
                <p><?= e($config['about']['mission']) ?></p>
            </div>
            <div class="about-card reveal reveal-delay-1">
                <h3>Visão</h3>
                <p><?= e($config['about']['vision']) ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CASES (Dark) ====== -->
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

<!-- ====== VALORES ====== -->
<section class="section">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Princípios</span>
            <h2>O que guia cada decisão e entrega</h2>
        </div>
        <div class="values-grid">
            <div class="value-card reveal reveal-delay-1">
                <div class="value-card__emoji">🎯</div>
                <h4>Transparência</h4>
                <p>Clareza em cada etapa do processo</p>
            </div>
            <div class="value-card reveal reveal-delay-1">
                <div class="value-card__emoji">⚡</div>
                <h4>Simplicidade</h4>
                <p>Operação enxuta e eficiente</p>
            </div>
            <div class="value-card reveal reveal-delay-2">
                <div class="value-card__emoji">📈</div>
                <h4>Resultados</h4>
                <p>Foco em impacto real, não vaidade</p>
            </div>
            <div class="value-card reveal reveal-delay-2">
                <div class="value-card__emoji">🔄</div>
                <h4>Evolução</h4>
                <p>Melhoria contínua sempre</p>
            </div>
            <div class="value-card reveal reveal-delay-3">
                <div class="value-card__emoji">🤝</div>
                <h4>Proximidade</h4>
                <p>Parceria, não apenas fornecimento</p>
            </div>
            <div class="value-card reveal reveal-delay-3">
                <div class="value-card__emoji">💡</div>
                <h4>Visão de Negócio</h4>
                <p>Tecnologia a serviço da estratégia</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== STATS ====== -->
<section class="stats-band">
    <div class="container">
        <div class="stats-band__grid">
            <?php foreach ($config['authority']['items'] as $stat): ?>
            <div class="reveal">
                <div class="stats-band__number"><?= e($stat['number']) ?></div>
                <div class="stats-band__label"><?= e($stat['label']) ?></div>
            </div>
            <?php endforeach; ?>
            <div class="reveal">
                <div class="stats-band__number">3+</div>
                <div class="stats-band__label">Projetos ativos</div>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php
$cta_title = 'Quer a OctaBit como parceira?';
$cta_subtitle = 'Vamos conversar sobre como estruturar o crescimento da sua empresa.';
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
