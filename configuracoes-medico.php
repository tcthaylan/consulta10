<?php require_once('pages/header.php'); ?>
<?php
$m = new Medico($conn);
$e = new Especialidade($conn);
$hm = new HorarioMedico($conn);
$endereco = new EnderecoConsultorio($conn);

$medico = $m->getMedico($_SESSION['id_usuario']);
$horarioMedico = $hm->getHorarioMedico($medico['id_horario_medico']);
$especialidades = $e->getEspecialidades();

if (isset($_POST['nome_medico']) && !empty($_POST['nome_medico'])) {
    $nome_medico        = addslashes($_POST['nome_medico']);
    $sobrenome_medico   = addslashes($_POST['sobrenome_medico']);
    $data_nascimento    = addslashes($_POST['data_nascimento']);
    $id_especialidade   = addslashes($_POST['id_especialidade']);
    $estado             = addslashes($_POST['estado']);
    $cidade             = addslashes($_POST['cidade']);
    $nome_rua           = addslashes($_POST['nome_rua']);
    $numero_rua         = addslashes($_POST['numero_rua']);
    $complemento        = addslashes($_POST['complemento']);
    $cep                = addslashes($_POST['cep']);
    $num_res            = addslashes($_POST['num_res']);
    $num_cel            = addslashes($_POST['num_cel']);
    $horario_inicio      = addslashes($_POST['horario_inicio']);
    $horario_fim        = addslashes($_POST['horario_fim']);
    $intervalo          = addslashes($_POST['intervalo']);

    // Convertendo data de dascimento para o padrão mysql
    $data_nascimento = explode('/', $data_nascimento);
    $data_nascimento = $data_nascimento[2]."-".$data_nascimento[1]."-".$data_nascimento[0];

    if (!empty($_POST['nome_medico']) && !empty($_POST['sobrenome_medico']) && !empty($_POST['data_nascimento']) && !empty($_POST['nome_rua']) && !empty($_POST['numero_rua']) && !empty($_POST['complemento']) && !empty($_POST['cep']) && !empty($_POST['horario_inicio']) && !empty($_POST['horario_fim']) && !empty($_POST['intervalo']) && (!empty($_POST['num_res']) || !empty($_POST['num_cel'])) ) {
        if ($m->editarMedico($_SESSION['id_usuario'], $medico['id_telefone_medico'], $medico['id_endereco_consultorio'], $medico['id_horario_medico'], $nome_medico, $sobrenome_medico, $data_nascimento, $id_especialidade, $estado, $cidade, $nome_rua, $numero_rua, $complemento, $cep, $horario_inicio, $horario_fim, $intervalo, $num_res, $num_cel)) {
            ?>
            <div class="alert alert-success">
                <strong>Parabéns!</strong> Editado com sucesso.
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger">
                2222
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-warning">
            Preencha todos os campos!
        </div>
        <?php
    }
}
$medico = $m->getMedico($_SESSION['id_usuario']);
?>

<div class="container">
    <div class="row">
        <div class="col-12 cabecalho-cadatrar">
            <h2>Editar Perfil</h2>
            <p class="lead">Enim elit sint deserunt officia est.</p>
            <hr>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="form-cadastro">
                <!-- Editar Perfil -->
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="nome_medico">Nome</label>
                            <input type="text" name="nome_medico" id="nome_medico" placeholder="Nome" class="form-control" value="<?php echo $medico['nome_medico'] ?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="sobrenome_medico">Sobrenome</label>
                            <input type="text" name="sobrenome_medico" id="sobrenome_medico" placeholder="Sobrenome" class="form-control" value="<?php echo $medico['sobrenome_medico'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data_nascimento">Data Nascimento</label>
                        <input type="text" name="data_nascimento" id="data_nascimento" placeholder="dd/mm/aaaa" class="form-control" value="<?php echo date('d/m/Y', strtotime($medico['data_nascimento'])) ?>" >
                    </div>
                    <div class="form-group">
                        <label for="id_especialidade">Especialidade</label>
                        <select name="id_especialidade" id="id_especialidade" class="form-control">
                            <option>Especialidade</option>
                            <?php foreach ($especialidades as $value): ?> 
                                <option value="<?php echo $value['id_especialidade'];?>" <?php echo($value['id_especialidade'] == $medico['id_especialidade'])?"selected='selected'":'';?>><?php echo $value['nome_especialidade']?></option>    
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" name="estado" id="estado" placeholder="Estado" class="form-control" value="<?php echo $medico['estado'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" id="cidade" placeholder="Cidade" class="form-control" value="<?php echo $medico['cidade'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nome_rua">Rua</label>
                        <input type="text" name="nome_rua" id="nome_rua" placeholder="Rua" class="form-control" value="<?php echo $medico['nome_rua'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="numero_rua">Número</label>
                        <input type="text" name="numero_rua" id="numero_rua" placeholder="Número" class="form-control" value="<?php echo $medico['numero_rua'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" name="complemento" id="complemento" placeholder="Complemento" class="form-control" value="<?php echo $medico['complemento'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="cep">Cep</label>
                        <input type="text" name="cep" id="cep" placeholder="CEP" class="form-control" value="<?php echo $medico['cep'] ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="num_res">Residencial</label>
                            <input type="text" name="num_res" id="num_res" placeholder="Número Residencial" class="form-control" value="<?php echo $medico['num_residente'] ?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="num_cel">Celular</label>
                            <input type="text" name="num_cel" id="num_cel" placeholder="Número Celular" class="form-control" value="<?php echo $medico['num_celular'] ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-5">
                            <label for="horario_inicio">Inicio do turno</label>
                            <input type="text" name="horario_inicio" id="horario_inicio" class="form-control" placeholder="ex: 10:30" value="<?php echo $horarioMedico['horario_inicio'] ?>">
                        </div>
                        <div class="form-group col-5">
                            <label for="horario_fim">Fim do turno</label>
                            <input type="text" name="horario_fim" id="horario_fim" class="form-control" placeholder="ex: 17:00" value="<?php echo $horarioMedico['horario_fim'] ?>">
                        </div>
                        <div class="form-group col-2">
                            <label for="intervalo">Intervalo</label>
                            <input type="text" name="intervalo" id="intervalo" class="form-control" placeholder="ex: 00:30" value="<?php echo $horarioMedico['intervalo'] ?>">
                        </div>
                    </div>
                    <input type="submit" value="Salvar" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once('pages/footer.php'); ?>