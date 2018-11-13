<?php
require_once('config.php');
$c = new Consulta($conn);
if (isset($_GET['id_consulta']) && !empty($_GET['id_consulta'])) {
    $id_consulta = addslashes($_GET['id_consulta']);
    $c->cancelarConsulta($id_consulta);
    header('Location: consultas-agendadas.php');
    exit;
} else {
    header('Location: consultas-agendadas.php');
    exit;
}