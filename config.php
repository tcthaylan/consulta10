<?php
// Conexão com Banco de Dados
global $conn;
try {
    $conn = new PDO('mysql:dbname=consulta10;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: ".$e->getMessage();
    exit;
}

// Autoload
spl_autoload_register(function($className) {
    $dir = 'classes';
    $filename = $dir.DIRECTORY_SEPARATOR.$className.'.php';

    if (file_exists($filename)) {
        require_once($filename);
    }
});