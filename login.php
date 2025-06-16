<?php
// Inclui o arquivo de configuração
require_once 'config.php';

// Inicializa variáveis
$email = $senha = '';
$erro = '';

// Processa o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = trim($_POST['email'] ?? '');
	$senha = $_POST['senha'] ?? '';
	
	if (!empty($senha) && !empty($email)) {
		
			// Prepara a consulta SQL
			$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email AND senha = :senha');
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':senha', $senha);
			$stmt->execute();
			
			// Verifica se o usuário foi encontrado
			if ($stmt->rowCount() > 0) {
				//session_start();
				//$_SESSION['usuario'] = $stmt->fetch(PDO::FETCH_ASSOC);
			
				header('Location: index.php'); // Redireciona para a página do dashboard
				exit;
			} else {
				$erro = 'E-mail ou senha inválidos.';
			}
		
	}
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-4">
				<div class="card shadow">
					<div class="card-body">
						<h4 class="card-title mb-4 text-center">Login</h4>
						<?php if ($erro): ?>
							<div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
						<?php endif; ?>
						<form method="post" autocomplete="off">
							<div class="mb-3">
								<label for="email" class="form-label">E-mail</label>
								<input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">
							</div>
							<div class="mb-3">
								<label for="senha" class="form-label">Senha</label>
								<input type="password" class="form-control" id="senha" name="senha" required>
							</div>
							<button type="submit" class="btn btn-primary w-100">Entrar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>