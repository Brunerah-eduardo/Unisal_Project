<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "unisal_project";

    try{
        $conn = new PDO("mysql:host=$server", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE $database";
        $conn->exec($sql);
        try{
            $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE TABLE users(
                    ID_users INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    codigo INT( 9 ) NOT NULL, 
                    level INT( 11 ) NOT NULL,
                    senha VARCHAR( 255 ) NOT NULL);";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE cursos(
                    ID_cursos INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR( 255 ) NOT NULL);";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE projetos(
                    ID_projetos INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    nome_palestrante VARCHAR( 255 ) NOT NULL,
                    nome_projeto VARCHAR( 255 ) NOT NULL,
                    tempo INT( 5 ) NOT NULL);";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE adm_users(
                    ID_adm_users INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR( 255 ) NOT NULL,
                    ID_FK_users INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_users) REFERENCES users(ID_users));";
            $conn->exec($sql);
            
            $sql = "INSERT INTO users(codigo, level, senha) VALUES(:codigo, :level, :senha);";
            $stmt = $conn->prepare($sql);
            $codigo = 123456789;
            $level = 0;
            $senha = password_hash('admin', PASSWORD_BCRYPT);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':level', $level);
            $stmt->bindParam(':senha', $senha);
            $stmt->execute();
            
            $sql = "INSERT INTO adm_users(nome, ID_FK_users) VALUES(:nome, :ID_FK_users);";
            $stmt = $conn->prepare($sql);
            $nome = "Gustavo";
            $id_fk_users = 1;
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':ID_FK_users', $id_fk_users);
            $stmt->execute();
            
            $sql = "CREATE TABLE prof_users(
                    ID_prof_users INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR( 255 ) NOT NULL,
                    CPF VARCHAR(100),
                    RG VARCHAR(100),
                    RP VARCHAR(100),
                    ID_FK_users INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_users) REFERENCES users(ID_users));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE aluno_users(
                    ID_aluno_users INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR( 255 ) NOT NULL,
                    CPF VARCHAR(100),
                    RG VARCHAR(100),
                    RA VARCHAR(100),
                    ID_FK_users INT( 11 ) NOT NULL,
                    ID_FK_cursos INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_users) REFERENCES users(ID_users),
                    FOREIGN KEY (ID_FK_cursos) REFERENCES cursos(ID_cursos));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE materias(
                    ID_materias INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR( 255 ) NOT NULL,
                    ID_FK_prof_users INT( 11 ) NOT NULL,
                    ID_FK_cursos INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_prof_users) REFERENCES prof_users(ID_prof_users),
                    FOREIGN KEY (ID_FK_cursos) REFERENCES cursos(ID_cursos));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE materias_aluno_users(
                    ID_materias_aluno_users INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    ID_FK_materias INT( 11 ) NOT NULL,
                    ID_FK_aluno_users INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_materias) REFERENCES materias(ID_materias),
                    FOREIGN KEY (ID_FK_aluno_users) REFERENCES aluno_users(ID_aluno_users));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE provas(
                    ID_provas INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR( 255 ) NOT NULL,
                    ID_FK_materias INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_materias) REFERENCES materias(ID_materias));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE notas(
                    ID_notas INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    valor FLOAT(4,2) NOT NULL,
                    ID_FK_materias_aluno_users INT( 11 ) NOT NULL,
                    ID_FK_provas INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_materias_aluno_users) REFERENCES materias_aluno_users(ID_materias_aluno_users),
                    FOREIGN KEY (ID_FK_provas) REFERENCES provas(ID_provas));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE projetos_aluno_users(
                    ID_projetos_aluno_users INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    ID_FK_projetos INT( 11 ) NOT NULL,
                    ID_FK_aluno_users INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_projetos) REFERENCES projetos(ID_projetos),
                    FOREIGN KEY (ID_FK_aluno_users) REFERENCES aluno_users(ID_aluno_users));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE calendarios(
                    ID_calendarios INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    ano INT(4) NOT NULL,
                    ID_FK_cursos INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_cursos) REFERENCES cursos(ID_cursos));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE dias(
                    ID_dias INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    dia_semana VARCHAR(50) NOT NULL,
                    ID_FK_materias INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_materias) REFERENCES materias(ID_materias));";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE semestres(
                    ID_semestres INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    ID_FK_calendarios INT( 11 ) NOT NULL,
                    ID_FK_dias INT( 11 ) NOT NULL,
                    FOREIGN KEY (ID_FK_calendarios) REFERENCES calendarios(ID_calendarios),
                    FOREIGN KEY (ID_FK_dias) REFERENCES dias(ID_dias));";
            $conn->exec($sql);
            
        }catch(PDOException $e){
            echo $sql . "<br>" . $e->getMessage();
        }

    }catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
?>