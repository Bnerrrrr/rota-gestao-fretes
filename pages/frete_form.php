<?php
require_once '../includes/conexao.php';

$titulo = 'Novo frete - Rota';
$pagina = 'fretes';   // destaca "Fretes" no menu

// Busca as listas que vão aparecer no formulário
$transportadores = $pdo->query('SELECT id, nome, placa FROM transportador ORDER BY nome')->fetchAll(PDO::FETCH_ASSOC);
$enderecos       = $pdo->query('SELECT id, apelido, cidade, estado FROM endereco ORDER BY apelido')->fetchAll(PDO::FETCH_ASSOC);
$produtos        = $pdo->query('SELECT id, nome, peso FROM produto ORDER BY nome')->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<h1 class="fw-bold">Novo frete</h1>
<p class="text-secondary">Reúna o transportador, os endereços e os produtos em um frete.</p>

<!-- Avisos de erro, enviados pelo frete_salvar.php -->
<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-warning">
        Preencha todos os campos, escolha origem e destino diferentes e marque ao menos um produto.
    </div>
<?php endif; ?>

<!-- Se faltar algum cadastro, avisa em vez de mostrar o formulário -->
<?php if (count($transportadores) === 0 || count($enderecos) < 2 || count($produtos) === 0): ?>
    <div class="alert alert-info">
        Para gerar um frete, cadastre antes pelo menos 1 transportador, 2 endereços e 1 produto.
    </div>
<?php else: ?>

<div class="card shadow-sm mt-3" style="max-width: 700px;">
    <div class="card-body">

        <form action="<?php echo $base; ?>pages/frete_salvar.php" method="post">

            <div class="mb-3">
                <label class="form-label">Data do frete</label>
                <!-- date('Y-m-d') já deixa a data de hoje preenchida -->
                <input type="date" name="data" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Transportador</label>
                <select name="id_transportador" class="form-select" required>
                    <option value="">Selecione...</option>
                    <!-- Uma opção para cada transportador cadastrado. O value é o id. -->
                    <?php foreach ($transportadores as $t): ?>
                        <option value="<?php echo $t['id']; ?>">
                            <?php echo htmlspecialchars($t['nome'] . ' - ' . $t['placa']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Origem</label>
                    <select name="id_origem" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($enderecos as $e): ?>
                            <option value="<?php echo $e['id']; ?>">
                                <?php echo htmlspecialchars($e['apelido'] . ' (' . $e['cidade'] . '/' . $e['estado'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Destino</label>
                    <select name="id_destino" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($enderecos as $e): ?>
                            <option value="<?php echo $e['id']; ?>">
                                <?php echo htmlspecialchars($e['apelido'] . ' (' . $e['cidade'] . '/' . $e['estado'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Produtos (marque um ou mais)</label>
                <!-- name="produtos[]" com colchetes faz o PHP receber uma LISTA de ids -->
                <?php foreach ($produtos as $p): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="produtos[]"
                               value="<?php echo $p['id']; ?>" id="produto<?php echo $p['id']; ?>">
                        <label class="form-check-label" for="produto<?php echo $p['id']; ?>">
                            <?php echo htmlspecialchars($p['nome']); ?> (<?php echo $p['peso']; ?> kg)
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-success">Gerar frete</button>
            <a href="<?php echo $base; ?>pages/fretes.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>

    </div>
</div>

<?php endif; ?>

<?php require_once '../includes/rodape.php'; ?>