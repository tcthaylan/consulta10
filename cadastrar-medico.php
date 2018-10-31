<?php require_once('pages/header.php'); ?>
<?php 

$m = new Medico($conn);
$e = new Especialidade($conn);

$especialidades = $e->getEspecialidades();

if (isset($_POST['nome_medico']) && !empty($_POST['nome_medico'])) {
    $nome_medico        = addslashes($_POST['nome_medico']);
    $sobrenome_medico   = addslashes($_POST['sobrenome_medico']);
    $cpf                = addslashes($_POST['cpf']);
    $crm                = addslashes($_POST['crm']);
    $data_nascimento    = addslashes($_POST['data_nascimento']);
    $id_especialidade   = addslashes($_POST['id_especialidade']);
    $nome_rua           = addslashes($_POST['nome_rua']);
    $numero_rua         = addslashes($_POST['numero_rua']);
    $complemento        = addslashes($_POST['complemento']);
    $cep                = addslashes($_POST['cep']);
    $id_tipo_usuario    = 2;
    $email              = addslashes($_POST['email']);
    $senha              = md5($_POST['senha']);
    $num_res            = addslashes($_POST['num_res']);
    $num_cel            = addslashes($_POST['num_cel']);

    if (!empty($_POST['nome_medico']) && !empty($_POST['sobrenome_medico']) && !empty($_POST['cpf']) && !empty($_POST['crm']) && !empty($_POST['data_nascimento']) && !empty($_POST['nome_rua']) && !empty($_POST['numero_rua']) && !empty($_POST['complemento']) && !empty($_POST['cep']) && !empty($_POST['email']) && !empty($_POST['senha']) && (!empty($_POST['num_res']) || !empty($_POST['num_cel'])) ) {
        if ($m->cadastrarMedico($nome_medico, $sobrenome_medico, $cpf, $crm, $data_nascimento, $id_especialidade, $nome_rua, $numero_rua, $complemento, $cep, $id_tipo_usuario, $email, $senha, $num_res, $num_cel)) {
            ?>
            <div class="alert alert-success">
                <strong>Parabéns!</strong> Cadastrado com sucesso. <a href="login.php" class="alert-link">Entrar</a>.
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger">
                Email, cpf ou crm inválido(s)!
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
?>

<div class="form-cadastro">
    <h2 class="form-titulo">Médico</h2>
    <form method="POST">
        <input type="text" name="nome_medico" id="nome_medico" placeholder="Nome" class="form-control">
        <input type="text" name="sobrenome_medico" id="sobrenome_medico" placeholder="Sobrenome" class="form-control">
        <input type="text" name="data_nascimento" id="data_nascimento" placeholder="Data Nascimento" class="form-control">
        <input type="text" name="cpf" id="cpf" placeholder="CPF" class="form-control">
        <input type="text" name="crm" id="crm" placeholder="CRM" class="form-control">

        <select name="id_especialidade" id="id_especialidade" class="form-control">
            <option>Especialidade</option>
            <?php foreach ($especialidades as $value): ?> 
                <option value="<?php echo $value['id_especialidade'] ?>"><?php echo $value['nome_especialidade'] ?></option>    
            <?php endforeach; ?>
        </select>

        <input type="text" name="nome_rua" id="nome_rua" placeholder="Rua" class="form-control">
        <input type="text" name="numero_rua" id="numero_rua" placeholder="Número" class="form-control">
        <input type="text" name="complemento" id="complemento" placeholder="Complemento" class="form-control">
        <input type="text" name="cep" id="cep" placeholder="CEP" class="form-control">
        <input type="text" name="num_res" id="num_res" placeholder="Número Residencial" class="form-control">
        <input type="text" name="num_cel" id="num_cel" placeholder="Número Celular" class="form-control">

        <input type="text" name="email" id="email" placeholder="Email" class="form-control">
        <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control">
        <input type="submit" value="Criar conta" class="btn btn-success">
    </form>
</div>

<?php require_once('pages/footer.php'); ?>