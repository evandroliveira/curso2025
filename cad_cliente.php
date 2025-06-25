<?php
require_once 'config.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome      = $_POST['nome'] ?? '';
    $email     = $_POST['email'] ?? '';
    $celular   = $_POST['celular'] ?? '';
    $nascimento= $_POST['nascimento'] ?? '';
    $endereco  = $_POST['endereco'] ?? '';
    $cidade    = $_POST['cidade'] ?? '';
    $estado    = $_POST['estado'] ?? '';
    $cep       = $_POST['cep'] ?? '';
    $sexo      = $_POST['sexo'] ?? '';

    // Validação simples (pode ser expandida)
    if ($nome && $email && $celular && $nascimento && $endereco && $cidade && $estado && $cep && $sexo) {
        $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, celular, nascimento, endereco, cidade, estado, cep, sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nome, $email, $celular, $nascimento, $endereco, $cidade, $estado, $cep, $sexo])) {
            $success = true;
        } else {
            $error = 'Erro ao cadastrar cliente.';
        }
    } else {
        $error = 'Preencha todos os campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cliente</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Cadastro de Cliente</h2>
    <?php if ($success): ?>
        <div class="alert alert-success">Cliente cadastrado com sucesso!</div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="col-md-4">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular" name="celular" required>
        </div>
        <div class="col-md-4">
            <label for="nascimento" class="form-label">Nascimento</label>
            <input type="date" class="form-control" id="nascimento" name="nascimento" required>
        </div>
        <div class="col-md-4">
            <label for="sexo" class="form-label">Sexo</label>
            <select class="form-select" id="sexo" name="sexo" required>
                <option value="">Selecione</option>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
                <option value="O">Outro</option>
            </select>
        </div>
        <div class="col-12">
            <label for="endereco" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" required>
        </div>
        <div class="col-md-6">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" required>
        </div>
        <div class="col-md-4">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" maxlength="2" required>
        </div>
        <div class="col-md-2">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control" id="cep" name="cep" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>