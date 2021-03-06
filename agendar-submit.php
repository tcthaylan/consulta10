<?php
require_once('config.php');
$c = new Consulta($conn);
if (!empty($_GET['id_medico']) && !empty($_GET['datetime'])) {
    $id_medico = addslashes($_GET['id_medico']);
    $data_inicio = addslashes($_GET['datetime']);
    $data = date('Y-m-d', $data_inicio);

    // Convertendo formato
    echo $data_fim = date('Y-m-d H:i:s', $data_inicio + 60 * 29);
    echo $data_inicio = date('Y-m-d H:i:s', $data_inicio);
    
    if ($c->estaDisponivel($id_medico, $data_inicio, $data_fim)) {
        $c->marcarConsulta($_SESSION['id_usuario'], $id_medico, $data_inicio, $data_fim);
        header('Location: consultas-agendadas.php');
        exit;
    } else {
        header("Location: agendar-tempo.php?date=$data&id_medico=$id_medico&horario=indisponivel");
        exit;
    }
}
?>