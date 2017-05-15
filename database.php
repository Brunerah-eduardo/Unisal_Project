<?php
    $server = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$server;dbname=unisal_project", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        require 'config.php';
        //header('Location: /6%20-%20CMS/');
    }

?>