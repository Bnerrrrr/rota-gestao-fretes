<?php
require_once '../includes/conexao.php';

try {
    // DELETE apaga o transportador com o id que veio na URL
    $comando = $pdo->prepare('DELETE FROM transportador WHERE id = ?');
    $comando->execute([$_GET['id']]);
    header('Location: /rota/pages/transportadores.php');
} catch (PDOException $erro) {
    // Se o transportador já está em um frete, o banco recusa e mostramos o aviso
    header('Location: /rota/pages/transportadores.php?erro=1');
}
exit;