<?php
require_once '../includes/conexao.php';

$titulo = 'Transportador - Rota';
$pagina = 'transportadores';   // destaca "Transportadores" no menu

// Valores vazios, usados quando estamos CADASTRANDO um transportador novo
$transportador = ['id' => '', 'nome' => '', 'cpf_cnpj' => '', 'telefone' => '', 'placa' => ''];

// Se a URL tiver ?id=..., estamos EDITANDO: buscamos no banco
if (isset($_GET['id'])) {
    $consulta = $pdo->prepare('SELECT * FROM transportador WHERE id = ?');
    $consulta->execute([$_GET['id']]);
    $encontrado = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($encontrado) {
        $transportador = $encontrado;
    }
}

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<h1 class="fw-bold"><?php echo $transportador['id'] ? 'Editar transportador' : 'Novo transportador'; ?></h1>

<div class="card shadow-sm mt-4" style="max-width: 700px;">
    <div class="card-body">

        <form action="<?php echo $base; ?>pages/transportador_salvar.php" method="post">

            <!-- Campo escondido com o id (vazio quando é transportador novo) -->
            <input type="hidden" name="id" value="<?php echo $transportador['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required
                       value="<?php echo htmlspecialchars($transportador['nome']); ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">CPF ou CNPJ</label>
                    <input type="text" name="cpf_cnpj" class="form-control" maxlength="18"
                           value="<?php echo htmlspecialchars($transportador['cpf_cnpj']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control" maxlength="20"
                           value="<?php echo htmlspecialchars($transportador['telefone']); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Placa do veículo</label>
                <input type="text" name="placa" class="form-control" maxlength="10"
                       value="<?php echo htmlspecialchars($transportador['placa']); ?>">
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="<?php echo $base; ?>pages/transportadores.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>

    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>