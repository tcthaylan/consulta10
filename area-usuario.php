<?php require_once('pages/header.php'); ?>

<?php
if (empty($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}
?>

<h1>Área do usuário</h1>

<?php require_once('pages/footer.php'); ?>