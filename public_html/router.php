<?php
/**
 * OctaBit — Router
 * Redireciona URLs limpas para os arquivos PHP correspondentes.
 */

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$routes = [
    ''          => 'home.php',
    'produtos'  => 'produtos.php',
    'servicos'  => 'servicos.php',
    'solucoes'  => 'solucoes.php',
    'planos'    => 'planos.php',
    'sobre'     => 'sobre.php',
    'contato'   => 'contato.php',
    'produtos/octaponto'  => 'produto-octaponto.php',
    'produtos/octavendas' => 'produto-octavendas.php',
    'produtos/octacrm'    => 'produto-octacrm.php',
];

if (array_key_exists($uri, $routes)) {
    require __DIR__ . '/' . $routes[$uri];
    exit;
}

// Fallback: se for arquivo estático existente, serve normalmente
$file = __DIR__ . '/' . $uri;
if (is_file($file)) {
    return false; // Let the web server handle it
}

// 404
http_response_code(404);
echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>404 | OctaBit</title>';
echo '<style>body{font-family:Inter,system-ui,sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;background:#f8fafc;color:#334155;text-align:center;}';
echo '.c{max-width:400px;}.c h1{font-size:72px;color:#2563eb;margin:0;}.c p{margin:16px 0;color:#64748b;}.c a{color:#2563eb;text-decoration:none;font-weight:600;}</style></head>';
echo '<body><div class="c"><h1>404</h1><p>Página não encontrada</p><a href="/">← Voltar para o início</a></div></body></html>';
