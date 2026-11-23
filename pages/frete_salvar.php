<?php
require_once '../includes/conexao.php';

// Pega o que veio do formulário
$data             = $_POST['data'] ?? '';
$id_transportador = $_POST['id_transportador'] ?? '';
$id_origem        = $_POST['id_origem'] ?? '';
$id_destino       = $_POST['id_destino'] ?? '';
$produtos         = $_POST['produtos'] ?? [];   // lista de ids (vazia se nada foi marcado)

// Validação simples: tudo preenchido, origem diferente do destino e ao menos 1 produto
if ($data === '' || $id_transportador === '' || $id_origem === '' || $id_destino === ''
    || $id_origem === $id_destino || count($produtos) === 0) {
    header('Location: /rota/pages/frete_form.php?erro=1');
    exit;
}

// Transação: ou grava o frete INTEIRO (frete + produtos) ou não grava nada.
// Evita ficar um frete "pela metade" no banco se algo der erro.
$pdo->beginTransaction();

try {
    // 1) Grava o frete
    $comando = $pdo->prepare(
        'INSERT INTO frete (data, id_transportador, id_origem, id_destino) VALUES (?, ?, ?, ?)'
    );
    $comando->execute([$data, $id_transportador, $id_origem, $id_destino]);

    // 2) Pega o id que o MySQL acabou de criar para esse frete
    $id_frete = $pdo->lastInsertId();

    // 3) Para cada produto marcado, grava uma linha em frete_produto
    $comando = $pdo->prepare('INSERT INTO frete_produto (id_frete, id_produto) VALUES (?, ?)');
    foreach ($produtos as $id_produto) {
        $comando->execute([$id_frete, $id_produto]);
    }

    $pdo->commit();   // confirma tudo
    header('Location: /rota/pages/fretes.php');
} catch (PDOException $erro) {
    $pdo->rollBack();   // desfaz tudo se algo deu errado
    header('Location: /rota/pages/frete_form.php?erro=1');
}
exit;