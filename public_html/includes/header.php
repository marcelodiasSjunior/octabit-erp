<?php
/**
 * OctaBit — Header / Navegação
 * Usa $config e $current_page do escopo pai.
 */
?>
<header class="header<?= !empty($header_dark) ? ' header--dark' : '' ?>" id="header">
    <div class="container header__inner">
        <a href="/" class="header__logo" aria-label="<?= e($config['brand']['name']) ?> — Início">
            <img src="<?= e($config['brand']['logo']) ?>" alt="<?= e($config['brand']['name']) ?>" width="120" height="32">
        </a>

        <button class="header__toggle" id="nav-toggle" aria-label="Abrir menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <nav class="header__nav" id="nav-menu" role="navigation">
            <?php foreach ($config['nav'] as $item): ?>
                <?php
                    $slug = trim($item['href'], '/') ?: 'home';
                    $is_active = ($slug === $current_page);
                ?>
                <a href="<?= e($item['href']) ?>"
                   class="header__link<?= $is_active ? ' header__link--active' : '' ?>">
                    <?= e($item['text']) ?>
                </a>
            <?php endforeach; ?>
            <a href="/contato" class="btn btn--primary header__cta">Diagnóstico Gratuito</a>
        </nav>
    </div>
</header>
