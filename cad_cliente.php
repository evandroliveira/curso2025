<?php
session_start();
require 'config.php';
require 'menu.php';

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
// Processa cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe e sanitiza os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $celular = trim($_POST['celular']);
    $nascimento = trim($_POST['nascimento']);
    $endereco = trim($_POST['endereco']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $cep = trim($_POST['cep']);
    $sexo = trim($_POST['sexo']);

    // Prepara e executa a inserção no banco de dados
    $sql = "INSERT INTO clientes (nome, email, celular, nascimento, endereco, cidade, estado, cep, sexo)
            VALUES (:nome, :email, :celular, :nascimento, :endereco, :cidade, :estado, :cep, :sexo)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':nascimento', $nascimento);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':sexo', $sexo);

    if ($stmt->execute()) {
        // Redireciona para evitar reenvio do formulário
        header("Location: cad_cliente.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Erro ao cadastrar cliente.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Clientes</h2>
        <!-- Botão para abrir o modal de cadastro -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNovoCliente">
            Novo Cliente
        </button>

        <!-- Tabela de clientes -->
        <table class="table table-bordered">
            <!-- Removido as colunas Sexo, Nascimento e Endereço -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>CEP</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Busca todos os clientes
                $stmt = $pdo->query("SELECT * FROM clientes");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['nome']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['celular']}</td>";
                    echo "<td>{$row['cidade']}</td>";
                    echo "<td>{$row['estado']}</td>";
                    echo "<td>{$row['cep']}</td>";
                    echo "<td>
                        <a href='editar_cliente.php?id={$row['id']}' class='btn btn-warning btn-sm'>Alterar</a>
                        <a href='excluir_cliente.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Tem certeza que deseja excluir?')\">Excluir</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
            
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
    $(document).ready(function(){
        $('input[name="cep"]').mask('00000-000');
    });
    $(document).ready(function(){
        $('input[name="celular"]').mask('(00) 00000-0000');
    });
    </script>
    <!-- Modal para cadastro de novo cliente -->
    <div class="modal fade" id="modalNovoCliente" tabindex="-1" aria-labelledby="modalNovoClienteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalNovoClienteLabel">Novo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <div class="mb-2">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                 <div class="mb-2">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Celular</label>
                    <input type="text" name="celular" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Nascimento</label>
                    <input type="date" name="nascimento" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Endereço</label>
                    <input type="text" name="endereco" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Cidade</label>
                    <input type="text" name="cidade" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Estado</label>
                    <input type="text" name="estado" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>CEP</label>
                    <input type="text" name="cep" class="form-control" required>
                </div>
               
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </div>
        </form>
      </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>