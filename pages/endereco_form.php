<?php
require_once '../includes/conexao.php';

$titulo = 'Endereço - Rota';
$pagina = 'enderecos';   // destaca "Endereços" no menu

// Valores vazios, usados quando estamos CADASTRANDO um endereço novo
$endereco = [
    'id' => '', 'apelido' => '', 'rua' => '', 'numero' => '',
    'bairro' => '', 'cidade' => '', 'estado' => '', 'cep' => ''
];

// Se a URL tiver ?id=..., estamos EDITANDO: buscamos o endereço no banco
if (isset($_GET['id'])) {
    $consulta = $pdo->prepare('SELECT * FROM endereco WHERE id = ?');
    $consulta->execute([$_GET['id']]);
    $encontrado = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($encontrado) {
        $endereco = $encontrado;
    }
}

require_once '../includes/cabecalho.php';
require_once '../includes/menu.php';
?>

<h1 class="fw-bold"><?php echo $endereco['id'] ? 'Editar endereço' : 'Novo endereço'; ?></h1>

<div class="card shadow-sm mt-4" style="max-width: 700px;">
    <div class="card-body">

        <form action="<?php echo $base; ?>pages/endereco_salvar.php" method="post">

            <!-- Campo escondido com o id (vazio quando é endereço novo) -->
            <input type="hidden" name="id" value="<?php echo $endereco['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Apelido (ex: Depósito Santos)</label>
                <input type="text" name="apelido" class="form-control" required
                       value="<?php echo htmlspecialchars($endereco['apelido']); ?>">
            </div>

            <div class="row">
                <div class="col-md-9 mb-3">
                    <label class="form-label">Rua</label>
                    <input type="text" name="rua" class="form-control"
                           value="<?php echo htmlspecialchars($endereco['rua']); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control"
                           value="<?php echo htmlspecialchars($endereco['numero']); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Bairro</label>
                <input type="text" name="bairro" class="form-control"
                       value="<?php echo htmlspecialchars($endereco['bairro']); ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cidade</label>
                    <input type="text" name="cidade" class="form-control"
                           value="<?php echo htmlspecialchars($endereco['cidade']); ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">UF</label>
                    <!-- maxlength="2" limita a 2 letras, como PR, SP -->
                    <input type="text" name="estado" class="form-control" maxlength="2"
                           value="<?php echo htmlspecialchars($endereco['estado']); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">CEP</label>
                    <input type="text" name="cep" class="form-control" maxlength="9"
                           value="<?php echo htmlspecialchars($endereco['cep']); ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="<?php echo $base; ?>pages/enderecos.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>

    </div>
</div>

<?php require_once '../includes/rodape.php'; ?>