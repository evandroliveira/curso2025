<?php
session_start();
require 'config.php';
require 'menu.html';

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
<body >
    

    <div class="container bg-light p-4 rounded">
        <h2 class="mb-4">Resumo dos Produtos</h2>
        <?php
        
        echo '<div class="row mb-4">';
        echo '  <div class="col-md-6">';
        echo '    <h4>Resumo de Fornecedores</h4>';
        $sql_fornecedores = "SELECT COUNT(*) AS total_fornecedores FROM fornecedores";
        $result_fornecedores = $pdo->query($sql_fornecedores);
        $row_fornecedores = $result_fornecedores->fetch(PDO::FETCH_ASSOC);
        $total_fornecedores = $row_fornecedores['total_fornecedores'] ?? 0;
        echo '    <div class="alert alert-warning">';
        echo '      <strong>Total de Fornecedores:</strong> ' . $total_fornecedores;
        echo '    </div>';

        
        echo '</ul>';
        echo '  </div>';

        echo '  <div class="col-md-6">';
        echo '    <h4>Resumo de Clientes</h4>';
        $sql_clientes = "SELECT COUNT(*) AS total_clientes FROM clientes";
        $result_clientes = $pdo->query($sql_clientes);
        $row_clientes = $result_clientes->fetch(PDO::FETCH_ASSOC);
        $total_clientes = $row_clientes['total_clientes'] ?? 0;
        echo '    <div class="alert alert-primary">';
        echo '      <strong>Total de Clientes:</strong> ' . $total_clientes;
        echo '    </div>';

        
        echo '</ul>';
        echo '  </div>';
        echo '</div>';
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
                    backgroundColor: 'rgba(229, 54, 6, 0.6)',
                    borderColor: 'rgb(83, 4, 4)',
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