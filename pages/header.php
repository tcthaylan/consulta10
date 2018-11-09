<?php require('config.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta 10</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Libre+Baskerville|Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Meu CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar --> 
    <header class="header-nav">
        <div class="container">
            <div class="container-logo-nav">
                <div class="logo">
                    <a href="index.php">Consulta10</a>
                </div>
                <nav class="nav-usuario">
                    <?php if (!empty($_SESSION['id_usuario']) && $_SESSION['id_tipo_usuario'] == 1): ?>
                        <ul>
                            <li>
                                <a href="area-paciente.php">Buscar médicos</a>
                            </li>
                            <li>
                                <a href="consultas-agendadas-paciente.php">Consultas agendadas</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </nav>
            </div>
            <div class="botoes-header">
                <?php if (empty($_SESSION['id_usuario'])): ?>
                    <a href="login.php" class="botao-entrar">Entrar</a>
                    <a href="cadastrar.php" class="botao-cadastrar">Criar conta</a>
                <?php else: ?>
                    <a href="sair.php" class="botao-sair">Sair</a>
                <?php endif; ?>
            </div>
        </div>
    </header>