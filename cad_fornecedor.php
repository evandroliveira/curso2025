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

// Função para buscar todos os fornecedores
function getFornecedores($pdo) {
    $stmt = $pdo->query("SELECT * FROM fornecedores ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Processa exclusão
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $stmt = $pdo->prepare("DELETE FROM fornecedores WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: cad_fornecedor.php");
    exit;
}

// Processa cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novo_fornecedor'])) {
    $stmt = $pdo->prepare("INSERT INTO fornecedores (nome, cnpj, telefone, email, endereco, cidade, estado, cep, data_cadastro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nome'],
        $_POST['cnpj'],
        $_POST['telefone'],
        $_POST['email'],
        $_POST['endereco'],
        $_POST['cidade'],
        $_POST['estado'],
        $_POST['cep'],
        $_POST['data_cadastro']
    ]);
    header("Location: cad_fornecedor.php");
    exit;
}

$fornecedores = getFornecedores($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_fornecedor'])) {
    $stmt = $pdo->prepare("UPDATE fornecedores SET nome = ?, cnpj = ?, telefone = ?, email = ?, endereco = ?, cidade = ?, estado = ?, cep = ? WHERE id = ?");
    $stmt->execute([
        $_POST['nome'],
        $_POST['cnpj'],
        $_POST['telefone'],
        $_POST['email'],
        $_POST['endereco'],
        $_POST['cidade'],
        $_POST['estado'],
        $_POST['cep'],
        $_POST['id']
    ]);
    header("Location: cad_fornecedor.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Fornecedores</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .table-actions { width: 120px; }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Fornecedores</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Data Cadastro</th>
                <th class="table-actions">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fornecedores as $f): ?>
            <tr>
                <td><?= htmlspecialchars($f['nome']) ?></td>
                <td><?= htmlspecialchars($f['telefone']) ?></td>
                <td><?= htmlspecialchars($f['email']) ?></td>
                <td><?= htmlspecialchars($f['endereco']) ?></td>
                <td><?= htmlspecialchars($f['cidade']) ?></td>
                <td><?= htmlspecialchars($f['estado']) ?></td>
                <td><?= htmlspecialchars($f['data_cadastro']) ?></td>
                <td>
                    <!-- Botão para abrir modal de edição -->
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarFornecedor<?= $f['id'] ?>">
                        Editar
                    </button>

                    <!-- Modal de edição -->
                    <div class="modal fade" id="modalEditarFornecedor<?= $f['id'] ?>" tabindex="-1" aria-labelledby="modalEditarFornecedorLabel<?= $f['id'] ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <form method="post" class="modal-content">
                          <input type="hidden" name="editar_fornecedor" value="1">
                          <input type="hidden" name="id" value="<?= $f['id'] ?>">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarFornecedorLabel<?= $f['id'] ?>">Editar Fornecedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-2">
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control" required value="<?= htmlspecialchars($f['nome']) ?>">
                            </div>
                            <div class="mb-2">
                                <label>CNPJ</label>
                                <input type="text" name="cnpj" class="form-control" required value="<?= htmlspecialchars($f['cnpj']) ?>">
                            </div>
                            <div class="mb-2">
                                <label>Telefone</label>
                                <input type="text" name="telefone" class="form-control" required value="<?= htmlspecialchars($f['telefone']) ?>">
                            </div>
                            <div class="mb-2">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($f['email']) ?>">
                            </div>
                            <div class="mb-2">
                                <label>Endereço</label>
                                <input type="text" name="endereco" class="form-control" required value="<?= htmlspecialchars($f['endereco']) ?>">
                            </div>
                            <div class="mb-2">
                                <label>Cidade</label>
                                <input type="text" name="cidade" class="form-control" required value="<?= htmlspecialchars($f['cidade']) ?>">
                            </div>
                            <div class="mb-2">
                                <label>Estado</label>
                                <input type="text" name="estado" class="form-control" maxlength="2" required value="<?= htmlspecialchars($f['estado']) ?>">
                            </div>
                            <div class="mb-2">
                                <label>CEP</label>
                                <input type="text" name="cep" class="form-control" required value="<?= htmlspecialchars($f['cep']) ?>">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                          </div>
                        </form>
                      </div>
                    </div>
                    <a href="?excluir=<?= $f['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir este fornecedor?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Botão para abrir modal -->
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNovoFornecedor">
        Novo Fornecedor
    </button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
    $(document).ready(function(){
        $('input[name="cep"]').mask('00000-000');
    });
    $(document).ready(function(){
        $('input[name="telefone"]').mask('(00) 00000-0000');
    });
    $(document).ready(function(){
        $('input[name="cnpj"]').mask('00.000.000/0000-00');
    });
    </script>
    
    <div class="modal fade" id="modalNovoFornecedor" tabindex="-1" aria-labelledby="modalNovoFornecedorLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalNovoFornecedorLabel">Cadastrar Fornecedor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="novo_fornecedor" value="1">
            <div class="mb-2">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>CNPJ</label>
                <input type="text" name="cnpj" class="form-control" required id="cnpj">
            </div>
            <div class="mb-2">
                <label>Telefone</label>
                <input type="text" name="telefone" class="form-control" required id="telefone">
            </div>
            <div class="mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
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
                <input type="text" name="estado" class="form-control" maxlength="2" required>
            </div>
            <div class="mb-2">
                <label>CEP</label>
                <input type="text" name="cep" class="form-control" required id="cep">
            </div>
            <div class="mb-2">
                <label>Data Cadastro</label>
                <input type="date" name="data_cadastro" class="form-control" required value="<?= date('Y-m-d') ?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>