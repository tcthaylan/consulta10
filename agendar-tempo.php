<?php require_once('pages/header.php'); ?>

<?php
if (!empty($_GET['date']) && !empty($_GET['id_medico'])) {
    $id_medico = addslashes($_GET['id_medico']);
    $data = addslashes($_GET['date']);

    $dataInicio = strtotime($data.'+8 hours');
    $dataFim = strtotime($data.'+17 hours');
    $intervalo = 60*30;
}

?>
<div class="container">
    <h1>Agendamento</h1>
    <div class="row">
        <div class="col-2">
            <ul>
                <?php for ($i = $dataInicio; $i < $dataFim; $i+=$intervalo): ?>
                    <li>
                        <a href="agendar-submit.php?datetime=<?php echo $i; ?>&id_medico=<?php echo $id_medico; ?>" class="btn btn-primary">
                            <?php echo date('d/m/Y H:i:s', $i); ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
</div>
<?php require_once('pages/footer.php'); ?>