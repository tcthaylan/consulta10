<?php
session_start();
require('config.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta 10</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Libre+Baskerville|Montserrat" rel="stylesheet">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Meu CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar --> 
    <header class="header-nav">
        <div class="container">
            <div class="logo">
                Consulta10
            </div>
            <div class="botoes-header">
                <a href="#" class="botao-entrar">Entrar</a>
                <a href="#" class="botao-cadastrar">Criar conta</a>
            </div>
        </div>
    </header>
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
        <div class="card-1">
            <h3 class="card-titulo">For Adults</h3>
            <p class="card-subtitulo">You can call our highly experienced clinical team if your child, teenager or family is going through difficulties.</p>
            <ul class="card-lista">
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
            </ul>
        </div>
        <div class="card-2">
            <h3 class="card-titulo">For Children</h3>
            <p class="card-subtitulo">You can call our highly experienced clinical team if your child, teenager or family is going through difficulties.</p>
            <ul class="card-lista">
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
            </ul>
        </div>
        <div class="card-3">
            <h3 class="card-titulo">For Business</h3>
            <p class="card-subtitulo">You can call our highly experienced clinical team if your child, teenager or family is going through difficulties.</p>
            <ul class="card-lista">
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
                <li>DEPRESSION</li>
            </ul>
        </div>
    </section>
    <!-- Jquery, Bootstrap.js e meu js -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>