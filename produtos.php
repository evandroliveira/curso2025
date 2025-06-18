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

// Consulta para buscar todos os produtos
$sql = "SELECT * FROM produtos";
$result = $pdo->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
    <h1>Produtos</h1>
    
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Preço</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Total</th>
                <th scoope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os botões serão adicionados nas linhas dos produtos abaixo -->
        <?php if ($result && $result->rowCount() > 0): ?>
            <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($row['quantidade']); ?></td>
                    <td>R$ <?php echo number_format($row['preco'] * $row['quantidade'], 2, ',', '.'); ?></td>
                    <td>
                        <a href="editar_produto.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-sm btn-primary">Alterar</a>
                        <a href="excluir_produto.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhum produto encontrado.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</body>
</html>
<?php
//$conn->close();
?>