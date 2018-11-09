<?php
class EnderecoConsultorio
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Retorna um endereço com base no id
    public function getEnderecoMedico($id_endereco_consultorio)
    {
        $stmt = $this->conn->prepare('SELECT * FROM endereco_consultorio WHERE id_endereco_consultorio = :id_endereco_consultorio');
        $stmt->bindValue(':id_endereco_consultorio', $id_endereco_consultorio);
        $stmt->execute();
        $array = array();
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetch();
        }
        return $array;
    }
}