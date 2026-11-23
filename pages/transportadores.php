<?php
require_once '../includes/conexao.php';

$titulo = 'Transportadores - Rota';
$pagina = 'transportadores';

// Busca todos os transportadores, do mais novo para o mais antigo
$consulta        = $pdo->query('SELECT * FROM transportador ORDER BY id DESC');
$transportadores = $consulta->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold">Transportadores</h1>
        <p class="text-secondary">Veja e gerencie os parceiros da operação.</p>
    </div>
    <a href="<?php echo $base; ?>pages/transportador_form.php" class="btn btn-success">+ Novo transportador</a>
</div>

<!-- Aviso que aparece se o transportador não puder ser excluído -->
<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-warning">
        Este transportador está em um frete e não pode ser excluído.
    </div>
<?php endif; ?>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF/CNPJ</th>
                    <th>Telefone</th>
                    <th>Placa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($transportadores) === 0): ?>
                    <tr><td colspan="6" class="text-center text-secondary">Nenhum transportador cadastrado.</td></tr>
                <?php endif; ?>

                <?php foreach ($transportadores as $t): ?>
                    <tr>
                        <td><?php echo $t['id']; ?></td>
                        <td><?php echo htmlspecialchars($t['nome']); ?></td>
                        <td><?php echo htmlspecialchars($t['cpf_cnpj']); ?></td>
                        <td><?php echo htmlspecialchars($t['telefone']); ?></td>
                        <td><?php echo htmlspecialchars($t['placa']); ?></td>
                        <td>
                            <a href="<?php echo $base; ?>pages/transportador_form.php?id=<?php echo $t['id']; ?>"
                               class="btn btn-sm btn-outline-primary">Editar</a>
                            <a href="<?php echo $base; ?>pages/transportador_excluir.php?id=<?php echo $t['id']; ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Excluir este transportador?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>