<?php
require_once '../includes/conexao.php';

// Apaga o frete. Os produtos ligados a ele (tabela frete_produto)
// são apagados automaticamente por causa do ON DELETE CASCADE que colocamos no banco.
$comando = $pdo->prepare('DELETE FROM frete WHERE id = ?');
$comando->execute([$_GET['id']]);

header('Location: /rota/pages/fretes.php');
exit;