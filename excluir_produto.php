<?php
session_start();
require 'config.php';

if(empty($_SESSION['lg'])) {
	header("Location: login.php");
	exit;
} else {
	$id = $_SESSION['lg'];
	$ip = $_SERVER['REMOTE_ADDR'];

	$sql = "SELECT * FROM usuarios WHERE id = :id AND ip = :ip";
	$sql = $pdo->prepare($sql);
	$sql->bindValue(":id", $id);
	$sql->bindValue(":ip", $ip);
	$sql->execute();

	if($sql->rowCount() == 0) {
		header("Location: login.php");
		exit;
	}
}

// Verifica se o ID do produto foi enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepara a query para excluir o produto
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt) {
        header("Location: produtos.php");
        exit();
    } else {
        echo "Erro ao excluir o produto: " . $pdo->errorInfo()[2];
    }

    //$stmt->close();
} else {
    echo "ID do produto não informado.";
}
?>