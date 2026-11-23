<?php
require_once '../includes/conexao.php';

// Pega o que veio do formulário (trim tira espaços sobrando)
$id       = $_POST['id'];
$nome     = trim($_POST['nome']);
$cpf_cnpj = trim($_POST['cpf_cnpj']);
$telefone = trim($_POST['telefone']);
$placa    = strtoupper(trim($_POST['placa']));   // placa sempre em MAIÚSCULAS

if ($id === '') {
    // Sem id: transportador NOVO, então INSERT
    $comando = $pdo->prepare(
        'INSERT INTO transportador (nome, cpf_cnpj, telefone, placa) VALUES (?, ?, ?, ?)'
    );
    $comando->execute([$nome, $cpf_cnpj, $telefone, $placa]);
} else {
    // Com id: EDIÇÃO, então UPDATE só desse transportador
    $comando = $pdo->prepare(
        'UPDATE transportador SET nome = ?, cpf_cnpj = ?, telefone = ?, placa = ? WHERE id = ?'
    );
    $comando->execute([$nome, $cpf_cnpj, $telefone, $placa, $id]);
}

// Depois de gravar, volta para a lista
header('Location: /rota/pages/transportadores.php');
exit;