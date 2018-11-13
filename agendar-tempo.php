<?php require_once('pages/header.php'); ?>
<?php
$m = new Medico($conn);
$hm = new HorarioMedico($conn);

if (!empty($_GET['date']) && !empty($_GET['id_medico'])) {
    $id_medico = addslashes($_GET['id_medico']);
    
    $medico = $m->getMedico($id_medico);
    $horarioMedico = $hm->getHorarioMedico($medico['id_horario_medico']);

    $data = addslashes($_GET['date']);
    $dataInicio = strtotime($data.$horarioMedico['horario_inicio']);
    $dataFim = strtotime($data.$horarioMedico['horario_fim']);
    $horarioIntervalo = explode(':', $horarioMedico['intervalo']);

    //$horas = intval($horarioIntervalo[0]);
    //$minutos = intval($horarioIntervalo[1]);

    $intervalo = 60*30;

}

?>  
<div class="container">
    <?php if (isset($_GET['horario']) AND $_GET['horario'] == 'indisponivel'): ?>
        <div class="alert alert-danger">
            Horário indisponível, seleciona outro horário!
        </div>
    <?php endif; ?>
    <h1>Agendamento</h1>
    <p>Data: <?php echo date('d/m/Y', strtotime($data)); ?></p>
    <div class="row">
        <div class="col-7">
            <p>Selecione o horário: </p>
            <ul class="lista-horarios">
                <?php for ($i = $dataInicio; $i < $dataFim; $i+=$intervalo): ?>
                    <li>
                        <a href="agendar-submit.php?datetime=<?php echo $i; ?>&id_medico=<?php echo $id_medico; ?>" class="btn btn-secondary">
                            <?php echo date('H:i', $i); ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
</div>
<?php require_once('pages/footer.php'); ?>