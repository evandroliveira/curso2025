<?php
// Chama o arquivo de configuração
require_once 'config.php';

// Verifica se o ID do produto foi passado
if (!isset($_GET['id'])) {
    echo "Produto não especificado.";
    exit;
}

$id = intval($_GET['id']);

// Busca os dados do produto
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produto = $result->fetch_assoc();

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

    $stmt = $conn->prepare("UPDATE produtos SET nome=?, preco=?, quantidade=?, total=? WHERE id=?");
    $stmt->bind_param("sdddi", $nome, $preco, $quantidade, $total, $id);

    if ($stmt->execute()) {
        echo "Produto atualizado com sucesso!";
        // Atualiza os dados exibidos
        $produto['nome'] = $nome;
        $produto['preco'] = $preco;
        $produto['quantidade'] = $quantidade;
    } else {
        echo "Erro ao atualizar o produto.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>
    <form method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required><br><br>
        <label>Preço:</label><br>
        <input type="number" step="0.01" name="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" required><br><br>
        <label>Quantidade:</label><br>
        <input type="number" name="quantidade" value="<?php echo htmlspecialchars($produto['quantidade']); ?>" required><br><br>
        <label>Total:</label><br>
        <input type="number" step="0.01" name="total" value="<?php echo htmlspecialchars($produto['total']); ?>" readonly><br><br>
        <button type="submit">Salvar</button>
    </form>
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