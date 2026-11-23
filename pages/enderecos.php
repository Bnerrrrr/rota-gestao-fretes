<?php
require_once '../includes/conexao.php';

$titulo = 'Endereços - Rota';
$pagina = 'enderecos';

// Busca todos os endereços, do mais novo para o mais antigo
$consulta  = $pdo->query('SELECT * FROM endereco ORDER BY id DESC');
$enderecos = $consulta->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold">Endereços</h1>
        <p class="text-secondary">Gerencie os locais de origem e destino.</p>
    </div>
    <a href="<?php echo $base; ?>pages/endereco_form.php" class="btn btn-success">+ Novo endereço</a>
</div>

<!-- Aviso que aparece se o endereço não puder ser excluído -->
<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-warning">
        Este endereço está em um frete e não pode ser excluído.
    </div>
<?php endif; ?>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Apelido</th>
                    <th>Endereço</th>
                    <th>Cidade/UF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($enderecos) === 0): ?>
                    <tr><td colspan="5" class="text-center text-secondary">Nenhum endereço cadastrado.</td></tr>
                <?php endif; ?>

                <?php foreach ($enderecos as $e): ?>
                    <tr>
                        <td><?php echo $e['id']; ?></td>
                        <td><?php echo htmlspecialchars($e['apelido']); ?></td>
                        <!-- Junta rua, número e bairro em uma só coluna -->
                        <td>
                            <?php echo htmlspecialchars($e['rua'] . ', ' . $e['numero']); ?><br>
                            <small class="text-secondary"><?php echo htmlspecialchars($e['bairro']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($e['cidade'] . '/' . $e['estado']); ?></td>
                        <td>
                            <a href="<?php echo $base; ?>pages/endereco_form.php?id=<?php echo $e['id']; ?>"
                               class="btn btn-sm btn-outline-primary">Editar</a>
                            <a href="<?php echo $base; ?>pages/endereco_excluir.php?id=<?php echo $e['id']; ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Excluir este endereço?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>