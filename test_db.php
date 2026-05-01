<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=u688664394_octaerp', 'u688664394_octaerp', 'Ceci03Ali@#b');
    echo 'Conectado com sucesso!';
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
