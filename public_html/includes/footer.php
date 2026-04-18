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
        </div>
    </div>
</footer>

<script defer src="/js/app.js?v=<?= filemtime(__DIR__ . '/../js/app.js') ?>"></script>
</body>
</html>
