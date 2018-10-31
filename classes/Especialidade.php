<?php
class Especialidade
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Retorna um array com todas as especialidades.
    public function getEspecialidades()
    {
        $stmt = $this->conn->query('SELECT * FROM especialidade');
        $array = array();
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll();
        }
        return $array;
    }
}