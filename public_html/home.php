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
            <a href="#cta-form" class="btn btn--primary btn--lg"><?= e($config['hero']['cta_primary']) ?> →</a>
            <a href="#como-funciona" class="btn btn--ghost btn--lg"><?= e($config['hero']['cta_secondary']) ?></a>
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
                <span class="proof-bar__label"><strong><?= e($stat['label']) ?></strong><br><?= e($stat['desc']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== PARA QUEM É ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Para quem é</span>
            <h2><?= e($config['target_audience']['title']) ?></h2>
        </div>
        <div class="grid grid--2 reveal">
            <?php foreach ($config['target_audience']['items'] as $item): ?>
            <div class="audience-item">
                <svg viewBox="0 0 24 24"><use href="#icon-<?= e($item['icon']) ?>"/></svg>
                <span><?= e($item['text']) ?></span>
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

        <div class="grid grid--2">
            <?php foreach ($config['services']['items'] as $i => $srv): ?>
            <div class="card reveal reveal-delay-<?= $i + 1 ?>">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-<?= e($srv['icon']) ?>"/></svg>
                </div>
                <h3><?= e($srv['title']) ?></h3>
                <p><?= e($srv['desc']) ?></p>
                <?php if (!empty($srv['deliverables'])): ?>
                <ul class="card__list">
                    <?php foreach ($srv['deliverables'] as $d): ?>
                    <li><?= e($d) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-8 reveal">
            <a href="/servicos" class="btn btn--outline">Ver todos os serviços →</a>
        </div>
    </div>
</section>

<!-- ====== HOW IT WORKS (Timeline) ====== -->
<section class="section section--subtle" id="como-funciona">
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
            <span class="section__eyebrow section__eyebrow--light"><?= e($config['portfolio']['title']) ?></span>
            <h2>O que nossos clientes conquistaram</h2>
            <p class="section__desc" style="color:var(--zinc-400)">Resultados reais de empresas que estruturamos</p>
        </div>

        <div class="grid grid--3">
            <?php foreach ($config['portfolio']['items'] as $i => $case): ?>
            <div class="case-card reveal reveal-delay-<?= $i + 1 ?>">
                <div class="case-card__tag"><?= e($case['tag']) ?></div>
                <h3><?= e($case['name']) ?></h3>
                <p><?= e($case['desc']) ?></p>
                <?php if (!empty($case['quote'])): ?>
                <blockquote class="case-card__quote">
                    <p>“<?= e($case['quote']) ?>”</p>
                    <cite>— <?= e($case['author']) ?>, <?= e($case['name']) ?></cite>
                </blockquote>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== PRODUTOS (SaaS) ====== -->
<section class="section">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Produtos</span>
            <h2><?= e($config['products']['title']) ?></h2>
            <p class="section__desc"><?= e($config['products']['subtitle']) ?></p>
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

<!-- ====== PRICING PREVIEW ====== -->
<section class="section section--subtle">
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
                <a href="<?= e(whatsappURL("Olá! Tenho interesse no plano {$plan['name']}.", 'planos')) ?>"
                   class="btn <?= $plan['featured'] ? 'btn--primary' : 'btn--outline' ?> btn--full"
                   target="_blank" rel="noopener">
                    Escolher <?= e($plan['name']) ?> →
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($config['plans']['guarantee'])): ?>
        <div class="text-center mt-8 reveal">
            <p class="plan__guarantee">🔒 <?= e($config['plans']['guarantee']) ?></p>
        </div>
        <?php endif; ?>

        <div class="text-center mt-8 reveal">
            <a href="/planos" class="btn btn--outline">Ver detalhes completos →</a>
        </div>
    </div>
</section>

<!-- ====== FAQ ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">FAQ</span>
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

<!-- ====== CTA COM FORMULÁRIO INLINE ====== -->
<section class="cta-section cta-section--dark" id="cta-form">
    <div class="container">
        <h2>Sua empresa pronta para o próximo nível</h2>
        <p>Preencha seus dados e receba um diagnóstico gratuito da sua maturidade digital.</p>
        <form class="cta-inline-form" data-origin="cta-home">
            <input type="text" name="nome" class="form__input" placeholder="Seu nome" required>
            <input type="email" name="email" class="form__input" placeholder="Seu e-mail" required>
            <input type="tel" name="telefone" class="form__input" placeholder="WhatsApp" style="grid-column:span 2">
            <button type="submit" class="btn btn--primary btn--lg">Quero meu diagnóstico gratuito →</button>
            <div class="form__success"></div>
        </form>
        <div class="hero__actions" style="margin-top:var(--sp-4)">
            <a href="<?= e(whatsappURL('Olá! Quero saber mais sobre a OctaBit.', 'cta-home')) ?>" class="btn btn--ghost btn--lg" target="_blank" rel="noopener">Prefere falar pelo WhatsApp?</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
