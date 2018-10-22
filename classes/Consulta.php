<?php
class Consulta
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Busca consultas de um determinado paciente
    public function getConsultasPaciente($id_paciente)
    {
        $stmt = $this->conn('SELECT * FROM consulta WHERE id_paciente = :id_paciente');
        $stmt->bindValue(':id_paciente', $id_paciente);
        $stmt->execute();
        $array = array();
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $array;
        }
        return $array;
    }

    // Busca consultas de um determinado médico
    public function getConsultasMedico($id_medico)
    {
        $stmt = $this->conn('SELECT * FROM consulta WHERE id_medico = :id_medico');
        $stmt->bindValue(':id_medico', $id_medico);
        $stmt->execute();
        $array = array();
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $array;
        }
        return $array;
    }
}