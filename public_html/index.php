<?php
/**
 * OctaBit — Entry Point
 * Gerencia roteamento entre Landing Page e ERP (Multi-tenancy por subdomínio)
 */

$host = $_SERVER['HTTP_HOST'];
$parts = explode('.', $host);

// Se tiver subdomínio (ex: demo.octabit.tech ou erp.octabit.tech)
// E não for o domínio principal www ou octabit.tech pura
if (count($parts) >= 3 && $parts[0] !== 'www') {
    // Redireciona internamente para o ERP
    require __DIR__ . '/erp/index.php';
} else {
    // Se for o domínio principal, carrega a Landing Page
    require __DIR__ . '/router.php';
}
