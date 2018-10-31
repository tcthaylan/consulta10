<?php require_once('pages/header.php'); ?>
<?php 
$p = new Paciente($conn);

if (isset($_POST['nome_paciente']) && !empty($_POST['nome_paciente'])) {
    $nome_paciente      = addslashes($_POST['nome_paciente']);
    $sobrenome_paciente = addslashes($_POST['sobrenome_paciente']);
    $cpf                = addslashes($_POST['cpf']);
    $data_nascimento    = addslashes($_POST['data_nascimento']);
    $email              = addslashes($_POST['email']);
    $senha              = md5($_POST['senha']);
    $id_tipo_usuario    = 1;

    if (!empty($_POST['nome_paciente']) && !empty($_POST['sobrenome_paciente']) && !empty($_POST['cpf']) && !empty($_POST['data_nascimento']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
        if ($p->cadastrarPaciente($nome_paciente, $sobrenome_paciente, $cpf, $data_nascimento, $email, $senha, $id_tipo_usuario)) {
            ?>
            <div class="alert alert-success">
                <strong>Parabéns!</strong> Cadastrado com sucesso.<a href="login.php" class="alert-link">entrar</a>.
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger">
                Email e/ou cpf inválido(s)!
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
    <h2 class="form-titulo">Eiusmod consequat nisi minim dolore.</h2>
    <form method="POST">
        <input type="text" name="nome_paciente" id="nome_paciente" placeholder="Nome" class="form-control">
        <input type="text" name="sobrenome_paciente" id="sobrenome_paciente" placeholder="Sobrenome" class="form-control">
        <input type="text" name="cpf" id="cpf" placeholder="CPF" class="form-control">
        <input type="text" name="data_nascimento" id="data_nascimento" placeholder="Data Nascimento" class="form-control">
        <input type="text" name="email" id="email" placeholder="Email" class="form-control">
        <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control">

        <input type="submit" value="Criar conta" class="btn btn-success">
    </form>
</div>

<?php require_once('pages/footer.php'); ?>