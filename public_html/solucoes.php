<?php
$page_title       = 'Soluções | OctaBit';
$page_description = 'Catálogo de soluções OctaBit: presença digital, BI, automação WhatsApp e integrações. Escolha o que sua empresa precisa agora.';
$current_page     = 'solucoes';
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== SUB-HERO ====== -->
<section class="hero hero--light hero--sub">
    <div class="container">
        <span class="hero__badge">Catálogo</span>
        <h1 class="hero__title"><?= e($config['catalog']['title']) ?></h1>
        <p class="hero__subtitle"><?= e($config['catalog']['subtitle']) ?></p>
    </div>
</section>

<!-- ====== CATÁLOGO ====== -->
<section class="section">
    <div class="container">
        <div class="grid-2">
            <?php foreach ($config['catalog']['items'] as $i => $item): ?>
            <div class="catalog-card reveal reveal-delay-<?= ($i % 3) + 1 ?>">
                <div class="catalog-card__header">
                    <div class="bento__icon">
                        <svg viewBox="0 0 24 24"><use href="#icon-<?= e($item['icon']) ?>"/></svg>
                    </div>
                    <div class="catalog-card__price"><?= e($item['price']) ?></div>
                </div>
                <h3><?= e($item['name']) ?></h3>
                <p><?= e($item['desc']) ?></p>
                <a href="<?= e(whatsappURL($item['whatsapp_msg'])) ?>"
                   class="btn btn--primary btn--full"
                   target="_blank" rel="noopener">
                    Solicitar via WhatsApp →
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== COMO FUNCIONA (Timeline) ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Processo</span>
            <h2>Como funciona</h2>
            <p class="section__desc">Do primeiro contato à entrega, tudo é transparente</p>
        </div>

        <div class="timeline">
            <div class="timeline__step reveal reveal-delay-1">
                <div class="timeline__num">1</div>
                <h4>Diagnóstico</h4>
                <p>Entendemos sua situação atual, necessidades e objetivos de curto prazo.</p>
            </div>
            <div class="timeline__step reveal reveal-delay-2">
                <div class="timeline__num">2</div>
                <h4>Proposta</h4>
                <p>Definimos escopo, prazo e investimento de forma clara e sem surpresas.</p>
            </div>
            <div class="timeline__step reveal reveal-delay-3">
                <div class="timeline__num">3</div>
                <h4>Entrega</h4>
                <p>Implantamos a solução com acompanhamento e suporte contínuo.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php
$cta_title = 'Não sabe qual solução escolher?';
$cta_subtitle = 'Fale com um especialista e receba uma recomendação personalizada.';
$cta_button_text = 'Falar com especialista';
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
