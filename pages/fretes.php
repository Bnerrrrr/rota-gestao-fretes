<?php
require_once '../includes/conexao.php';

$titulo = 'Fretes - Rota';
$pagina = 'fretes';

// JOIN junta as tabelas para mostrar NOMES em vez de números (ids).
// GROUP_CONCAT junta os nomes dos produtos de cada frete em um só texto.
$sql = 'SELECT f.id, f.data,
               t.nome AS transportador,
               o.apelido AS origem,
               d.apelido AS destino,
               GROUP_CONCAT(p.nome SEPARATOR ", ") AS produtos
        FROM frete f
        JOIN transportador t ON t.id = f.id_transportador
        JOIN endereco o ON o.id = f.id_origem
        JOIN endereco d ON d.id = f.id_destino
        LEFT JOIN frete_produto fp ON fp.id_frete = f.id
        LEFT JOIN produto p ON p.id = fp.id_produto
        GROUP BY f.id, f.data, t.nome, o.apelido, d.apelido
        ORDER BY f.id DESC';
$fretes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold">Fretes</h1>
        <p class="text-secondary">Acompanhe os fretes gerados.</p>
    </div>
    <a href="<?php echo $base; ?>pages/frete_form.php" class="btn btn-success">+ Novo frete</a>
</div>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Produtos</th>
                    <th>Rota</th>
                    <th>Transportador</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($fretes) === 0): ?>
                    <tr><td colspan="6" class="text-center text-secondary">Nenhum frete gerado.</td></tr>
                <?php endif; ?>

                <?php foreach ($fretes as $f): ?>
                    <tr>
                        <td>#<?php echo $f['id']; ?></td>
                        <!-- Converte a data do banco (2026-11-23) para o padrão brasileiro (23/11/2026) -->
                        <td><?php echo date('d/m/Y', strtotime($f['data'])); ?></td>
                        <td><?php echo htmlspecialchars($f['produtos']); ?></td>
                        <td><?php echo htmlspecialchars($f['origem'] . ' → ' . $f['destino']); ?></td>
                        <td><?php echo htmlspecialchars($f['transportador']); ?></td>
                        <td>
                            <a href="<?php echo $base; ?>pages/frete_excluir.php?id=<?php echo $f['id']; ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Excluir este frete?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>