<?php
// Inclui o arquivo de configuração com a conexão PDO
require_once 'config.php';

// Verifica se o ID do cliente foi enviado via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Prepara e executa a exclusão do cliente
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redireciona com mensagem de sucesso
        header("Location: cad_cliente.php?msg=Cliente+excluido+com+sucesso");
        exit;
    } else {
        // Redireciona com mensagem de erro
        header("Location: cad_cliente.php?msg=Erro+ao+excluir+cliente");
        exit;
    }
} else {
    // Redireciona se o ID não for válido
    header("Location: cad_cliente.php?msg=ID+invalido");
    exit;
}
?>