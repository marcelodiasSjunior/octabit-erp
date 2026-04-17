<?php
/**
 * OctaBit — CTA Section (reutilizável)
 * Espera: $cta_title, $cta_subtitle, $cta_button_text, $cta_button_href (opcional)
 */
$cta_title       = $cta_title       ?? 'Sua empresa pronta para o próximo nível';
$cta_subtitle    = $cta_subtitle    ?? 'Comece sua transformação digital hoje.';
$cta_button_text = $cta_button_text ?? 'Agendar diagnóstico gratuito';
$cta_button_href = $cta_button_href ?? '/contato';
$cta_dark        = $cta_dark        ?? true;
?>
<section class="cta-section<?= $cta_dark ? ' cta-section--dark' : '' ?>">
    <div class="container">
        <h2><?= e($cta_title) ?></h2>
        <p><?= e($cta_subtitle) ?></p>
        <div class="hero__actions">
            <a href="<?= e($cta_button_href) ?>" class="btn btn--primary btn--lg"><?= e($cta_button_text) ?> →</a>
            <a href="<?= e(whatsappURL('Olá! Quero saber mais sobre a OctaBit.')) ?>" class="btn btn--ghost btn--lg" target="_blank" rel="noopener">Falar com especialista</a>
        </div>
    </div>
</section>
