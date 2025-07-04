
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Bootstrap</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
                    <li class="nav-item"> 
                        <a class="nav-link" href="cad_cliente.php">Clientes</a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link" href="cad_fornecedor.php">Fornecedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Sair</a>
                </ul>

            <span class="navbar-text ms-auto text-white">
               <h3>Olá  <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h3>
            </span>
            </div>
        </div>
    </nav>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>