<?php
$page_title       = 'Serviços | OctaBit';
$page_description = 'Conheça o método PTE-I e os serviços de estruturação digital da OctaBit. Presença, Tecnologia, Escala e Inteligência para pequenas empresas.';
$current_page     = 'servicos';
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== SUB-HERO ====== -->
<section class="hero hero--light hero--sub">
    <div class="container">
        <span class="hero__badge">Método + Serviços</span>
        <h1 class="hero__title"><?= e($config['services']['title']) ?></h1>
        <p class="hero__subtitle"><?= e($config['services']['subtitle']) ?></p>
    </div>
</section>

<!-- ====== MÉTODO PTE-I (Feature Rows alternados) ====== -->
<section class="section" id="metodo-ptei">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Método PTE-I</span>
            <h2><?= e($config['method']['subtitle']) ?></h2>
        </div>

        <?php foreach ($config['method']['steps'] as $i => $step): ?>
        <div class="feature-row<?= $i % 2 ? ' feature-row--reverse' : '' ?> reveal mb-12">
            <div class="feature-row__content">
                <span class="section__eyebrow"><?= e($step['letter']) ?> — <?= e($step['title']) ?></span>
                <h3><?= e($step['title']) ?></h3>
                <p style="color:var(--zinc-500);line-height:1.7"><?= e($step['desc']) ?></p>
            </div>
            <div class="feature-row__visual">
                <svg viewBox="0 0 24 24" style="width:48px;height:48px;stroke:var(--zinc-300);fill:none;stroke-width:1.5"><use href="#icon-<?= e($step['icon']) ?>"/></svg>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ====== SERVIÇOS (Bento Grid) ====== -->
<section class="section section--subtle" id="servicos">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">O que entregamos</span>
            <h2>Cada serviço atua em um eixo do método PTE-I</h2>
        </div>
        <div class="bento">
            <?php foreach ($config['services']['items'] as $i => $srv): ?>
            <div class="bento__card reveal reveal-delay-<?= ($i % 3) + 1 ?>">
                <div class="bento__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-<?= e($srv['icon']) ?>"/></svg>
                </div>
                <h3><?= e($srv['title']) ?></h3>
                <p><?= e($srv['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== PARA QUEM ====== -->
<section class="section" id="para-quem">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Público-alvo</span>
            <h2><?= e($config['target_audience']['title']) ?></h2>
        </div>
        <div class="audience-grid">
            <?php foreach ($config['target_audience']['items'] as $i => $item): ?>
            <div class="audience-item reveal reveal-delay-<?= ($i % 3) + 1 ?>">
                <svg viewBox="0 0 24 24"><use href="#icon-<?= e($item['icon']) ?>"/></svg>
                <span><?= e($item['text']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php
$cta_title = 'Quer aplicar o método PTE-I na sua empresa?';
$cta_subtitle = 'Comece pelo diagnóstico gratuito e descubra o caminho mais eficiente.';
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
