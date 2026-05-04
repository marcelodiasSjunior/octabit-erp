<?php
/**
 * OctaBit — Root Entry Point
 * Gerencia roteamento entre Landing Page e ERP (Multi-tenancy por subdomínio)
 */

$host = $_SERVER['HTTP_HOST'];
$uri  = $_SERVER['REQUEST_URI'];
$parts = explode('.', $host);

// Detecta se estamos em um subdomínio (ex: demo.octabit.tech)
// E não é o domínio principal www
$isSubdomain = count($parts) >= 3 && $parts[0] !== 'www';

if ($isSubdomain) {
    /**
     * Se estiver em um subdomínio, redireciona para o ERP.
     * Usamos require absoluto para evitar erros de inclusão.
     */
    require __DIR__ . '/erp/index.php';
} else {
    /**
     * Se for o domínio principal, verifica se o usuário está tentando 
     * acessar a pasta /erp/ explicitamente.
     */
    if (strpos($uri, '/erp/') === 0 || $uri === '/erp') {
        require __DIR__ . '/erp/index.php';
    } else {
        // Caso contrário, carrega a Landing Page (Router)
        require __DIR__ . '/router.php';
    }
}
