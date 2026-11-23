<?php
// $base é o "endereço inicial" do projeto no navegador.
// Usando ele nos links, eles funcionam em qualquer pasta (index, pages...).
$base = '/rota/';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Título da aba: usa $titulo se a tela definiu, senão usa o texto padrão -->
    <title><?php echo $titulo ?? 'Rota - Gestão de Fretes'; ?></title>

    <!-- Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Nosso CSS, que ajusta as cores para ficar igual ao Figma -->
    <link href="<?php echo $base; ?>css/estilo.css" rel="stylesheet">
</head>
<body>