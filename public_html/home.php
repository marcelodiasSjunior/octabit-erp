<?php
$page_title       = 'OctaBit | Estruturação Digital para Pequenas Empresas';
$page_description = 'Estruturação digital e arquitetura operacional para pequenas empresas. Sites, automação, dashboards e acompanhamento estratégico.';
$current_page     = 'home';
$header_dark      = true;
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<section class="hero hero--dark">
    <div class="container">
        <span class="hero__badge"><?= e($config['hero']['badge']) ?></span>
        <h1 class="hero__title"><span class="gradient-text"><?= e($config['hero']['title']) ?></span></h1>
        <p class="hero__subtitle"><?= e($config['hero']['subtitle']) ?></p>
        <div class="hero__actions">
            <a href="#cta-form" class="btn btn--primary btn--lg"><?= e($config['hero']['cta_primary']) ?> →</a>
            <a href="#produtos" class="btn btn--ghost btn--lg"><?= e($config['hero']['cta_secondary']) ?></a>
        </div>
    </div>
</section>

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

<section class="section section--subtle" id="problema">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Problema</span>
            <h2><?= e($config['problem']['title']) ?></h2>
        </div>
        <div class="grid grid--2 problem-grid">
            <?php foreach ($config['problem']['items'] as $i => $item): ?>
            <div class="card reveal reveal-delay-<?= $i + 1 ?>">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-alert-triangle"/></svg>
                </div>
                <p><?= e($item) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="produtos">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Solução</span>
            <h2><?= e($config['products']['title']) ?></h2>
            <p class="section__desc"><?= e($config['products']['subtitle']) ?></p>
        </div>
        <div class="grid grid--3">
            <?php foreach ($config['products']['items'] as $i => $product): ?>
            <div class="product-card reveal reveal-delay-<?= $i + 1 ?>">
                <div class="product-card__tag"><?= e($product['tag']) ?></div>
                <?php if (!empty($product['image'])): ?>
                <div class="product-card__media">
                    <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>" loading="lazy">
                </div>
                <?php endif; ?>
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

<section class="section section--subtle" id="como-funciona">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Como funciona</span>
            <h2><?= e($config['solution']['title']) ?></h2>
            <p class="section__desc">Implementação simples, foco em resultado real.</p>
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

<section class="section section--dark" id="casos">
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

<section class="section section--subtle" id="planos">
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
                <a href="#cta-form" class="btn <?= $plan['featured'] ? 'btn--primary' : 'btn--outline' ?> btn--full">
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

<section class="section section--subtle" id="faq">
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

<section class="cta-section cta-section--dark" id="cta-form">
    <div class="container">
        <h2>Descubra agora onde sua operação perde tempo e dinheiro</h2>
        <p>Sem compromisso. Em poucos minutos você recebe um direcionamento claro do melhor próximo passo.</p>
        <form class="cta-inline-form" data-origin="cta-home">
            <input type="text" name="nome" class="form__input" placeholder="Seu nome" required>
            <input type="tel" name="telefone" class="form__input" placeholder="Seu WhatsApp" required>
            <button type="submit" class="btn btn--primary btn--lg">Testar grátis por 14 dias →</button>
            <div class="form__success"></div>
            <p class="cta__microcopy">Resposta em até 2 horas úteis.</p>
        </form>
        <div class="hero__actions" style="margin-top:var(--sp-4)">
            <a href="<?= e(whatsappURL('Olá! Quero saber mais sobre a OctaBit.', 'cta-home')) ?>" class="btn btn--ghost btn--lg" target="_blank" rel="noopener">Prefere falar direto pelo WhatsApp?</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
