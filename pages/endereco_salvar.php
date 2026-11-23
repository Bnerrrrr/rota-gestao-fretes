<?php
require_once '../includes/conexao.php';

// Pega o que veio do formulário (trim tira espaços sobrando)
$id      = $_POST['id'];
$apelido = trim($_POST['apelido']);
$rua     = trim($_POST['rua']);
$numero  = trim($_POST['numero']);
$bairro  = trim($_POST['bairro']);
$cidade  = trim($_POST['cidade']);
$estado  = strtoupper(trim($_POST['estado']));   // strtoupper deixa em MAIÚSCULAS (pr vira PR)
$cep     = trim($_POST['cep']);

if ($id === '') {
    // Sem id: endereço NOVO, então INSERT
    $comando = $pdo->prepare(
        'INSERT INTO endereco (apelido, rua, numero, bairro, cidade, estado, cep)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $comando->execute([$apelido, $rua, $numero, $bairro, $cidade, $estado, $cep]);
} else {
    // Com id: EDIÇÃO, então UPDATE só desse endereço
    $comando = $pdo->prepare(
        'UPDATE endereco
         SET apelido = ?, rua = ?, numero = ?, bairro = ?, cidade = ?, estado = ?, cep = ?
         WHERE id = ?'
    );
    $comando->execute([$apelido, $rua, $numero, $bairro, $cidade, $estado, $cep, $id]);
}

// Depois de gravar, volta para a lista
header('Location: /rota/pages/enderecos.php');
exit;