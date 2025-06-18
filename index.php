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

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso 2025</title>
</head>
<body style="background-image: url('imagens/fundo.jpg'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Curso 2025</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="adicionar_produto.php">Adicionar Produto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produtos.php">Produtos</a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link" href="estoque.php">Abaixo do estoque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Sair</a>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container bg-light p-4 rounded">
        <h2 class="mb-4">Resumo dos Produtos</h2>
        <?php
        

        // Consulta para obter quantidade e valor total dos produtos
        $sql = "SELECT COUNT(*) AS quantidade, SUM(total) AS total FROM produtos";
        $result = $pdo->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $quantidade = $row['quantidade'] ?? 0;
        $total_valor = $row['total'] ?? 0;

        // Consulta para obter os valores individuais dos produtos (para gráfico de barras)
        $sql2 = "SELECT nome, preco FROM produtos";
        $result2 = $pdo->query($sql2);
        $nomes = [];
        $valores = [];
        while ($r = $result2->fetch(PDO::FETCH_ASSOC)) {
            $nomes[] = $r['nome'];
            $valores[] = $r['preco'];
        }
        //$conn->close();
        ?>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="alert alert-info">
                    <strong>Quantidade de Produtos:</strong> <?php echo $quantidade; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-success">
                    <strong>Valor Total dos Produtos:</strong> R$ <?php echo number_format($total_valor, 2, ',', '.'); ?>
                </div>
            </div>
        </div>

        <canvas id="graficoProdutos" height="100"></canvas>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoProdutos').getContext('2d');
        const nomes = <?php echo json_encode($nomes); ?>;
        const valores = <?php echo json_encode($valores); ?>;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: nomes,
                datasets: [{
                    label: 'Valor (R$)',
                    data: valores,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Valores dos Produtos'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>