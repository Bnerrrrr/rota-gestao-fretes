<?php
require_once '../includes/conexao.php';

// Pega a data escolhida na tela de relatórios (vem pela URL)
$data = $_GET['data'] ?? '';

// Se não veio data, volta para a tela de relatórios
if ($data === '') {
    header('Location: /rota/pages/relatorios.php');
    exit;
}

// Busca os fretes SÓ da data escolhida (WHERE f.data = ?).
// SUM soma o peso e o valor de todos os produtos do frete.
$sql = 'SELECT f.id, f.data,
               t.nome AS transportador, t.placa,
               o.apelido AS origem,
               d.apelido AS destino,
               GROUP_CONCAT(p.nome SEPARATOR ", ") AS produtos,
               SUM(p.peso)  AS peso_total,
               SUM(p.valor) AS valor_total
        FROM frete f
        JOIN transportador t ON t.id = f.id_transportador
        JOIN endereco o ON o.id = f.id_origem
        JOIN endereco d ON d.id = f.id_destino
        LEFT JOIN frete_produto fp ON fp.id_frete = f.id
        LEFT JOIN produto p ON p.id = fp.id_produto
        WHERE f.data = ?
        GROUP BY f.id, f.data, t.nome, t.placa, o.apelido, d.apelido
        ORDER BY f.id';
$consulta = $pdo->prepare($sql);
$consulta->execute([$data]);
$fretes = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Se não achou nenhum frete, volta para a tela avisando
if (count($fretes) === 0) {
    header('Location: /rota/pages/relatorios.php?vazio=1');
    exit;
}

// Estes dois cabeçalhos dizem ao navegador: "isto é um arquivo para BAIXAR",
// e qual é o nome dele (ex: relatorio_fretes_2026-11-23.csv)
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="relatorio_fretes_' . $data . '.csv"');

// php://output escreve direto no arquivo que o navegador vai baixar
$saida = fopen('php://output', 'w');

// Esta marca no início do arquivo faz o Excel mostrar os acentos corretamente
fwrite($saida, "\xEF\xBB\xBF");

// Primeira linha do arquivo: os títulos das colunas.
// O ponto e vírgula (;) separa as colunas, que é o padrão do Excel em português.
fputcsv($saida, ['ID', 'Data', 'Transportador', 'Placa', 'Origem', 'Destino', 'Produtos', 'Peso total (kg)', 'Valor total (R$)'], ';');

// Uma linha para cada frete encontrado
foreach ($fretes as $f) {
    fputcsv($saida, [
        $f['id'],
        date('d/m/Y', strtotime($f['data'])),
        $f['transportador'],
        $f['placa'],
        $f['origem'],
        $f['destino'],
        $f['produtos'],
        number_format($f['peso_total'], 2, ',', '.'),
        number_format($f['valor_total'], 2, ',', '.'),
    ], ';');
}

fclose($saida);
exit;