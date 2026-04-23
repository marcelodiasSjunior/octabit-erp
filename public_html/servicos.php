<?php
$page_title       = 'Serviços | OctaBit';
$page_description = 'Serviços de software house da OctaBit: sites institucionais, sistemas sob medida, aplicativos mobile, automações e integrações para operações reais.';
$current_page     = 'servicos';
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== SUB-HERO ====== -->
<section class="hero hero--light hero--sub">
    <div class="container">
        <span class="hero__badge">Software House</span>
        <h1 class="hero__title"><?= e($config['services']['title']) ?></h1>
        <p class="hero__subtitle"><?= e($config['services']['subtitle']) ?></p>
    </div>
</section>

<!-- ====== POSICIONAMENTO ====== -->
<section class="section" id="como-atuamos">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Como atuamos</span>
            <h2>Desenvolvimento orientado à necessidade real do cliente</h2>
            <p class="section__desc">Entramos quando um site pronto não resolve, quando a operação precisa de sistema próprio ou quando o produto digital precisa ser construído do zero com mais profundidade técnica.</p>
        </div>
        <div class="grid grid--3">
            <div class="card reveal reveal-delay-1">
                <div class="card__icon"><svg viewBox="0 0 24 24"><use href="#icon-globe"/></svg></div>
                <h3>Sites e presença digital</h3>
                <p>Projetos institucionais e comerciais com estrutura profissional para apresentar a empresa, captar contatos e sustentar vendas.</p>
            </div>
            <div class="card reveal reveal-delay-2">
                <div class="card__icon"><svg viewBox="0 0 24 24"><use href="#icon-cpu"/></svg></div>
                <h3>Sistemas sob medida</h3>
                <p>Soluções web com lógica de negócio, operação administrativa, integrações e fluxo próprio quando a empresa precisa de algo além do padrão.</p>
            </div>
            <div class="card reveal reveal-delay-3">
                <div class="card__icon"><svg viewBox="0 0 24 24"><use href="#icon-activity"/></svg></div>
                <h3>Apps e produtos digitais</h3>
                <p>Aplicativos mobile, áreas do cliente, plataformas internas e produtos digitais construídos de acordo com o cenário de uso real.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== SERVIÇOS (Bento Grid) ====== -->
<section class="section section--subtle" id="servicos">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">O que entregamos</span>
            <h2>Soluções típicas de uma software house</h2>
            <p class="section__desc">Cada projeto pode começar em um formato mais objetivo ou evoluir para algo mais robusto conforme a necessidade da operação.</p>
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
$cta_title = 'Quer tirar um projeto de software do papel?';
$cta_subtitle = 'Converse com a OctaBit e entenda a melhor abordagem para site, sistema, app ou integração no seu cenário.';
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
