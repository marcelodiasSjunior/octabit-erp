<?php
$page_title       = 'Produtos | OctaBit — OctaPonto, OctaVendas e OctaCRM';
$page_description = 'Sistemas prontos para pequenas empresas: controle de ponto (OctaPonto), gestão de vendas (OctaVendas) e CRM para clientes (OctaCRM). Teste grátis.';
$current_page     = 'produtos';
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== SUB-HERO ====== -->
<section class="hero hero--light hero--sub">
    <div class="container">
        <span class="hero__badge">Produtos &amp; Soluções</span>
        <h1 class="hero__title"><?= e($config['products']['title']) ?></h1>
        <p class="hero__subtitle"><?= e($config['products']['subtitle']) ?></p>
    </div>
</section>

<!-- ====== PRODUTOS SaaS ====== -->
<section class="section section--sm">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Produtos</span>
            <h2>Ferramentas próprias</h2>
        </div>

        <div class="grid grid--3">
            <?php foreach ($config['products']['items'] as $i => $product): ?>
            <div class="product-card reveal reveal-delay-<?= $i + 1 ?>">
                <div class="product-card__tag"><?= e($product['tag']) ?></div>
                <div class="product-card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-<?= e($product['icon']) ?>"/></svg>
                </div>
                <h3><?= e($product['name']) ?></h3>
                <p><?= e($product['desc']) ?></p>
                <a href="<?= e($product['url']) ?>" class="btn btn--outline btn--sm"><?= e($product['cta']) ?> →</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== CATÁLOGO DE SOLUÇÕES ====== -->
<section class="section section--subtle section--sm">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Soluções</span>
            <h2><?= e($config['catalog']['title']) ?></h2>
            <p class="section__desc"><?= e($config['catalog']['subtitle']) ?></p>
        </div>

        <div class="grid grid--2">
            <?php foreach ($config['catalog']['items'] as $i => $item): ?>
            <div class="catalog-card reveal reveal-delay-<?= ($i % 3) + 1 ?>">
                <div class="catalog-card__header">
                    <div class="bento__icon">
                        <svg viewBox="0 0 24 24"><use href="#icon-<?= e($item['icon']) ?>"/></svg>
                    </div>
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

<!-- ====== CTA ====== -->
<?php
$cta_title = 'Não encontrou o que precisa?';
$cta_subtitle = 'Fale com a gente e criamos a solução certa para o seu negócio.';
$cta_button_text = 'Falar com especialista';
$cta_button_href = '/contato';
$cta_dark = true;
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
