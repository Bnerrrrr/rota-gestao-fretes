<?php
// Dados para entrar no MySQL do XAMPP.
// No XAMPP o usuário padrão é "root" e a senha é vazia.
$servidor = 'localhost';
$banco    = 'rota';
$usuario  = 'root';
$senha    = '';

try {
    // PDO é a ferramenta do PHP para conversar com o banco de dados.
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8mb4", $usuario, $senha);

    // Se algum comando der erro, o PHP mostra uma mensagem em vez de falhar em silêncio.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    // Se não conseguir conectar, para tudo e mostra o motivo.
    die('Erro ao conectar no banco: ' . $erro->getMessage());
}