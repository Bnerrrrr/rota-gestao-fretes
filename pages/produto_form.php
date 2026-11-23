<?php
require_once '../includes/conexao.php';

$titulo = 'Produto - Rota';
$pagina = 'produtos';   // destaca "Produtos" no menu

// Valores vazios, usados quando estamos CADASTRANDO um produto novo
$produto = ['id' => '', 'nome' => '', 'descricao' => '', 'peso' => '', 'valor' => ''];

// Se a URL tiver ?id=5, estamos EDITANDO: buscamos o produto 5 no banco
if (isset($_GET['id'])) {
    // O "?" será trocado pelo id. Isso protege o banco contra ataques (SQL Injection).
    $consulta = $pdo->prepare('SELECT * FROM produto WHERE id = ?');
    $consulta->execute([$_GET['id']]);
    $encontrado = $consulta->fetch(PDO::FETCH_ASSOC);

    // Se achou, substitui os valores vazios pelos do banco
    if ($encontrado) {
        $produto = $encontrado;
    }
}

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<!-- Se tem id, o título é "Editar"; se não tem, é "Novo" -->
<h1 class="fw-bold"><?php echo $produto['id'] ? 'Editar produto' : 'Novo produto'; ?></h1>

<div class="card shadow-sm mt-4" style="max-width: 700px;">
    <div class="card-body">

        <!-- method="post": os dados vão escondidos para o produto_salvar.php -->
        <form action="<?php echo $base; ?>pages/produto_salvar.php" method="post">

            <!-- Campo escondido: guarda o id (vazio quando é produto novo) -->
            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <!-- htmlspecialchars evita que textos estranhos quebrem a página -->
                <input type="text" name="nome" class="form-control" required
                       value="<?php echo htmlspecialchars($produto['nome']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <input type="text" name="descricao" class="form-control"
                       value="<?php echo htmlspecialchars($produto['descricao']); ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" class="form-control"
                           value="<?php echo $produto['peso']; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Valor (R$)</label>
                    <input type="number" step="0.01" name="valor" class="form-control"
                           value="<?php echo $produto['valor']; ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="<?php echo $base; ?>pages/produtos.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>

    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>