<?php
require_once 'config.php';
require 'menu.html';

// Consulta todos os clientes
$stmt = $pdo->query("SELECT * FROM clientes ORDER BY id DESC");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Clientes</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($clientes): ?>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['id']) ?></td>
                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                    <td>
                        <a href="alterar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">Alterar</a>
                        <a href="excluir_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhum cliente encontrado.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>