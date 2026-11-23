<?php
require_once '../includes/conexao.php';

$titulo = 'Produtos - Rota';
$pagina = 'produtos';

// Busca todos os produtos, do mais novo para o mais antigo
$consulta = $pdo->query('SELECT * FROM produto ORDER BY id DESC');
$produtos = $consulta->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold">Produtos</h1>
        <p class="text-secondary">Organize o catálogo de produtos.</p>
    </div>
    <a href="<?php echo $base; ?>pages/produto_form.php" class="btn btn-success">+ Novo produto</a>
</div>

<!-- Aviso que aparece se o produto não puder ser excluído -->
<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-warning">
        Este produto está em um frete e não pode ser excluído.
    </div>
<?php endif; ?>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Peso</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Se a lista estiver vazia, mostra uma mensagem -->
                <?php if (count($produtos) === 0): ?>
                    <tr><td colspan="5" class="text-center text-secondary">Nenhum produto cadastrado.</td></tr>
                <?php endif; ?>

                <!-- Repete uma linha da tabela para cada produto -->
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?php echo $p['id']; ?></td>
                        <td><?php echo htmlspecialchars($p['nome']); ?></td>
                        <td><?php echo $p['peso']; ?> kg</td>
                        <!-- number_format escreve o valor no padrão brasileiro: 1.250,00 -->
                        <td>R$ <?php echo number_format($p['valor'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="<?php echo $base; ?>pages/produto_form.php?id=<?php echo $p['id']; ?>"
                               class="btn btn-sm btn-outline-primary">Editar</a>
                            <!-- onclick pergunta "Tem certeza?" antes de excluir -->
                            <a href="<?php echo $base; ?>pages/produto_excluir.php?id=<?php echo $p['id']; ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Excluir este produto?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>