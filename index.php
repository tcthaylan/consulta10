<?php require_once('pages/header.php'); ?>
<?php
if (!empty($_SESSION['id_usuario']) && $_SESSION['id_tipo_usuario'] == 1) {
    header('Location: buscar-medicos.php');
    exit;
}
if (!empty($_SESSION['id_usuario']) && $_SESSION['id_tipo_usuario'] == 2) {
    header('Location: consultas-agendadas.php');
    exit;
}
?>

<!-- Banner -->
<section class="banner">
    <div class="container">
        <header class="texto-banner">
            <p>WE IMPROVE PEOPLE’S LIVES AND</p>
            <h1>Benefit Society</h1>
            <a href="#" class="botao-banner">Get in touch</a>
        </header>
    </div>
</section>

<!-- Section Cards -->
<section class="cards">
    <div class="row">
        <div class="col-md-4 card-1">
            <h3 class="card-titulo">For Adults</h3>
            <p class="card-subtitulo">You can call our highly experienced clinical team if your child, teenager or family is going through difficulties.</p>
            <ul class="card-lista">
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
            </ul>
        </div>
        <div class="col-md-4 card-2">
            <h3 class="card-titulo">For Children</h3>
            <p class="card-subtitulo">You can call our highly experienced clinical team if your child, teenager or family is going through difficulties.</p>
            <ul class="card-lista">
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
            </ul>
        </div>
        <div class="col-md-4 card-3">
            <h3 class="card-titulo">For Business</h3>
            <p class="card-subtitulo">You can call our highly experienced clinical team if your child, teenager or family is going through difficulties.</p>
            <ul class="card-lista">
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
            </ul>
        </div>
    </div>
</section>

<!-- Especialidades -->
<section class="especialidades">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Especialidades</h2>
                <hr class="traco-especialidades">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <h4>Cardiologia</h4>
                <p>Your health is your most important asset. You should entrust it only to the best professionals.</p>
            </div>
            <div class="col-4">
                <h4>Dermatologia</h4>
                <p>Your health is your most important asset. You should entrust it only to the best professionals.</p>
            </div>
            <div class="col-4">
                <h4>Geriatria</h4>
                <p>Your health is your most important asset. You should entrust it only to the best professionals.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <h4>Infectologia</h4>
                <p>Your health is your most important asset. You should entrust it only to the best professionals.</p>
            </div>
            <div class="col-4">
                <h4>Neurologia</h4>
                <p>Your health is your most important asset. You should entrust it only to the best professionals.</p>
            </div>
            <div class="col-4">
                <h4>Psiquiatria</h4>
                <p>Your health is your most important asset. You should entrust it only to the best professionals.</p>
            </div>
        </div>
    </div>

</section>
<!-- Footer (colocar no footer.php) -->
<footer>
    <div class="container">
        &copy; Cupidatat nulla non pariatur ea.
    </div>
</footer>
<?php require_once('pages/footer.php'); ?>