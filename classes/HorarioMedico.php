<?php
class HorarioMedico
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Retorna os horarios de trabalho de um médico
    public function getHorarioMedico($id_horario_medico)
    {
        $stmt = $this->conn->prepare('SELECT * FROM horario_medico WHERE id_horario_medico = :id_horario_medico');
        $stmt->bindValue(':id_horario_medico', $id_horario_medico);
        $stmt->execute();
        $array = array();
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetch();
        }
        return $array;
    }
}