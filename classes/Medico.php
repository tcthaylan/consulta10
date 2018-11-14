<?php
class Medico
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Retorna um array contendo os dados de um médico
    public function getMedico($id_medico)
    {
        $stmt = $this->conn->prepare('SELECT medico.*, especialidade.*, endereco_consultorio.*, telefone_medico.*
        FROM medico
        LEFT JOIN especialidade ON especialidade.id_especialidade = medico.id_especialidade
        LEFT JOIN endereco_consultorio ON endereco_consultorio.id_endereco_consultorio = medico.id_endereco_consultorio
        LEFT JOIN telefone_medico ON telefone_medico.id_telefone_medico = medico.id_telefone_medico
        WHERE id_medico = :id_medico');
        $stmt->bindValue(':id_medico', $id_medico);
        $stmt->execute();
        $array = array();
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    // Retorna um array com dados dos médicos cadastrados.
    public function getMedicos($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;

        /* Filtros desabilitados
        $filtroString = array("1=1");
        if (!empty($filtros['nome_medico'])) {
            $filtroString[] = "nome_medico LIKE '%:nome_medico%'";
        }
        if (!empty($filtros['id_especialidade'])) {
            $filtroString[] = 'especialidade.id_especialidade = :id_especialidade';
        }
        if (!empty($filtros['estado'])) {
            $filtroString[] = "endereco_consultorio.estado LIKE '%:estado%'";
        }
        if (!empty($filtros['cidade'])) {
            $filtroString[] = "endereco_consultorio.cidade LIKE '%:cidade%'";
        }
        */
        $stmt = $this->conn->prepare("SELECT medico.id_medico, medico.nome_medico, medico.sobrenome_medico, especialidade.id_especialidade, especialidade.nome_especialidade, especialidade.desc, endereco_consultorio.estado, endereco_consultorio.cidade 
        FROM medico LEFT JOIN especialidade ON especialidade.id_especialidade = medico.id_especialidade 
        LEFT JOIN endereco_consultorio ON endereco_consultorio.id_endereco_consultorio = medico.id_endereco_consultorio 
        LIMIT $offset, $perPage");

        /* Filtros desabilitados
        if (!empty($filtros['nome_medico'])) {
            $stmt->bindValue(':nome_medico', $filtros['nome_medico']);
        }
        if (!empty($filtros['id_especialidade'])) {
            $stmt->bindValue(':id_especialidade', $filtros['id_especialidade']);
        }
        if (!empty($filtros['estado'])) {
            $stmt->bindValue(':estado', $filtros['estado']);
        }
        if (!empty($filtros['cidade'])) {
            $stmt->bindValue(':cidade', $filtros['cidade']);
        }
        */
        $stmt->execute();
        
        $array = array();
        if ($stmt->rowCount() > 0) {
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $array;
        }
        return $array;
    }

    // Retorna o quantidade de médicos cadastrados.
    public function getTotalMedicos()
    {
        $stmt = $this->conn->query('SELECT COUNT(*) AS qtd_medicos FROM medico');
        $info = $stmt->fetch();
        return $info['qtd_medicos'];
    }

    // Login Médico
    public function loginMedico($email, $senha)
    {
        $stmt = $this->conn->prepare('SELECT * FROM medico WHERE email = :email AND senha = :senha');
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();

        // Verificando se email e senha são válidos.
        if ($stmt->rowCount() > 0) {
            // Email válido
            $info = $stmt->fetch();
            $_SESSION['id_usuario'] = $info['id_medico'];
            $_SESSION['id_tipo_usuario'] = $info['id_tipo_usuario'];
            return true;
        } else {
            // Email inválido
            return false;
        }
    }
    
    // Cadastra um médico.
    public function cadastrarMedico($nome_medico, $sobrenome_medico, $cpf, $crm, $data_nascimento, $id_especialidade, $estado, $cidade, $nome_rua, $numero_rua, $complemento, $cep, $id_tipo_usuario, $email, $senha, $horario_inicio, $horario_fim, $intervalo, $num_res = null, $num_cel = null)
    {   
        // Verifica se algum medico está usando o email.
        $stmt = $this->conn->prepare('SELECT * FROM medico WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            // Verifica se algum paciente está usando o email.
            $stmt = $this->conn->prepare('SELECT * FROM paciente WHERE email = :email');
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                // Email disponível, verificando CPF e CRM.
                if ($this->validaCPF($cpf) == true && $this->validaCRM($crm) == true) {
                    // CPF e CRM válidos...
                    // Cadastrando endereço e salvando id.
                    $id_endereco_consultorio = $this->cadastrarEndereco($estado, $cidade, $nome_rua, $numero_rua, $complemento, $cep);
                    
                    // Cadastrando telefone e salvando id
                    $id_telefone_medico = $this->cadastrarTelefone($num_res, $num_cel);
                    
                    // Cadatrando horário de atendimento e salvando id
                    $id_horario_medico = $this->cadastrarHorario($horario_inicio, $horario_fim, $intervalo);

                    // Cadastrando médico.
                    $stmt = $this->conn->prepare('INSERT INTO medico VALUES (DEFAULT, :nome_medico, :sobrenome_medico, :email, :senha, :cpf, :crm, :data_nascimento, :id_especialidade, :id_endereco_consultorio, :id_tipo_usuario, :id_telefone_medico, :id_horario_medico)');
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
                    $stmt->bindValue(':id_horario_medico', $id_horario_medico);
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
        } else {
            // Email inválido (está em uso).
            return false;
        }
    }

    // Cadastra um endereço e retorna o id_endereco_medico.
    private function cadastrarEndereco($estado, $cidade, $nome_rua, $numero_rua, $complemento, $cep)
    {
        $stmt = $this->conn->prepare('INSERT INTO endereco_consultorio (nome_rua, numero_rua, complemento, cep, estado, cidade) VALUES (:nome_rua, :numero_rua, :complemento, :cep, :estado, :cidade)');
        $stmt->bindValue(':nome_rua', $nome_rua);
        $stmt->bindValue(':numero_rua', $numero_rua);
        $stmt->bindValue(':complemento', $complemento);
        $stmt->bindValue(':cep', $cep);
        $stmt->bindValue(':estado', $estado);
        $stmt->bindValue(':cidade', $cidade);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // Cadastra um telefone e retorna o id_telefone_medico
    private function cadastrarTelefone($num_res, $num_cel)
    {
        $stmt = $this->conn->prepare('INSERT INTO telefone_medico (num_residente, num_celular) VALUES (:num_residente, :num_celular)');
        $stmt->bindValue(':num_residente', $num_res);
        $stmt->bindValue(':num_celular', $num_cel);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // Cadastra um horário de atendimento
    private function cadastrarHorario($horario_inicio, $horario_fim, $intervalo)
    {
        $stmt = $this->conn->prepare('INSERT INTO horario_medico (horario_inicio, horario_fim, intervalo) VALUES (:horario_inicio, :horario_fim, :intervalo)');
        $stmt->bindValue(':horario_inicio', $horario_inicio);
        $stmt->bindValue(':horario_fim', $horario_fim);
        $stmt->bindValue(':intervalo', $intervalo);
        $stmt->execute();
        return $this->conn->lastInsertId();
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

    // Calcula total de páginas
    public function getTotalPaginas($qtd_por_pagina, $total_medicos)
    {
        $qtd_paginas = $total_medicos / $qtd_por_pagina;
        return $qtd_paginas;
    }

    public function editarMedico($id_medico, $id_telefone_medico, $id_endereco_consultorio, $id_horario_medico, $nome_medico, $sobrenome_medico, $data_nascimento, $id_especialidade, $estado, $cidade, $nome_rua, $numero_rua, $complemento, $cep, $horario_inicio, $horario_fim, $intervalo, $num_res = null, $num_cel = null)
    {   
        // Atualizando endereço
        $stmt = $this->conn->prepare('UPDATE endereco_consultorio SET estado = :estado, cidade = :cidade, nome_rua = :nome_rua, complemento = :complemento, cep = :cep WHERE id_endereco_consultorio = :id_endereco_consultorio');
        $stmt->bindValue(':id_endereco_consultorio', $id_endereco_consultorio);
        $stmt->bindValue(':estado', $estado);
        $stmt->bindValue(':cidade', $cidade);
        $stmt->bindValue(':nome_rua', $nome_rua);
        $stmt->bindValue(':complemento', $complemento);
        $stmt->bindValue(':cep', $cep);
        $stmt->execute();

        // Atualizando telefone
        $stmt = $this->conn->prepare('UPDATE telefone_medico SET num_residente = :num_res, num_celular = :num_cel WHERE id_telefone_medico = :id_telefone_medico');
        $stmt->bindValue(':id_telefone_medico', $id_telefone_medico);
        $stmt->bindValue(':num_res', $num_res);
        $stmt->bindValue(':num_cel', $num_cel);
        $stmt->execute();

        // Atualizando horario de atendimento
        $stmt = $this->conn->prepare('UPDATE horario_medico SET horario_inicio = :horario_inicio, horario_fim = :horario_fim, intervalo = :intervalo');
        $stmt->bindValue(':horario_inicio', $horario_inicio);
        $stmt->bindValue(':horario_fim', $horario_fim);
        $stmt->bindValue(':intervalo', $intervalo);
        $stmt->execute();

        // Atualizando dados do médico
        $stmt = $this->conn->prepare('UPDATE medico SET nome_medico = :nome_medico, sobrenome_medico = :sobrenome_medico, data_nascimento = :data_nascimento, id_especialidade = :id_especialidade WHERE id_medico = :id_medico');
        $stmt->bindValue(':id_medico', $id_medico);
        $stmt->bindValue(':nome_medico', $nome_medico);
        $stmt->bindValue(':sobrenome_medico', $sobrenome_medico);
        $stmt->bindValue(':data_nascimento', $data_nascimento);
        $stmt->bindValue(':id_especialidade', $id_especialidade);
        $stmt->execute();

        return true;
    }
}