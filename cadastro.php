<?php
require_once 'config.php';
$register_success = '';
$name = $email = $senha = '';
$name_err = $email_err = $senha_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe e valida os dados
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $senha = trim($_POST["senha"] ?? '');

    if (empty($name)) {
        $name_err = "Informe o nome.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Informe um e-mail válido.";
    }
    if (empty($senha) || strlen($senha) < 6) {
        $senha_err = "A senha deve ter pelo menos 6 caracteres.";
    }

    if (!$name_err && !$email_err && !$senha_err) {

        // Chama a procedure inserir_usuario(nome, email, senha)
        $stmt = $conn->prepare("CALL inserir_usuario(?, ?, ?)");
        $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $name, $email, $hashed_senha);

        if ($stmt->execute()) {
            $register_success = "Usuário cadastrado com sucesso!";
            $name = $email = $senha = '';
            header("Location: login.php"); // Redireciona para a página de login após o cadastro
        } else {
            $register_success = "Erro ao cadastrar: " . $conn->error;
        }
        $stmt->close();
        $conn->close();
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
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control <?= $name_err ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($name) ?>">
                            <div class="invalid-feedback"><?= $name_err ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control <?= $email_err ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($email) ?>">
                            <div class="invalid-feedback"><?= $email_err ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="senha" name="senha" id="senha" class="form-control <?= $senha_err ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($senha) ?>">
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