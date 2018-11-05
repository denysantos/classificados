<?php
session_start();
global $pdo;
try {
    $pdo = new PDO("mysql:dbname=classificados_mvc;host:localhost","denny","henrique");
} catch (PDOException $e) {
    echo "Falhou: ".$e->getMessage();
    exit;
}
?>