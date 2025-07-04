<?php
require_once 'config.php';
$register_success = '';
 $nome = '';
$nome_err = '';
// Inicializa variáveis para e-mail e senha
 $email = $senha = '';
$email_err = $senha_err = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe e valida os dados
    $nome = trim($_POST["nome"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $senha = trim($_POST["senha"] ?? '');

    if (empty($nome)) {
        $nome_err = "Informe seu nome.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Informe um e-mail válido.";
    }
    if (empty($senha) || strlen($senha) < 6) {
        $senha_err = "A senha deve ter pelo menos 6 caracteres.";
    }

    // Verifica se o e-mail já está cadastrado
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $email_err = "Este e-mail já está cadastrado.";
    }

    if (!$name_err && !$email_err && !$senha_err) {

        // Chama a procedure add_usuarios(email, senha)
        $stmt = $pdo->prepare("CALL add_usuario(?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        // Verifica se a inserção foi bem-sucedida
         $register_success = '';

        if ($stmt) {
            $register_success = "Usuário cadastrado com sucesso!";
            $name = $email = $senha = '';
            header("Location: index.php"); // Redireciona para a página de login após o cadastro
            
        } else {
            $register_success = "Erro ao cadastrar: " . $pdo->errorInfo()[2];
        }
        $stmt->close();
        //$conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>Cadastro de Usuário</h4>
                </div>
                <div class="card-body">
                    <?php if ($register_success): ?>
                        <div class="alert alert-info"><?= $register_success ?></div>
                    <?php endif; ?>
                    <form method="post" autocomplete="off">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control <?= $nome_err ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($nome) ?>">
                            <div class="invalid-feedback"><?= $nome_err ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control <?= $email_err ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($email) ?>">
                            <div class="invalid-feedback"><?= $email_err ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="password" name="senha" id="senha" class="form-control <?= $senha_err ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($senha) ?>">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('senha')">Mostrar</button>
                                <div class="invalid-feedback"><?= $senha_err ?></div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>
</body>
</html>