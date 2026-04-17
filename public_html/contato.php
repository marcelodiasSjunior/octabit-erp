<?php
$page_title       = 'Contato | OctaBit';
$page_description = 'Entre em contato com a OctaBit. Agende seu diagnóstico de maturidade digital gratuito ou fale com um especialista.';
$current_page     = 'contato';
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== SUB-HERO ====== -->
<section class="hero hero--light hero--sub">
    <div class="container">
        <span class="hero__badge">Contato</span>
        <h1 class="hero__title">Pronto para estruturar o crescimento da sua empresa?</h1>
        <p class="hero__subtitle">Vamos definir juntos a melhor estratégia para sua fase atual.</p>
    </div>
</section>

<!-- ====== CONTATO ====== -->
<section class="section">
    <div class="container">
        <div class="contact-grid">
            <!-- Canais -->
            <div class="reveal">
                <h2 class="mb-8">Fale com a gente</h2>

                <div class="contact-channels">
                    <a href="<?= e($config['contact']['whatsapp_url']) ?>" target="_blank" rel="noopener" class="contact-channel">
                        <div class="contact-channel__icon">
                            <svg viewBox="0 0 24 24"><use href="#icon-message-circle"/></svg>
                        </div>
                        <div class="contact-channel__info">
                            <h4>WhatsApp</h4>
                            <p>Falar com especialista</p>
                        </div>
                    </a>

                    <a href="mailto:<?= e($config['contact']['email']) ?>" class="contact-channel">
                        <div class="contact-channel__icon">
                            <svg viewBox="0 0 24 24"><use href="#icon-mail"/></svg>
                        </div>
                        <div class="contact-channel__info">
                            <h4>E-mail</h4>
                            <p><?= e($config['contact']['email']) ?></p>
                        </div>
                    </a>

                    <a href="<?= e($config['brand']['instagram']) ?>" target="_blank" rel="noopener" class="contact-channel">
                        <div class="contact-channel__icon">
                            <svg viewBox="0 0 24 24"><use href="#icon-instagram"/></svg>
                        </div>
                        <div class="contact-channel__info">
                            <h4>Instagram</h4>
                            <p>@octabit.tech</p>
                        </div>
                    </a>
                </div>

                <p style="font-size:var(--text-sm);color:var(--zinc-500);margin-top:var(--sp-6);">
                    Respondemos em até 2 horas úteis.
                </p>
            </div>

            <!-- Formulário -->
            <div class="reveal reveal-delay-2">
                <h2 class="mb-8">Envie uma mensagem</h2>

                <form id="contact-form" class="form" data-origin="contact">
                    <div class="form__row">
                        <div class="form__group">
                            <label class="form__label" for="contact-nome">Nome</label>
                            <input class="form__input" type="text" id="contact-nome" name="nome" placeholder="Seu nome completo" required>
                        </div>
                        <div class="form__group">
                            <label class="form__label" for="contact-email">E-mail</label>
                            <input class="form__input" type="email" id="contact-email" name="email" placeholder="seu@email.com" required>
                        </div>
                    </div>
                    <div class="form__group">
                        <label class="form__label" for="contact-telefone">WhatsApp (opcional)</label>
                        <input class="form__input" type="tel" id="contact-telefone" name="telefone" placeholder="(XX) XXXXX-XXXX">
                    </div>
                    <div class="form__group">
                        <label class="form__label" for="contact-mensagem">Mensagem</label>
                        <textarea class="form__input" id="contact-mensagem" name="mensagem" placeholder="Como podemos ajudar?" required></textarea>
                    </div>
                    <button type="submit" class="btn btn--primary btn--full btn--lg">Enviar mensagem →</button>
                    <div id="contact-message" class="form__success"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ====== LEAD MAGNET ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="lead-magnet reveal">
            <div>
                <h3><?= e($config['lead_magnet']['title']) ?></h3>
                <p><?= e($config['lead_magnet']['subtitle']) ?></p>
                <form id="lead-form" class="lead-magnet__form" data-origin="lead-magnet">
                    <input class="form__input" type="email" name="email" placeholder="Seu melhor e-mail" required>
                    <button type="submit" class="btn btn--primary"><?= e($config['lead_magnet']['button']) ?> →</button>
                </form>
                <div id="lead-message" class="form__success mt-4"></div>
            </div>
            <div style="display:flex;align-items:center;justify-content:center">
                <svg viewBox="0 0 24 24" style="width:64px;height:64px;stroke:var(--zinc-300);fill:none;stroke-width:1"><use href="#icon-activity"/></svg>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
