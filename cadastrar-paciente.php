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
                <strong>Parabéns!</strong> Cadastrado com sucesso. <a href="login.php" class="alert-link">Entrar</a>.
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

<div class="container">
    <div class="row">
        <div class="col-12 cabecalho-cadatrar">
            <h2>Cadastro Paciente</h2>
            <p class="lead">Enim elit sint deserunt officia est.</p>
            <hr>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="form-cadastro">
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="nome_paciente">Nome</label>
                            <input type="text" name="nome_paciente" id="nome_paciente" placeholder="Nome" class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label for="sobrenome_paciente">Sobrenome</label>
                            <input type="text" name="sobrenome_paciente" id="sobrenome_paciente" placeholder="Sobrenome" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data_nascimento">Data Nascimento</label>
                        <input type="text" name="data_nascimento" id="data_nascimento" placeholder="dd/mm/aaaa" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cpf">Cpf</label>
                        <input type="text" name="cpf" id="cpf" placeholder="Cpf" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control">
                    </div>                
                    <input type="submit" value="Criar conta" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('pages/footer.php'); ?>