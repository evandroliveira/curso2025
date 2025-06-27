<?php

// Puxa o arquivo de configuração
class Cliente {
    private $pdo;

    public function __construct() {
        require_once '../config.php';
        $this->pdo = $pdo;
    }

    public function adicionar($nome, $email, $celular, $nascimento, $cidade, $estado, $cep, $sexo) {
        $sql = "INSERT INTO clientes (nome, email, celular, nascimento, cidade, estado, cep, sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $celular, $nascimento, $cidade, $estado, $cep, $sexo]);
    }
}
