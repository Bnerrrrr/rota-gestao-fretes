<?php
require_once '../includes/conexao.php';

try {
    // DELETE apaga o endereço com o id que veio na URL
    $comando = $pdo->prepare('DELETE FROM endereco WHERE id = ?');
    $comando->execute([$_GET['id']]);
    header('Location: /rota/pages/enderecos.php');
} catch (PDOException $erro) {
    // Se o endereço já está em um frete, o banco recusa e mostramos o aviso
    header('Location: /rota/pages/enderecos.php?erro=1');
}
exit;