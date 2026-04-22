<?php
$page_title       = 'OctaBit | Sistemas para Pequenas Empresas — Ponto, Vendas e CRM';
$page_description = 'Sistemas prontos para organizar sua operação: controle de ponto, gestão de vendas e CRM. Para lojas, oficinas, deliveries e empresas com equipe.';
$current_page     = 'home';
$header_dark      = true;
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>
<!-- landing redeploy marker: 2026-04-22 -->

<!-- ====== 1. HERO ====== -->
<section class="hero hero--dark">
    <div class="container">
        <span class="hero__badge"><?= e($config['hero']['badge']) ?></span>
        <h1 class="hero__title"><span class="gradient-text"><?= e($config['hero']['title']) ?></span></h1>
        <p class="hero__subtitle"><?= e($config['hero']['subtitle']) ?></p>
        <div class="hero__actions">
            <a href="#cta-form" class="btn btn--primary btn--lg"><?= e($config['hero']['cta_primary']) ?> →</a>
            <a href="#produtos" class="btn btn--ghost btn--lg"><?= e($config['hero']['cta_secondary']) ?></a>
        </div>
        <div class="hero__stats">
            <?php foreach ($config['authority']['items'] as $stat): ?>
            <div class="hero__stat">
                <span class="hero__stat-number"><?= e($stat['number']) ?></span>
                <span class="hero__stat-label"><?= e($stat['label']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== 2. PROBLEMA ====== -->
<section class="section section--sm" id="problema">
    <div class="container">
        <div class="section__header reveal">
            <h2><?= e($config['problem']['title']) ?></h2>
        </div>
        <div class="problem-grid reveal">
            <?php foreach ($config['problem']['items'] as $i => $item): ?>
            <div class="problem-item reveal reveal-delay-<?= $i + 1 ?>">
                <span class="problem-item__icon">✕</span>
                <span class="problem-item__text"><?= e($item) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== 3. PRODUTOS (eixo central) ====== -->
<section class="section section--subtle section--sm" id="produtos">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Nossos Produtos</span>
            <h2><?= e($config['solution']['title']) ?></h2>
        </div>

        <div class="grid grid--3">
            <?php foreach ($config['products']['items'] as $i => $product): ?>
            <div class="card reveal reveal-delay-<?= $i + 1 ?>">
                <div class="card__tag"><?= e($product['tag']) ?></div>
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-<?= e($product['icon']) ?>"/></svg>
                </div>
                <h3><?= e($product['name']) ?></h3>
                <p><?= e($product['desc']) ?></p>
                <a href="<?= e($product['url']) ?>" class="btn btn--outline btn--full" style="margin-top:auto">
                    <?= e($product['cta']) ?> →
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-8 reveal">
            <a href="#cta-form" class="btn btn--primary btn--lg">Testar grátis por 14 dias →</a>
        </div>
    </div>
</section>

<!-- ====== 4. PARA QUEM ====== -->
<section class="section section--sm" id="para-quem">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Para quem</span>
            <h2><?= e($config['target_audience']['title']) ?></h2>
        </div>

        <div class="grid grid--2">
            <?php foreach ($config['target_audience']['items'] as $i => $item): ?>
            <div class="problem-item problem-item--positive reveal reveal-delay-<?= $i + 1 ?>">
                <span class="problem-item__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-<?= e($item['icon']) ?>"/></svg>
                </span>
                <span class="problem-item__text"><?= e($item['text']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== 5. PROVA SOCIAL ====== -->
<section class="section section--dark section--sm" id="casos">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow section__eyebrow--light"><?= e($config['portfolio']['title']) ?></span>
            <h2>Veja como outras empresas resolveram</h2>
        </div>

        <div class="grid grid--2">
            <?php foreach ($config['portfolio']['items'] as $i => $case): ?>
            <div class="case-card reveal reveal-delay-<?= $i + 1 ?>">
                <div class="case-card__tag"><?= e($case['tag']) ?></div>
                <h3><?= e($case['name']) ?></h3>
                <p><?= e($case['desc']) ?></p>
                <?php if (!empty($case['quote'])): ?>
                <blockquote class="case-card__quote">
                    <p>"<?= e($case['quote']) ?>"</p>
                    <cite>— <?= e($case['author']) ?>, <?= e($case['name']) ?></cite>
                </blockquote>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-8 reveal">
            <a href="#cta-form" class="btn btn--primary btn--lg">Quero resultados assim →</a>
        </div>
    </div>
</section>

<!-- ====== 6. SERVIÇOS EXTRAS ====== -->
<section class="section section--sm" id="servicos-preview">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Serviços</span>
            <h2><?= e($config['services']['title']) ?></h2>
            <p class="section__desc"><?= e($config['services']['subtitle']) ?></p>
        </div>

        <div class="grid grid--2">
            <?php foreach ($config['services']['items'] as $i => $srv): ?>
            <div class="card card--compact reveal reveal-delay-<?= $i + 1 ?>">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-<?= e($srv['icon']) ?>"/></svg>
                </div>
                <h3><?= e($srv['title']) ?></h3>
                <p><?= e($srv['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-8 reveal">
            <a href="/servicos" class="btn btn--outline">Ver todos os serviços →</a>
        </div>
    </div>
</section>

<!-- ====== 7. PLANOS ====== -->
<section class="section section--subtle section--sm" id="planos">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Planos</span>
            <h2><?= e($config['plans']['title']) ?></h2>
            <p class="section__desc"><?= e($config['plans']['subtitle']) ?></p>
        </div>

        <div class="plans">
            <?php foreach ($config['plans']['list'] as $i => $plan): ?>
            <div class="plan<?= $plan['featured'] ? ' plan--featured' : '' ?> reveal reveal-delay-<?= $i + 1 ?>">
                <?php if (!empty($plan['badge'])): ?>
                <div class="plan__badge"><?= e($plan['badge']) ?></div>
                <?php endif; ?>
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
                <a href="#cta-form"
                   class="btn <?= $plan['featured'] ? 'btn--primary' : 'btn--outline' ?> btn--full">
                    Começar com <?= e($plan['name']) ?> →
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($config['plans']['guarantee'])): ?>
        <div class="text-center mt-8 reveal">
            <p class="plan__guarantee">🔒 <?= e($config['plans']['guarantee']) ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ====== 8. FAQ ====== -->
<section class="section section--sm" id="faq">
    <div class="container">
        <div class="section__header reveal">
            <h2><?= e($config['faq']['title']) ?></h2>
        </div>
        <div class="faq reveal">
            <?php foreach ($config['faq']['items'] as $faq): ?>
            <div class="faq__item">
                <button class="faq__question" type="button" aria-expanded="false">
                    <span><?= e($faq['q']) ?></span>
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq__answer">
                    <p><?= e($faq['a']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== 9. CTA FINAL ====== -->
<section class="cta-section cta-section--dark" id="cta-form">
    <div class="container">
        <h2>Organize sua operação em 14 dias — sem risco.</h2>
        <p>Teste grátis qualquer sistema. Se não resolver, você não paga nada.</p>
        <form class="cta-inline-form" data-origin="cta-home">
            <input type="text" name="nome" class="form__input" placeholder="Seu nome" required>
            <input type="tel" name="telefone" class="form__input" placeholder="Seu WhatsApp" required>
            <button type="submit" class="btn btn--primary btn--lg" style="grid-column:1/-1">Começar teste grátis →</button>
            <div class="form__success"></div>
        </form>
        <p class="cta__microcopy">Sem cartão de crédito. Respondemos em até 2 horas.</p>
        <div class="hero__actions" style="margin-top:var(--sp-3)">
            <a href="<?= e(whatsappURL('Olá! Quero testar os sistemas da OctaBit.', 'cta-home')) ?>" class="btn btn--ghost btn--lg" target="_blank" rel="noopener">Prefere falar direto? Chama no WhatsApp →</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
