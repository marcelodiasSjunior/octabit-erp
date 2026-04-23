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
                <span class="proof-bar__label">
                    <strong class="proof-bar__label-title"><?= e($stat['label']) ?></strong>
                    <span class="proof-bar__label-desc"><?= e($stat['desc']) ?></span>
                </span>
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
        <div class="text-center mt-8 reveal">
            <a href="/produtos" class="btn btn--outline">Ver todos os produtos →</a>
        </div>
    </div>
</section>

<section class="section section--subtle" id="explorar">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Navegação rápida</span>
            <h2>Mais detalhes nos menus certos</h2>
            <p class="section__desc">A home fica objetiva, e você aprofunda onde fizer sentido.</p>
        </div>
        <div class="grid grid--4">
            <a href="/produtos" class="card reveal reveal-delay-1" style="text-decoration:none;color:inherit">
                <div class="card__icon"><svg viewBox="0 0 24 24"><use href="#icon-activity"/></svg></div>
                <h3>Produtos</h3>
                <p>Comparar OctaPonto, OctaVendas e OctaCRM.</p>
            </a>
            <a href="/servicos" class="card reveal reveal-delay-2" style="text-decoration:none;color:inherit">
                <div class="card__icon"><svg viewBox="0 0 24 24"><use href="#icon-tool"/></svg></div>
                <h3>Serviços</h3>
                <p>Projetos sob medida, escopo e entregas.</p>
            </a>
            <a href="/planos" class="card reveal reveal-delay-3" style="text-decoration:none;color:inherit">
                <div class="card__icon"><svg viewBox="0 0 24 24"><use href="#icon-bar-chart-2"/></svg></div>
                <h3>Planos</h3>
                <p>Valores, implantação e o que está incluso.</p>
            </a>
            <a href="/sobre" class="card reveal reveal-delay-4" style="text-decoration:none;color:inherit">
                <div class="card__icon"><svg viewBox="0 0 24 24"><use href="#icon-briefcase"/></svg></div>
                <h3>Sobre</h3>
                <p>Método, forma de trabalho e posicionamento.</p>
            </a>
        </div>
        <div class="text-center mt-8 reveal">
            <a href="/contato" class="btn btn--outline">Falar com especialista →</a>
        </div>
    </div>
</section>

<section class="section section--subtle" id="faq">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Dúvidas</span>
            <h2>Dúvidas frequentes</h2>
        </div>
        <div class="faq reveal">
            <?php foreach (array_slice($config['faq']['items'], 0, 4) as $faq): ?>
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
        <div class="text-center mt-8 reveal">
            <a href="/contato" class="btn btn--outline">Ver mais e tirar dúvidas →</a>
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
