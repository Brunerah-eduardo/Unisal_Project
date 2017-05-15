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
            $sql = "CREATE TABLE user(
                    ID_user INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                    codigo VARCHAR( 100 ) NOT NULL, 
                    Email VARCHAR( 250 ) NOT NULL,
                    Senha VARCHAR( 150 ) NOT NULL);";
            $conn->exec($sql);
            echo "Table user created successfully";
            $sql = "CREATE TABLE header(
                    ID_Header INT( 11 ) PRIMARY KEY,
                    Cor_Background VARCHAR( 100 ) NOT NULL, 
                    Cor_Letra VARCHAR( 100 ) NOT NULL,
                    Logo_Path VARCHAR( 255 ) NOT NULL,
                    ID_User INT( 11 ),
                    FOREIGN KEY (ID_User) REFERENCES user(ID_User));";
            $conn->exec($sql);
            echo "Table header created successfully";
            $sql = "CREATE TABLE content(
                    ID_Content INT( 11 ) PRIMARY KEY,
                    Cor_Background VARCHAR( 100 ) NOT NULL, 
                    Cor_Letra VARCHAR( 100 ) NOT NULL,
                    ID_User INT( 11 ),
                    FOREIGN KEY (ID_User) REFERENCES user(ID_User));";
            $conn->exec($sql);
            echo "Table content created successfully";
            $sql = "CREATE TABLE footer(
                    ID_Footer INT( 11 ) PRIMARY KEY,
                    Cor_Background VARCHAR( 100 ) NOT NULL, 
                    Cor_Letra VARCHAR( 100 ) NOT NULL,
                    Copyright VARCHAR( 255 ) NOT NULL,
                    ID_User INT( 11 ),
                    FOREIGN KEY (ID_User) REFERENCES user(ID_User));";
            $conn->exec($sql);
            echo "Table footer created successfully";
        }catch(PDOException $e){
            echo $sql . "<br>" . $e->getMessage();
        }

    }catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
?>