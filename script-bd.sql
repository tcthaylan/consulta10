CREATE SCHEMA IF NOT EXISTS `consulta10` ;
USE `consulta10` ;

-- -----------------------------------------------------
-- Table `consulta10`.`Tipo_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`tipo_usuario` (
  `id_tipo_usuario` INT NOT NULL AUTO_INCREMENT,
  `nome_tipo` VARCHAR(100) NOT NULL UNIQUE,
  PRIMARY KEY (`id_tipo_usuario`)
);

-- -----------------------------------------------------
-- Table `consulta10`.`Especialidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`especialidade` (
  `id_especialidade` INT NOT NULL AUTO_INCREMENT,
  `nome_especialidade` VARCHAR(100) NOT NULL UNIQUE,
  `desc` TEXT NULL,
  PRIMARY KEY (`id_especialidade`)
);

-- -----------------------------------------------------
-- Table `consulta10`.`Endereco_consultorio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`endereco_consultorio` (
  `id_endereco_consultorio` INT NOT NULL AUTO_INCREMENT,
  `nome_rua` VARCHAR(100) NOT NULL,
  `numero_rua` INT NOT NULL,
  `complemento` VARCHAR(45) NULL,
  `cep` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(30) NOT NULL,
  `cidade` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_endereco_consultorio`)
);

-- -----------------------------------------------------
-- Table `consulta10`.`Telefone_medico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`telefone_medico` (
  `id_telefone_medico` INT NOT NULL AUTO_INCREMENT,
  `num_residente` VARCHAR(45) NULL,
  `num_celular` VARCHAR(45) NULL,
  PRIMARY KEY (`id_telefone_medico`)
);

-- -----------------------------------------------------
-- Table `consulta10`.`Medico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`medico` (
  `id_medico` INT NOT NULL AUTO_INCREMENT,
  `nome_medico` VARCHAR(100) NOT NULL,
  `sobrenome_medico` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(32) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL UNIQUE,
  `crm` VARCHAR(45) NOT NULL UNIQUE,
  `data_nascimento` DATE NOT NULL,
  `id_especialidade` INT NOT NULL,
  `id_endereco_consultorio` INT NOT NULL,
  `id_tipo_usuario` INT NOT NULL,
  `id_telefone_medico` INT NOT NULL,
  PRIMARY KEY (`id_medico`),
  CONSTRAINT foreign key fk_Medico_id_especialidade (id_especialidade)	references especialidade(id_especialidade),
  CONSTRAINT foreign key fk_Medico_id_endereco_consultorio (id_endereco_consultorio)	references endereco_consultorio(id_endereco_consultorio),
  CONSTRAINT foreign key fk_Medico_id_tipo_usuario (id_tipo_usuario)	references tipo_usuario(id_tipo_usuario),
  CONSTRAINT foreign key fk_Medico_id_telefone_medico (id_telefone_medico)	references telefone_medico(id_telefone_medico)
);

-- -----------------------------------------------------
-- Table `consulta10`.`Medico_token`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`medico_token` (
  `id_medico_token` INT NOT NULL AUTO_INCREMENT,
  `hash` VARCHAR(32) NOT NULL,
  `used` TINYINT NOT NULL DEFAULT 0,
  `expirado_em` DATETIME NOT NULL,
  `id_medico` INT NOT NULL,
  PRIMARY KEY (`id_medico_token`),
  CONSTRAINT foreign key fk_Medico_token_id_medico (id_medico)	references medico(id_medico)
);

-- -----------------------------------------------------
-- Table `consulta10`.`Paciente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`paciente` (
  `id_paciente` INT NOT NULL AUTO_INCREMENT,
  `nome_paciente` VARCHAR(100) NOT NULL,
  `sobrenome_paciente` VARCHAR(100) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL UNIQUE,
  `data_nascimento` DATE NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(32) NOT NULL,
  `id_tipo_usuario` INT NOT NULL,
  PRIMARY KEY (`id_paciente`),
  CONSTRAINT foreign key fk_Paciente_id_tipo_usuario (id_tipo_usuario)	references Tipo_usuario(id_tipo_usuario)
);

-- -----------------------------------------------------
-- Table `consulta10`.`Paciente_token`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`paciente_token` (
  `id_token` INT NOT NULL AUTO_INCREMENT,
  `hash` VARCHAR(32) NOT NULL,
  `used` TINYINT NOT NULL DEFAULT 0,
  `expirado_em` DATETIME NOT NULL,
  `id_paciente` INT NOT NULL,
  PRIMARY KEY (`id_token`),
  CONSTRAINT foreign key fk_Paciente_token_id_paciente (id_paciente)	references paciente(id_paciente)
);

-- -----------------------------------------------------
-- Table `consulta10`.`Consulta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `consulta10`.`consulta` (
  `id_consulta` INT NOT NULL AUTO_INCREMENT,
  `id_paciente` INT NOT NULL,
  `id_medico` INT NOT NULL,
  `data_inicio` DATETIME NOT NULL,
  `data_fim` DATETIME NOT NULL,
  `status` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_consulta`),
  CONSTRAINT foreign key fk_Consulta_id_paciente (id_paciente)	references paciente(id_paciente),
  CONSTRAINT foreign key fk_Consulta_id_medico (id_medico)	references medico(id_medico)
);

INSERT INTO tipo_usuario VALUES 
(DEFAULT, 'Paciente'),
(DEFAULT, 'Médico');

CREATE TABLE horario_medico(
	id_horario_medico int primary key auto_increment,
  horario_inicio time not null,
  horario_fim time not null,
  intervalo time not null
);

ALTER TABLE medico
add column id_horario_medico int;

ALTER TABLE medico
add FOREIGN KEY fk_Medico_id_horario_medico (id_horario_medico) REFERENCES horario_medico(id_horario_medico);

alter table medico 
modify cpf varchar(14) not null unique;