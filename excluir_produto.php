<?php
// Inclui o arquivo de configuração com a conexão ao banco de dados
require_once 'config.php';
// Inicia a sessão
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do produto foi enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepara a query para excluir o produto
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: produtos.php");
        exit();
    } else {
        echo "Erro ao excluir o produto: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID do produto não informado.";
}
?>