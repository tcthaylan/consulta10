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
        $stmt = $this->conn->prepare('SELECT consulta.id_consulta, consulta.data_inicio, consulta.status, medico.nome_medico, medico.sobrenome_medico, medico.email, especialidade.nome_especialidade, especialidade.desc, endereco_consultorio.nome_rua, endereco_consultorio.numero_rua, endereco_consultorio.cidade, endereco_consultorio.estado
        FROM consulta 
        LEFT JOIN medico ON consulta.id_medico = medico.id_medico
        LEFT JOIN especialidade ON especialidade.id_especialidade = medico.id_especialidade
        LEFT JOIN endereco_consultorio ON endereco_consultorio.id_endereco_consultorio = medico.id_endereco_consultorio
        WHERE id_paciente = :id_paciente AND status = 1;');
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
        $stmt = $this->conn->prepare('SELECT consulta.id_consulta, consulta.data_inicio, consulta.status, paciente.nome_paciente, paciente.sobrenome_paciente, paciente.email 
        FROM consulta
        LEFT JOIN paciente ON consulta.id_paciente = paciente.id_paciente 
        WHERE id_medico = :id_medico AND status = 1');
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

    // Cancela uma consulta
    public function cancelarConsulta($id_consulta)
    {
        $stmt = $this->conn->prepare('UPDATE consulta SET status = 0 WHERE id_consulta = :id_consulta');
        $stmt->bindValue(':id_consulta', $id_consulta);
        $stmt->execute();
    }
}