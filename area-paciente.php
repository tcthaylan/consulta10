<?php require_once('pages/header.php'); ?>
<?php
if (empty($_SESSION['id_usuario']) && $_SESSION['id_tipo_usuario'] == 1) {
    header('Location: index.php');
    exit;
}
$m = new Medico($conn);
$e = new Especialidade($conn);

$medicos = $m->getMedicos();
$qtd_medicos = $m->getTotalMedicos();
$especialidades = $e->getEspecialidades();

// Paginação
$qtd_por_pagina = 3;
$qtd_paginas = $m->getTotalPaginas($qtd_por_pagina, $qtd_medicos);
$p = '1';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = addslashes($_GET['p']);
}
?>

<div class="container">
    <div class="row">
        <div class="col-3">
            <h3>Pesquisa Avançada</h3>
            <form method="GET">
                <div class="form-group">
                    <label for="nome_medico">Nome do Médico</label>
                    <input type="text" name="filtros[nome_medico]" id="nome_medico" class="form-control">
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" name="filtros[endereco]" id="endereco" class="form-control" placeholder="Cidade, estado ou região">
                </div>
                <div class="form-group">
                    <label for="especialidade">Especialização</label>
                    <select name="filtros[especialidade]" id="especialidade" class="form-control">
                        <?php foreach ($especialidades as $value): ?>
                            <option value="<?php echo $value['id_especialidade'] ?>"><?php echo $value['nome_especialidade']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="Buscar" class="btn btn-primary">
            </form>
        </div>
        <div class="col-9">
            <h3><?php echo $qtd_medicos; ?> médicos listados</h3>
            <!-- Listagem de médicos -->
            <ul class="listagem_medicos">
                <?php foreach ($medicos as $medic): ?>
                    <li class="lista_item">
                        <h4><?php echo $medic['nome_especialidade']; ?></h4>
                        <h5>Doutor: <?php echo $medic['nome_medico']." ".$medic['sobrenome_medico']; ?></h5>
                        <p><?php echo $medic['cidade']." - ".$medic['estado']; ?></p>
                        <p><?php echo $medic['desc']; ?></p>
                        <a href="#" class="botao-mais-detalhes">Mais detalhes</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- Paginação -->
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $qtd_paginas; $i++):?>
                    <li class="page-item <?php echo($i == $i) ?>">
                        <a href="" class="page-link"></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php require_once('pages/footer.php'); ?>