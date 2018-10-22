<?php
class Medico
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Retorna um array com todos os médicos cadastrados.
    // Revisar query, está com erro!!!
    public function getMedicos()
    {
        $stmt = $this->conn->query('SELECT nome_medico, sobrenome_medico, email, 
        (SELECT especialidade.nome_especialidade FROM especialidade),
        (SELECT endereco_consultorio.nome_rua, endereco_consultorio.numero_rua, endereco_consultorio.cep FROM endereco_consultorio),
        (SELECT telefone_medico.num_residente, telefone_medico.num_celular FROM telefone_medico) 
        FROM medico');
        $array = array();
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $array;
        }
        return $array;
    }

    // Cadastra um médico.
    public function cadastrar($nome_medico, $sobrenome_medico, $cpf, $crm, $data_nascimento, $id_especialidade, $nome_rua, $numero_rua, $complemento, $cep, $id_tipo_usuario, $email, $senha, $num_res = null, $num_cel = null)
    {
        // Verifica se o email é válido (não está em uso).
        $stmt = $this->conn->prepare('SELECT *, (SELECT paciente.email FROM paciente WHERE paciente.email = :email) FROM medico WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            // Email válido, verificando CPF e CRM.
            if ($this->validaCPF($cpf) == true && $this->validaCRM($crm) == true) {
                // CPF e CRM válidos...
                // Cadastrando endereço e salvando id.
                $id_endereco_consultorio = $this->cadastrarEndereco($nome_rua, $numero_rua, $complemento, $cep);

                // Cadastrando telefone e salvando id
                $id_telefone_medico = $this->cadastrarTelefone($num_res, $num_cel);

                // Cadastrando médico.
                $stmt = $this->conn->prepare('INSERT INTO medico VALUES (DEFAULT, :nome_medico, :sobrenome_medico, :cpf, :crm, :data_nascimento, :id_especialidade, :id_endereco_consultorio, :id_tipo_usuario, :id_telefone_medico, :email, :senha)');
                $stmt->bindValue(':nome_medico', $nome_medico);
                $stmt->bindValue(':sobrenome_medico', $sobrenome_medico);
                $stmt->bindValue(':cpf', $cpf);
                $stmt->bindValue(':crm', $crm);
                $stmt->bindValue(':data_nascimento', $data_nascimento);
                $stmt->bindValue(':id_especialidade', $id_especialidade);
                $stmt->bindValue(':id_endereco_consultorio', $id_endereco_consultorio);
                $stmt->bindValue(':id_tipo_usuario', $id_tipo_usuario);
                $stmt->bindValue(':id_telefone_medico', $id_telefone_medico);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':senha', $senha);
                $stmt->execute();
                return true;
            } else {
                // CPF e/ou CRM inválido(s).
                return false;
            }

        } else {
            // Email inválido (está em uso).
            return false;
        }
    }

    // Cadastra um endereço e retorna o id_endereco_medico.
    private function cadastrarEndereco($nome_rua, $numero_rua, $complemento, $cep)
    {
        $stmt = $this->conn->prepare('INSERT INTO endereco_consultorio (nome_rua, numero_rua, complemento, cep) VALUES (:nome_rua, :numero_rua, :complemento, :cep)');
        $stmt->bindValue(':nome_rua', $nome_rua);
        $stmt->bindValue(':numero_rua', $numero_rua);
        $stmt->bindValue(':complemento', $complemento);
        $stmt->bindValue(':cep', $cep);
        $stmt->execute();
        return $this->conn->lastIdInsert();
    }

    // Cadastra um telefone e retorna o id_telefone_medico
    private function cadastrarTelefone($num_res, $num_cel)
    {
        $stmt = $this->conn->prepare('INSERT INTO telefone_medico (num_residente, num_celular) VALUES (:num_residente, :num_celular)');
        $stmt->bindValue(':num_residente', $num_res);
        $stmt->bindValue(':num_celular', $num_cel);
        $stmt->execute();
        return $this->conn->lastIdInsert();
    }

    // Verifica CRM
    private function validaCRM($crm)
    {
        $stmt = $this->conn->prepare('SELECT * FROM medico WHERE crm = :crm');
        $stmt->bindValue(':crm', $crm);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            // CRM válido.
            return true;
        } else {
            // CRM inválido (está em uso).
            return false;
        }
    }

    // Verifica CPF
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
        $stmt = $this->conn->prepare('SELECT * FROM medico WHERE cpf = :cpf');
        $stmt->bindValue(':cpf', $cpf);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // CPF inválido (está em uso).
            return false;
        }

        return true;
    }
}