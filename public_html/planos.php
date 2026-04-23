<?php
$page_title       = 'Planos | OctaBit';
$page_description = 'Consultoria recorrente PTE-I com execução guiada para templates institucionais, dashboards BI e automações leves. Produtos próprios e projetos complexos são tratados separadamente.';
$current_page     = 'planos';
require_once __DIR__ . '/includes/config.php';
include __DIR__ . '/includes/head.php';
?>

<!-- ====== SUB-HERO ====== -->
<section class="hero hero--light hero--sub">
    <div class="container">
        <span class="hero__badge">Consultoria + Execução Guiada</span>
        <h1 class="hero__title"><?= e($config['plans']['title']) ?></h1>
        <p class="hero__subtitle"><?= e($config['plans']['subtitle']) ?></p>
    </div>
</section>

<!-- ====== PLANOS ====== -->
<section class="section">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Como funciona</span>
            <h2>Consultoria recorrente com escopo claro e evolução contínua</h2>
            <p class="section__desc">Os planos cobrem templates institucionais, dashboards BI e automações leves com rotina definida de acompanhamento. Produtos próprios da OctaBit, sistemas complexos e automações avançadas são tratados como serviços adicionais, fora do plano.</p>
        </div>
        <div class="plans">
            <?php foreach ($config['plans']['list'] as $i => $plan): ?>
            <div class="plan<?= $plan['featured'] ? ' plan--featured' : '' ?> reveal reveal-delay-<?= $i + 1 ?>">
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
                <a href="<?= e(whatsappURL("Olá! Tenho interesse no plano {$plan['name']}. Podemos conversar?")) ?>"
                   class="btn <?= $plan['featured'] ? 'btn--primary' : 'btn--outline' ?> btn--full"
                   target="_blank" rel="noopener">
                    Falar sobre o plano <?= e($plan['name']) ?> →
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12 reveal">
            <p style="color:var(--zinc-500);font-size:var(--text-sm);max-width:480px;margin:0 auto var(--sp-4);">
                Cada plano atende um estágio de maturidade diferente. No diagnóstico, alinhamos escopo, frequência de acompanhamento e nível de prioridade.
            </p>
            <a href="/contato" class="btn btn--outline">Agendar diagnóstico gratuito →</a>
        </div>
    </div>
</section>

<!-- ====== CONSULTORIA PTE-I ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Consultoria PTE-I</span>
            <h2>O método que orienta prioridade e execução</h2>
            <p class="section__desc">O PTE-I organiza a evolução em quatro frentes: presença digital, tecnologia operacional, escala com automação e inteligência para tomada de decisão.</p>
        </div>
        <div class="grid grid--4">
            <?php foreach ($config['method']['steps'] as $i => $step): ?>
            <div class="card reveal reveal-delay-<?= ($i % 4) + 1 ?>">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-<?= e($step['icon']) ?>"/></svg>
                </div>
                <span class="section__eyebrow"><?= e($step['letter']) ?></span>
                <h3><?= e($step['title']) ?></h3>
                <p><?= e($step['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====== DIFERENCIAL ====== -->
<section class="section section--subtle">
    <div class="container">
        <div class="section__header reveal">
            <span class="section__eyebrow">Por que recorrente?</span>
            <h2>Porque estrutura digital exige ajuste contínuo</h2>
            <p class="section__desc">A recorrência garante revisão de prioridade, execução guiada e evolução consistente sem depender de projetos pontuais.</p>
        </div>
        <div class="grid-3">
            <div class="card reveal reveal-delay-1">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-refresh-cw"/></svg>
                </div>
                <h3>Melhoria Contínua</h3>
                <p>O projeto evolui em ciclos curtos, com entregas que acompanham a fase do negócio.</p>
            </div>
            <div class="card reveal reveal-delay-2">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-shield"/></svg>
                </div>
                <h3>Suporte Dedicado</h3>
                <p>Você tem acompanhamento técnico e consultivo para manter ritmo e reduzir retrabalho.</p>
            </div>
            <div class="card reveal reveal-delay-3">
                <div class="card__icon">
                    <svg viewBox="0 0 24 24"><use href="#icon-trending-up"/></svg>
                </div>
                <h3>Visão Estratégica</h3>
                <p>As decisões são orientadas por dados e pelo método PTE-I, não por urgências soltas.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<?php
$cta_title = 'Vamos definir o plano certo para sua fase?';
$cta_subtitle = 'No diagnóstico inicial, alinhamos escopo, frequência de acompanhamento e entregas do plano. Demandas fora do escopo recebem proposta separada.';
include __DIR__ . '/includes/cta-section.php';
?>

<?php include __DIR__ . '/includes/footer.php'; ?>
