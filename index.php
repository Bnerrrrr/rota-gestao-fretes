<?php
require_once 'includes/conexao.php';

$titulo = 'Início - Rota';
$pagina = 'inicio';

// COUNT(*) conta quantas linhas existem em cada tabela.
// fetchColumn() devolve esse número direto.
$total_fretes          = $pdo->query('SELECT COUNT(*) FROM frete')->fetchColumn();
$total_produtos        = $pdo->query('SELECT COUNT(*) FROM produto')->fetchColumn();
$total_transportadores = $pdo->query('SELECT COUNT(*) FROM transportador')->fetchColumn();

// Conta só os fretes cuja data é a de hoje
$consulta = $pdo->prepare('SELECT COUNT(*) FROM frete WHERE data = ?');
$consulta->execute([date('Y-m-d')]);
$fretes_hoje = $consulta->fetchColumn();

// Busca os 3 fretes mais recentes (LIMIT 3)
$sql = 'SELECT f.id, f.data,
               t.nome AS transportador,
               o.cidade AS cidade_origem, o.estado AS estado_origem,
               d.cidade AS cidade_destino, d.estado AS estado_destino,
               GROUP_CONCAT(p.nome SEPARATOR ", ") AS produtos
        FROM frete f
        JOIN transportador t ON t.id = f.id_transportador
        JOIN endereco o ON o.id = f.id_origem
        JOIN endereco d ON d.id = f.id_destino
        LEFT JOIN frete_produto fp ON fp.id_frete = f.id
        LEFT JOIN produto p ON p.id = fp.id_produto
        GROUP BY f.id, f.data, t.nome, o.cidade, o.estado, d.cidade, d.estado
        ORDER BY f.id DESC
        LIMIT 3';
$recentes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/cabecalho.php';
require_once 'includes/menu.php';
?>

<!-- Estilo só desta tela: os atalhos viram cartões clicáveis -->
<style>
    .atalho {
        display: block;
        height: 100%;                 /* todos os cartões com a mesma altura */
        background: #ffffff;
        border: 1px solid #dfe7e5;
        border-radius: 12px;
        padding: 18px 16px;
        text-decoration: none;
        transition: all 0.2s;         /* deixa a mudança do mouse suave */
    }
    .atalho .titulo {
        display: block;
        color: #0f7a6a;               /* verde do design */
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 4px;
    }
    .atalho small {
        color: #6c7a7f;
    }
    /* Quando o mouse passa por cima: sobe um pouco e ganha sombra */
    .atalho:hover {
        border-color: #0f7a6a;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        transform: translateY(-3px);
    }
</style>

<h1 class="fw-bold">Início</h1>
<p class="text-secondary">Tudo o que você precisa para manter sua operação em movimento.</p>

<!-- ===== Cartões com os totais ===== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <small class="text-secondary">Fretes gerados</small>
                <div class="display-6 fw-bold"><?php echo $total_fretes; ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <small class="text-secondary">Fretes de hoje</small>
                <div class="display-6 fw-bold"><?php echo $fretes_hoje; ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <small class="text-secondary">Produtos cadastrados</small>
                <div class="display-6 fw-bold"><?php echo $total_produtos; ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <small class="text-secondary">Transportadores</small>
                <div class="display-6 fw-bold"><?php echo $total_transportadores; ?></div>
            </div>
        </div>
    </div>
</div>

<!-- ===== Atalhos (cartões clicáveis) ===== -->
<h5 class="fw-bold">O que você quer fazer?</h5>
<div class="row g-3 mb-4">
    <div class="col-6 col-md">
        <a href="<?php echo $base; ?>pages/produtos.php" class="atalho">
            <span class="titulo">Produtos →</span>
            <small>Organizar catálogo</small>
        </a>
    </div>
    <div class="col-6 col-md">
        <a href="<?php echo $base; ?>pages/enderecos.php" class="atalho">
            <span class="titulo">Endereços →</span>
            <small>Gerenciar locais</small>
        </a>
    </div>
    <div class="col-6 col-md">
        <a href="<?php echo $base; ?>pages/transportadores.php" class="atalho">
            <span class="titulo">Transportadores →</span>
            <small>Ver parceiros</small>
        </a>
    </div>
    <div class="col-6 col-md">
        <a href="<?php echo $base; ?>pages/frete_form.php" class="atalho">
            <span class="titulo">Novo frete →</span>
            <small>Registrar entrega</small>
        </a>
    </div>
    <div class="col-6 col-md">
        <a href="<?php echo $base; ?>pages/relatorios.php" class="atalho">
            <span class="titulo">Relatórios →</span>
            <small>Consultar e baixar</small>
        </a>
    </div>
</div>

<!-- ===== Fretes recentes ===== -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="fw-bold mb-0">Fretes recentes</h5>
            <a href="<?php echo $base; ?>pages/fretes.php" class="btn btn-sm btn-outline-secondary">Ver todos os fretes</a>
        </div>

        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Frete / Produtos</th>
                    <th>Rota</th>
                    <th>Transportador</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($recentes) === 0): ?>
                    <tr><td colspan="4" class="text-center text-secondary">Nenhum frete gerado ainda.</td></tr>
                <?php endif; ?>

                <?php foreach ($recentes as $f): ?>
                    <tr>
                        <td>#<?php echo $f['id']; ?> · <?php echo htmlspecialchars($f['produtos']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($f['cidade_origem'] . ', ' . $f['estado_origem']); ?>
                            →
                            <?php echo htmlspecialchars($f['cidade_destino'] . ', ' . $f['estado_destino']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($f['transportador']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($f['data'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="alert alert-success mt-4">
    Comece pelos cadastros. Depois, reúna produtos, transportador e endereços em um novo frete.
</div>

<?php require_once 'includes/rodape.php'; ?>