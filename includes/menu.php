<?php
// $pagina diz qual tela está aberta, para destacar o item no menu.
// Se a tela não definiu, usamos um texto vazio.
$pagina = $pagina ?? '';

// Lista dos itens do menu (um "array"):
// 'nome-interno' => ['texto que aparece', 'arquivo de destino', 'número']
$itens = [
    'inicio'          => ['Início',          'index.php',                    '01'],
    'produtos'        => ['Produtos',        'pages/produtos.php',           '02'],
    'enderecos'       => ['Endereços',       'pages/enderecos.php',          '03'],
    'transportadores' => ['Transportadores', 'pages/transportadores.php',    '04'],
    'fretes'          => ['Fretes',          'pages/fretes.php',             '05'],
    'relatorios'      => ['Relatórios',      'pages/relatorios.php',         '06'],
];
?>
<div class="layout">

    <aside class="menu-lateral">
        <div class="logo">
            rota
            <small>GESTÃO DE FRETES</small>
        </div>

        <nav>
            <!-- foreach repete o bloco abaixo uma vez para cada item da lista -->
            <?php foreach ($itens as $chave => $item): ?>
                <a href="<?php echo $base . $item[1]; ?>"
                   class="item-menu <?php echo ($pagina === $chave) ? 'ativo' : ''; ?>">
                    <span class="numero"><?php echo $item[2]; ?></span>
                    <?php echo $item[0]; ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>

    <!-- Aqui começa a área de conteúdo; o rodape.php fecha esta tag -->
    <main class="conteudo">