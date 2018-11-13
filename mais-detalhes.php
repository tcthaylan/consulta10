<?php require_once('pages/header.php'); ?>
<?php

if (isset($_GET['id_medico'])) {
    $id_medico = addslashes($_GET['id_medico']);
}

$e = new Especialidade($conn);
$m = new Medico($conn);
$endereco = new EnderecoConsultorio($conn);

$medico = $m->getMedico($id_medico);
$especialidade = $e->getEspecialidade($medico['id_especialidade']);
$enderecoMedico = $endereco->getEnderecoMedico($medico['id_endereco_consultorio']);
?>
<div class="container">
    <div class="row">
        <div class="col-12 cabecalho-mais-detalhes">
            <h1><?php echo $especialidade['nome_especialidade'] ?></h1>
            <!-- Botão modal -->
            <a href="agendar-data.php?id_medico=<?php echo $id_medico; ?>" class="botao-agendar">Agendar</a>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <h2>Sobre o Doutor(a)</h2>
            <hr>
            <p>Nome: <?php echo $medico['nome_medico']." ".$medico['sobrenome_medico']; ?></p>
            <p>Email: <?php echo $medico['email']; ?></p>
            <p>Endereço do consultorio: <?php echo $enderecoMedico['nome_rua'].", ".$enderecoMedico['numero_rua'].", ".$enderecoMedico['cidade']." - ".$enderecoMedico['estado']; ?></p>
        </div>
        <div class="col-8">
            <h2>Sobre a Especialidade</h2>
            <hr>
            <p><?php echo $especialidade['desc']; ?></p>
        </div>
    </div>
</div>

<?php require_once('pages/footer.php'); ?>