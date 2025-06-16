<?php
// Chama o arquivo de configuração
require_once 'config.php';
/*
session_start();
// Inicia a sessão
// Verifica se o usuário está logado   
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit();
}*/

// Verifica se o ID do produto foi passado
if (!isset($_GET['id'])) {
    echo "Produto não especificado.";
    exit;
}

$id = intval($_GET['id']);

// Busca os dados do produto
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}

// Atualiza o produto se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $preco = floatval($_POST['preco']);
    $quantidade = intval($_POST['quantidade']);
    $total = $preco * $quantidade;

    $stmt = $pdo->prepare("UPDATE produtos SET nome=?, preco=?, quantidade=?, total=? WHERE id=?");
    $stmt->execute([$nome, $preco, $quantidade, $total, $id]);

    if ($stmt) {
        echo "Produto atualizado com sucesso!";
        // Atualiza os dados exibidos
        $produto['nome'] = $nome;
        $produto['preco'] = $preco;
        $produto['quantidade'] = $quantidade;
        header("Location: produtos.php");
        exit;
    } else {
        echo "Erro ao atualizar o produto.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link href="/curso2025/css/bootstrap.min.css" rel="stylesheet">
    <script src="/curso2025/js/bootstrap.bundle.min.js"></script>
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
                </ul>
            </div>
        </div>
    </nav>
    <h1>Editar Produto</h1>
    <div class="container mt-4">
        <form method="post" class="card p-4 shadow-sm" style="max-width: 500px; margin: auto;">
            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Preço:</label>
                <input type="number" step="0.01" name="preco" class="form-control" value="<?php echo htmlspecialchars($produto['preco']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantidade:</label>
                <input type="number" name="quantidade" class="form-control" value="<?php echo htmlspecialchars($produto['quantidade']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Total:</label>
                <input type="number" step="0.01" name="total" class="form-control" value="<?php echo htmlspecialchars($produto['total']); ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary w-100">Salvar</button>
        </form>
    </div>
    
    <script>
        // Atualiza o campo total automaticamente
        const preco = document.querySelector('input[name="preco"]');
        const quantidade = document.querySelector('input[name="quantidade"]');
        const total = document.querySelector('input[name="total"]');
        function atualizarTotal() {
            total.value = (parseFloat(preco.value) * parseInt(quantidade.value || 0)).toFixed(2);
        }
        preco.addEventListener('input', atualizarTotal);
        quantidade.addEventListener('input', atualizarTotal);
    </script>
</body>
</html>