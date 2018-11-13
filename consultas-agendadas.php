<?php require_once('pages/header.php'); ?>
<?php
if (empty($_SESSION['id_usuario'])) {
    header('Location: sair.php');
    exit;
}

$m = new Medico($conn);
$e = new Especialidade($conn);
$c = new Consulta($conn);

$especialidades = $e->getEspecialidades();

if ($_SESSION['id_tipo_usuario'] == 1) {
    $consultas = $c->getConsultasPaciente($_SESSION['id_usuario']);
} else {
    $consultas = $c->getConsultasMedico($_SESSION['id_usuario']);
}
?>
<div class="container">
    <div class="row justify-content-center area-usuario">
        <!-- Lista de médicos -->
        <div class="col-12 col-lg-8">
            <h3 class="titulo-coluna">Consultas Agendadas</h3>
            <hr class="traco-titulo">
            <!-- Listagem de médicos -->
            <ul class="listagem_medicos">
                <!-- Paciente Logado -->
                <?php if ($_SESSION['id_tipo_usuario'] == 1): ?>
                    <?php foreach ($consultas as $consult): ?>
                        <li class="lista_item">
                            <h4 class="nome_especialidade"><?php echo $consult['nome_especialidade'];  ?></h4>
                            <p>Doutro(a): <?php echo $consult['nome_medico']." ".$consult['sobrenome_medico']; ?></p>
                            <p>Endereço: <?php echo $consult['nome_rua'].", ".$consult['numero_rua'].", ".$consult['cidade']." - ".$consult['estado']; ?></p>
                            <p>E-mail: <?php echo $consult['email']; ?></p>
                            <p>Data: <?php echo date('d/m H:i', strtotime($consult['data_inicio'])); ?></p>
                            <a href="cancelar-consulta.php?id_consulta=<?php echo $consult['id_consulta']; ?>" class="botao-cancelar-consulta">Cancelar Consulta</a>
                        </li>
                    <?php endforeach; ?>
                <!-- Médico Logado -->
                <?php else: ?>
                    <?php foreach ($consultas as $consult): ?>
                        <li class="lista_item">
                            <h4 class="nome_especialidade"><?php echo $consult['nome_paciente']." ".$consult['sobrenome_paciente'];  ?></h4>
                            <p>E-mail: <?php echo $consult['email']; ?></p>
                            <p>Data: <?php echo date('d/m H:i', strtotime($consult['data_inicio'])); ?></p>
                            <a href="cancelar-consulta.php?id_consulta=<?php echo $consult['id_consulta']; ?>" class="botao-cancelar-consulta">Cancelar Consulta</a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php require_once('pages/footer.php');