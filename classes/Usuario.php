<?php
class Usuarios
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Realiza login de médicos e pacientes.
    public function login($email, $senha)
    {
        // Verificando se email e senha são válidos.
        $stmt = $this->conn('SELECT *, 
        (SELECT medico.id_medico, medico.id_tipo_usuario, medico.email FROM medico WHERE medico.email = :email AND medico.senha = :senha ) 
        FROM paciente WHERE email = :email AND senha = :senha');
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();

        if ($stmt->rowCounte() > 0) {
            $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['id_usuario'] = $info[0];
            $_SESSION['id_tipo_usuario'] = $info['id_tipo_usuario'];
            return true;
        } else {
            return false;
        }
    }
}