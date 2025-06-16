<?php
// conexao com o banco de dados
$server = 'localhost';
$database = 'avaliacao';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}

?>