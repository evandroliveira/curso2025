<?php
require_once 'config.php';

$name = $email = $password = '';
$name_err = $email_err = $password_err = $register_success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nome
    $name = trim($_POST["nome"]);
    if (empty($name)) {
        $name_err = "Por favor, insira seu nome.";
    }

    // Email
    $email = trim($_POST["email"]);
    if (empty($email)) {
        $email_err = "Por favor, insira seu email.";
    } else {
        // Verifica se o email já existe
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $email_err = "Este email já está cadastrado.";
            }
            $stmt->close();
        } else {
            $email_err = "Erro ao verificar o email. Tente novamente.";
        }
    }

    // Senha
    $password = $_POST["senha"];
    if (empty($password)) {
        $password_err = "Por favor, insira uma senha.";
    } elseif (strlen($password) < 6) {
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    }

    // Se não houver erros, insere no banco
    if (empty($name_err) && empty($email_err) && empty($password_err) ) {
        $sql = "INSERT INTO usuarios (nome, email, senha, confirma_senha) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssss", $name, $email, $hash);
            if ($stmt->execute()) {
                $register_success = "Cadastro realizado com sucesso!";
                header("Location: index.php"); // Redireciona para a página de login após o cadastro
            } else {
                $register_success = "Erro ao cadastrar. Tente novamente.";
            }
            $stmt->close();
        }
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
                            <label for="password" class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control <?= $password_err ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($password) ?>">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">Mostrar</button>
                                <div class="invalid-feedback"><?= $password_err ?></div>
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