<?php
$titulo = 'Relatórios - Rota';
$pagina = 'relatorios';   // destaca "Relatórios" no menu

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<h1 class="fw-bold">Relatórios</h1>
<p class="text-secondary">Consulte e baixe os fretes de um dia.</p>

<!-- Aviso que aparece quando não há fretes na data escolhida -->
<?php if (isset($_GET['vazio'])): ?>
    <div class="alert alert-warning">
        Não existem fretes na data escolhida. Tente outra data.
    </div>
<?php endif; ?>

<div class="card shadow-sm mt-3" style="max-width: 500px;">
    <div class="card-body">

        <!-- method="get": a data vai na URL para o relatorio_baixar.php -->
        <form action="<?php echo $base; ?>pages/relatorio_baixar.php" method="get">
            <div class="mb-3">
                <label class="form-label">Data dos fretes</label>
                <input type="date" name="data" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
            </div>

            <button type="submit" class="btn btn-success">Baixar relatório (CSV)</button>
        </form>

    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>