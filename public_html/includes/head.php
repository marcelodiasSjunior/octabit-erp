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

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon-96x96.png">
    <link rel="icon" type="image/svg+xml" href="/img/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/app.css">

    <meta name="apps-script-url" content="<?= e($config['integrations']['google_apps_script']) ?>">
</head>
<body>
<?php include __DIR__ . '/whatsapp-float.php'; ?>
<?php include __DIR__ . '/header.php'; ?>
<main>
