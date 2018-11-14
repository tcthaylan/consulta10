<?php require_once('pages/header.php'); ?>
<?php
if (isset($_GET['id_medico'])) {
    $id_medico = addslashes($_GET['id_medico']);
}
?>
<div class="container">
    <h1>Agendamento</h1>
    <div class="row">
        <div class="col-md-7">
            <form method="GET" action="agendar-tempo.php">
                <div class="form-group">
                    <label for="date">Selecione uma data:</label>
                    <input type="date" id="date" name="date" class="form-control">
                    <input type="hidden" name="id_medico" value="<?php echo $id_medico; ?>"/> 
                </div>
                <input type="submit" value="Continuar" class="btn btn-warning">
            </form>
        </div>
    </div>
</div>
<?php require_once('pages/footer.php'); ?>