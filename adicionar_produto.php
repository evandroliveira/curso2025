<?php
// Chama o arquivo de configuração
require_once 'config.php';
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit();
}

// Inicializa variáveis
$nome = $quantidade = $preco = "";
$mensagem = "";

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $quantidade = intval($_POST["quantidade"]);
    $preco = floatval($_POST["preco"]);

    // Validação simples
    if ($nome && $quantidade > 0 && $preco > 0) {
        // Prepara e executa a inserção no banco de dados
        $stmt = $conn->prepare("INSERT INTO produtos (nome, quantidade, preco) VALUES (?, ?, ?)");
        $stmt->bind_param("sid", $nome, $quantidade, $preco);

        if ($stmt->execute()) {
            header("Location: produtos.php");
            exit();
        } else {
            $mensagem = "Erro ao inserir produto: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos corretamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Adicionar Produto</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Curso2025</a>
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
                </ul>
        </div>
    </nav>
    <div class="container">
            <h1 class="mb-4">Adicionar Produto</h1>
            <?php if ($mensagem) echo "<div class='alert alert-info'>$mensagem</div>"; ?>
            <form method="post" action="" class="needs-validation" novalidate>
                    <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                            <div class="invalid-feedback">Informe o nome do produto.</div>
                    </div>
                    <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade:</label>
                            <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" required>
                            <div class="invalid-feedback">Informe uma quantidade válida.</div>
                    </div>
                    <div class="mb-3">
                            <label for="preco" class="form-label">Preço:</label>
                            <input type="number" class="form-control" id="preco" name="preco" step="0.01" min="0.01" required>
                            <div class="invalid-feedback">Informe um preço válido.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
            </form>
    </div>
    <script>
            // Bootstrap 5 form validation
            (() => {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()
    </script>
    
</body>
</html>