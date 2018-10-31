<?php
class Paciente
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Login Paciente
    public function loginPaciente($email, $senha)
    {
        $stmt = $this->conn->prepare('SELECT * FROM paciente WHERE email = :email AND senha = :senha');
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();

        // Verificando se email e senha são válidos.
        if ($stmt->rowCount() > 0) {
            // Email válido
            $info = $stmt->fetch();
            $_SESSION['id_usuario'] = $info['id_paciente'];
            $_SESSION['id_tipo_usuario'] = $info['id_tipo_usuario'];
            return true;
        } else {
            // Email inválido
            return false;
        }
    }

    // Cadastra Paciente
    public function cadastrarPaciente($nome_paciente, $sobrenome_paciente, $cpf, $data_nascimento, $email, $senha, $id_tipo_usuario)
    {
        // Verifica se algum paciente está usando o email.
        $stmt = $this->conn->prepare('SELECT * FROM paciente WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            // Verifica se algum medico está usando o email.
            $stmt = $this->conn->prepare('SELECT * FROM medico WHERE email = :email');
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                // Email disponível, verificando CPF.
                if ($this->validaCPF($cpf) == true) {
                    // CPF válido, inserindo usuário.
                    $stmt = $this->conn->prepare('INSERT INTO paciente (nome_paciente, sobrenome_paciente, cpf, data_nascimento, email, senha, id_tipo_usuario) 
                    VALUES (:nome_paciente, :sobrenome_paciente, :cpf, :data_nascimento, :email, :senha, :id_tipo_usuario)');
                    $stmt->bindValue(':nome_paciente', $nome_paciente);
                    $stmt->bindValue(':sobrenome_paciente', $sobrenome_paciente);
                    $stmt->bindValue(':cpf', $cpf);
                    $stmt->bindValue(':data_nascimento', $data_nascimento);
                    $stmt->bindValue(':email', $email);
                    $stmt->bindValue(':senha', $senha);
                    $stmt->bindValue(':id_tipo_usuario', $id_tipo_usuario);
                    $stmt->execute();
                    return true;    
                } else {
                    // CPF inválido.
                    return false;
                }
            } else {
                // Email inválido (está em uso).
                return false;
            }
        } else {
            // Email inválido (está em uso).
            return false;
        }
    }

    // Verifica o CPF.
    private function validaCPF($cpf)
    {
        // Verifica se um número foi informado
        if(empty($cpf)) {
            return false;
        }
    
        // Elimina possivel mascara
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
        
        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
            return false;
        // Calcula os digitos verificadores para verificar se o CPF é válido
        } else {   
            
            for ($t = 9; $t < 11; $t++) {
                
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
        }

        // Verifica se o CPF está disponível
        $stmt = $this->conn->prepare('SELECT * FROM paciente WHERE cpf = :cpf');
        $stmt->bindValue(':cpf', $cpf);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // CPF inválido (está em uso).
            return false;
        }

        return true;
    }
}