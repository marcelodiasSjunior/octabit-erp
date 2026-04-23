<?php
/**
 * OctaBit — Footer + scripts de fechamento
 */
?>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer__grid">
            <div class="footer__brand">
                <img src="<?= e($config['brand']['logo']) ?>" alt="<?= e($config['brand']['name']) ?>">
                <p><?= e($config['footer']['text']) ?></p>
            </div>

            <div class="footer__col">
                <h4>Navegação</h4>
                <ul>
                    <?php foreach ($config['nav'] as $item): ?>
                    <li><a href="<?= e($item['href']) ?>"><?= e($item['text']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="footer__col">
                <h4>Contato</h4>
                <ul>
                    <li><a href="<?= e($config['contact']['whatsapp_url']) ?>" target="_blank" rel="noopener">WhatsApp</a></li>
                    <li><a href="mailto:<?= e($config['contact']['email']) ?>"><?= e($config['contact']['email']) ?></a></li>
                    <li><a href="<?= e($config['brand']['instagram']) ?>" target="_blank" rel="noopener">Instagram</a></li>
                </ul>
            </div>
        </div>

        <div class="footer__bottom">
            <p><?= e($config['footer']['copyright']) ?></p>
            <?php if (!empty($config['footer']['cnpj'])): ?>
            <p>CNPJ: <?= e($config['footer']['cnpj']) ?></p>
            <?php endif; ?>
        </div>
    </div>
</footer>

<svg aria-hidden="true" width="0" height="0" style="position:absolute;visibility:hidden;overflow:hidden">
    <defs>
        <symbol id="icon-alert-triangle" viewBox="0 0 24 24">
            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0"></path>
            <path d="M12 9v4"></path>
            <path d="M12 17h.01"></path>
        </symbol>
        <symbol id="icon-activity" viewBox="0 0 24 24">
            <path d="M22 12h-4l-3 9-6-18-3 9H2"></path>
        </symbol>
        <symbol id="icon-zap" viewBox="0 0 24 24">
            <path d="M13 2 3 14h7l-1 8 10-12h-7l1-8z"></path>
        </symbol>
        <symbol id="icon-briefcase" viewBox="0 0 24 24">
            <path d="M16 20V4a2 2 0 0 0-2-2H10a2 2 0 0 0-2 2v16"></path>
            <path d="M2 7h20"></path>
            <path d="M6 20h12a2 2 0 0 0 2-2V7H4v11a2 2 0 0 0 2 2Z"></path>
        </symbol>
        <symbol id="icon-search" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
        </symbol>
        <symbol id="icon-tool" viewBox="0 0 24 24">
            <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.4 9.4a2 2 0 0 1-2.8-2.8l9.4-9.4a4 4 0 0 0-5-5L7 8.4l-3-3 4.9-4.9 3 3-1.2 2.8z"></path>
        </symbol>
        <symbol id="icon-bar-chart-2" viewBox="0 0 24 24">
            <line x1="18" x2="18" y1="20" y2="10"></line>
            <line x1="12" x2="12" y1="20" y2="4"></line>
            <line x1="6" x2="6" y1="20" y2="14"></line>
        </symbol>
        <symbol id="icon-globe" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M2 12h20"></path>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
        </symbol>
        <symbol id="icon-cpu" viewBox="0 0 24 24">
            <path d="M12 20v2"></path>
            <path d="M12 2v2"></path>
            <path d="M17 20v2"></path>
            <path d="M17 2v2"></path>
            <path d="M2 12h2"></path>
            <path d="M2 17h2"></path>
            <path d="M2 7h2"></path>
            <path d="M20 12h2"></path>
            <path d="M20 17h2"></path>
            <path d="M20 7h2"></path>
            <path d="M7 20v2"></path>
            <path d="M7 2v2"></path>
            <rect x="4" y="4" width="16" height="16" rx="2"></rect>
            <rect x="8" y="8" width="8" height="8" rx="1"></rect>
        </symbol>
        <symbol id="icon-trending-up" viewBox="0 0 24 24">
            <path d="M22 7 13.5 15.5l-5-5L2 17"></path>
            <path d="M16 7h6v6"></path>
        </symbol>
        <symbol id="icon-clipboard" viewBox="0 0 24 24">
            <rect x="8" y="2" width="8" height="4" rx="1"></rect>
            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
        </symbol>
        <symbol id="icon-target" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="8"></circle>
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v2"></path>
            <path d="M12 20v2"></path>
            <path d="M2 12h2"></path>
            <path d="M20 12h2"></path>
        </symbol>
    </defs>
</svg>

<script defer src="/js/app.js?v=<?= filemtime(__DIR__ . '/../js/app.js') ?>"></script>
</body>
</html>
