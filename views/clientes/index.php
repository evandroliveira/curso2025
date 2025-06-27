<?php
require_once __DIR__ . '/../../controllers/ClienteController.php';

// Verifica se a classe existe antes de instanciar
if (class_exists('ClienteController')) {
    $clienteController = new ClienteController();
} else {
    die('Erro: Classe ClienteController não encontrada. Verifique o arquivo ClienteController.php.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clienteController->store($_POST);
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS local -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body>
    
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
    <!-- Bootstrap JS local -->
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>