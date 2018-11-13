<?php require_once('pages/header.php'); ?>
<?php
$p = new Paciente($conn);
$m = new Medico($conn);

if (!empty($_POST['email']) && isset($_POST['email'])) {
    $email = addslashes($_POST['email']);
    $senha = md5($_POST['senha']);

    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
        if ($p->loginPaciente($email, $senha)) {
            header('Location: buscar-medicos.php');
            exit;
        } else if ($m->loginMedico($email, $senha)) {
            header('Location: consultas-agendadas.php');
            exit;
        } else {
            ?>
            <div class="alert alert-danger">
                E-mail e/ou senha incorreto(s)!
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
<div class="form-login">
    <h2 class="form-titulo">Consulta10</h2>
    <form method="POST">
        <input type="text" name="email" id="email" placeholder="E-mail" class="form-control">
        <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control">
        <input type="submit" value="Entrar" class="botao-login">
    </form>
    <a href="#">Esqueceu sua senha?</a>
</div>

<?php require_once('pages/footer.php'); ?>