<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController
{
    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $celular = $_POST['celular'] ?? '';
            $nascimento = $_POST['nascimento'] ?? '';
            $endereco = $_POST['endereco'] ?? '';
            $cidade = $_POST['cidade'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $cep = $_POST['cep'] ?? '';
            $sexo = $_POST['sexo'] ?? '';

            $cliente = new Cliente();
            $cliente->adicionar($nome, $email, $celular, $nascimento, $cidade, $estado, $cep, $sexo);

            if ($cliente->salvar()) {
                header('Location: /clientes?sucesso=1');
                exit;
            } else {
                $erro = "Erro ao cadastrar cliente.";
            }
        }
        include __DIR__ . '/../views/cad_cliente.php';
    }
}
?>