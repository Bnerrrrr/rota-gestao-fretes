<?php
require_once '../includes/conexao.php';

// Pega o que veio do formulário (o $_POST guarda esses dados)
$id        = $_POST['id'];
$nome      = trim($_POST['nome']);        // trim tira espaços sobrando
$descricao = trim($_POST['descricao']);

// Se peso ou valor vierem vazios, gravamos "nada" (null) no banco
$peso  = $_POST['peso']  !== '' ? $_POST['peso']  : null;
$valor = $_POST['valor'] !== '' ? $_POST['valor'] : null;

if ($id === '') {
    // Sem id: é produto NOVO, então INSERT (inserir)
    $comando = $pdo->prepare(
        'INSERT INTO produto (nome, descricao, peso, valor) VALUES (?, ?, ?, ?)'
    );
    $comando->execute([$nome, $descricao, $peso, $valor]);
} else {
    // Com id: é EDIÇÃO, então UPDATE (atualizar) só o produto desse id
    $comando = $pdo->prepare(
        'UPDATE produto SET nome = ?, descricao = ?, peso = ?, valor = ? WHERE id = ?'
    );
    $comando->execute([$nome, $descricao, $peso, $valor, $id]);
}

// Depois de gravar, volta para a lista de produtos
header('Location: /rota/pages/produtos.php');
exit;