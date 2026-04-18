<?php
/**
 * OctaBit — Head + abertura do body
 * Usado no topo de cada página.
 * Espera: $page_title, $page_description, $current_page
 */
if (!isset($config)) { require_once __DIR__ . '/config.php'; }

$page_title       = $page_title       ?? 'OctaBit | Estruturação Digital para Pequenas Empresas';
$page_description = $page_description ?? 'Estruturação digital e arquitetura operacional para pequenas empresas. Sites, automação, dashboards e acompanhamento estratégico.';
$current_page     = $current_page     ?? 'home';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?></title>
    <meta name="description" content="<?= e($page_description) ?>">
    <meta name="author" content="OctaBit">

    <meta property="og:title" content="<?= e($page_title) ?>">
    <meta property="og:description" content="<?= e($page_description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($config['brand']['url']) ?>">
    <meta property="og:image" content="<?= e($config['brand']['url']) ?>/img/og-image.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="<?= e($config['brand']['name']) ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($page_title) ?>">
    <meta name="twitter:description" content="<?= e($page_description) ?>">
    <meta name="twitter:image" content="<?= e($config['brand']['url']) ?>/img/og-image.jpg">

    <link rel="canonical" href="<?= e($config['brand']['url'] . ($_SERVER['REQUEST_URI'] === '/' ? '' : rtrim($_SERVER['REQUEST_URI'], '/'))) ?>">

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon-96x96.png">
    <link rel="icon" type="image/svg+xml" href="/img/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    <link rel="preload" href="/fonts/inter-latin.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/space-grotesk-latin.woff2" as="font" type="font/woff2" crossorigin>

    <style>
    @font-face{font-family:'Inter';font-style:normal;font-weight:400 600;font-display:swap;src:url('/fonts/inter-latin-ext.woff2') format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C0,U+2113,U+2C60-2C7F,U+A720-A7FF}
    @font-face{font-family:'Inter';font-style:normal;font-weight:400 600;font-display:swap;src:url('/fonts/inter-latin.woff2') format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
    @font-face{font-family:'Space Grotesk';font-style:normal;font-weight:500 700;font-display:swap;src:url('/fonts/space-grotesk-latin-ext.woff2') format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C0,U+2113,U+2C60-2C7F,U+A720-A7FF}
    @font-face{font-family:'Space Grotesk';font-style:normal;font-weight:500 700;font-display:swap;src:url('/fonts/space-grotesk-latin.woff2') format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
    </style>

    <link rel="stylesheet" href="/css/app.css?v=<?= filemtime(__DIR__ . '/../css/app.css') ?>">

    <meta name="apps-script-url" content="<?= e($config['integrations']['google_apps_script']) ?>">

    <?php if (!empty($config['integrations']['ga4_id'])): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($config['integrations']['ga4_id']) ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($config['integrations']['ga4_id']) ?>');</script>
    <?php endif; ?>

    <?php if (!empty($config['integrations']['meta_pixel_id'])): ?>
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','<?= e($config['integrations']['meta_pixel_id']) ?>');fbq('track','PageView');</script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?= e($config['integrations']['meta_pixel_id']) ?>&ev=PageView&noscript=1"/></noscript>
    <?php endif; ?>
</head>
<body>
<?php include __DIR__ . '/whatsapp-float.php'; ?>
<?php include __DIR__ . '/header.php'; ?>
<main>

<?php if ($current_page === 'home'): ?>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ProfessionalService',
    'name' => $config['brand']['name'],
    'url' => $config['brand']['url'],
    'logo' => $config['brand']['url'] . $config['brand']['logo'],
    'description' => $page_description,
    'telephone' => '+55' . $config['contact']['whatsapp_number'],
    'email' => $config['contact']['email'],
    'areaServed' => 'BR',
    'serviceType' => ['Estruturação Digital', 'Desenvolvimento Web', 'Automação de Processos', 'Business Intelligence'],
    'priceRange' => 'R$ 497 - R$ 1.997/mês',
    'sameAs' => [$config['brand']['instagram']],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
<?php endif; ?>
