<?php
global $conn;
try {
    $conn = new PDO('mysql:dbname=consulta10;host=localhost', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: ".$e->getMessage();
    exit;
}