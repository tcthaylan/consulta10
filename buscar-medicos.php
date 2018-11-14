<?php require_once('pages/header.php'); ?>
<?php
// Verifica se o usuário é um paciente
if (empty($_SESSION['id_usuario']) || $_SESSION['id_tipo_usuario'] != 1) {
    header('Location: sair.php');
    exit;
}

$m = new Medico($conn);
$e = new Especialidade($conn);

/* Filtros desabilitado
$filtros = array(
    'nome_medico'       => '',
    'id_especialidade'  => '',
    'estado'            => '',
    'cidade'            => ''       
);
// Verifica se existe algum filtro ativado
if (isset($_GET['filtros'])) {
    $filtros = $_GET['filtros'];
}
*/

$especialidades = $e->getEspecialidades();

// Paginação
$qtd_medicos = $m->getTotalMedicos();
$qtd_por_pagina = 5;
$qtd_paginas = $m->getTotalPaginas($qtd_por_pagina, $qtd_medicos);
$p = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = addslashes($_GET['p']);
}
$medicos = $m->getMedicos($p, $qtd_por_pagina);
?>

<div class="container">
    <div class="row area-usuario">
        <!-- Filtros -->
        <div class="col-12 col-lg-4">
            <h3 class="titulo-coluna">Pesquisa Avançada</h3>
            <hr class="traco-titulo">
            <form method="GET" class="filtros" onsubmit="return false">
                <div class="form-group">
                    <input type="text" name="filtros[nome_medico]" id="nome_medico" class="form-control" placeholder="Nome do médico">
                </div>
                <div class="form-group">
                    <select name="filtros[id_especialidade]" id="especialidade" class="form-control">
                        <option value="">Especialidade</option>
                        <?php foreach ($especialidades as $value): ?>
                            <option value="<?php echo $value['id_especialidade'] ?>"><?php echo $value['nome_especialidade']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="filtros[estado]" id="estado" class="form-control" placeholder="Estado">
                </div>
                <div class="form-group">
                    <input type="text" name="filtros[cidade]" id="cidade" class="form-control" placeholder="Cidade">
                </div>
                <input type="submit" value="Filtrar" class="botao-filtrar">
            </form>
        </div>
        <!-- Lista de médicos -->
        <div class="col-12 col-lg-8">
            <h3 class="titulo-coluna">Médicos listados</h3>
            <hr class="traco-titulo">
            <!-- Listagem de médicos -->
            <ul class="listagem_medicos">
                <?php foreach ($medicos as $medic): ?>
                    <li class="lista_item">
                        <p class="endereco"><?php echo $medic['cidade']." - ".$medic['estado']; ?></p>
                        <h4 class="nome_especialidade"><?php echo $medic['nome_especialidade']; ?></h4>
                        <h5 class="nome_medico"><?php echo $medic['nome_medico']." ".$medic['sobrenome_medico']; ?></h5>
                        <p class="desc_especialidade"><?php echo $medic['desc']; ?></p>
                        <a href="mais-detalhes.php?id_medico=<?php echo $medic['id_medico']; ?>" class="botao-mais-detalhes">Mais detalhes</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- Paginação -->
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= ceil($qtd_paginas); $i++):?>
                    <li class="page-item <?php echo($p == $i)?'active':''; ?>">
                        <a href="buscar-medicos.php?<?php
                        $url = $_GET;
                        $url['p'] = $i;
                        echo http_build_query($url);
                        ?>" class="page-link"><?php echo $i ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php require_once('pages/footer.php'); ?>