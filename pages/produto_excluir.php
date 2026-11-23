<?php
require_once '../includes/conexao.php';

try {
    // DELETE apaga o produto com o id que veio na URL
    $comando = $pdo->prepare('DELETE FROM produto WHERE id = ?');
    $comando->execute([$_GET['id']]);
    header('Location: /rota/pages/produtos.php');
} catch (PDOException $erro) {
    // Se o produto já está em um frete, o banco recusa.
    // Voltamos para a lista com ?erro=1 para mostrar o aviso.
    header('Location: /rota/pages/produtos.php?erro=1');
}
exit;