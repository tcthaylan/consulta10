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

    // Registra uma consulta 
    public function estaDisponivel($id_medico, $data_inicio, $data_fim)
    {
        $stmt = $this->conn->prepare('SELECT * FROM consulta WHERE id_medico = :id_medico AND status = 1 AND (data_inicio <= :data_fim AND data_fim >= :data_inicio)');
        $stmt->bindValue(':id_medico', $id_medico);
        $stmt->bindValue(':data_inicio', $data_inicio);
        $stmt->bindValue(':data_fim', $data_fim);
        $stmt->execute();

        if ($stmt->rowCount() == 0){
            return true;
        } else {
            return false;
        }
    }

    // Marca uma consulta
    public function marcarConsulta($id_paciente, $id_medico, $data_inicio, $data_fim)
    {
        $stmt = $this->conn->prepare('INSERT INTO consulta VALUES (DEFAULT, :id_paciente, :id_medico, :data_inicio, :data_fim, DEFAULT)');
        $stmt->bindValue(':id_paciente', $id_paciente);
        $stmt->bindValue(':id_medico', $id_medico);
        $stmt->bindValue(':data_inicio', $data_inicio);
        $stmt->bindValue(':data_fim', $data_fim);
        $stmt->execute();
    }
}