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

// Consulta produtos com quantidade menor que 10
$sql = "SELECT * FROM baixo_estoque";
$result = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Controle de Estoque</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Curso 2025</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adicionar_produto.php">Adicionar Produto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produtos.php">Produtos</a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link" href="estoque.php">Abaixo do estoque</a>
                </ul>
            </div>
        </div>
    </nav>
<div class="container mt-5">
    <h2 class="mb-4">Produtos com Estoque Baixo</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->rowCount() > 0): ?>
            <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['quantidade']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">Nenhum produto com estoque baixo.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>