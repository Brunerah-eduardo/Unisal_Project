<?php

    session_start();

    require 'config/database.php';

    $message = '';

    $user = NULL;

    if(!empty($_POST['codigo']) && !empty($_POST['senha'])){

        $sql = 'SELECT ID_users, codigo, level, senha FROM users WHERE codigo = :codigo';
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codigo', $_POST['codigo']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($result) > 0 && password_verify($_POST['senha'], $result['senha'])){
            $_SESSION['ID_users'] = $result['ID_users'];
            header("Location: /Unisal_Project/");
        }else{
            $message = 'Password/Email wrong';
        }

    }

    if(isset($_SESSION['ID_users'])){
        $sql = 'SELECT codigo, level FROM users WHERE ID_users = :id';
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['ID_users']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($result) > 0){
            $user = $result;
        }
    }

?>

<!DOCTYPE html>
<html>

    <head>
        <title>Unisal_Project</title>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <script type="text/javascript" src="assets/javascript/functions.js"></script>
    </head>

    <body>
        <header><a href="/Unisal_Project/">UNISAL - Lorena 2017</a></header>

        <?php if(!empty($user) && $user['level'] == 0){ ?>

            <br>Welcome 
            <?php echo $user['codigo']; ?>
            ! 
            <br>you're logged
            <a href="config/logout.php">Logout?</a>
            <br>
            <?php //require 'adm_user.php'; ?>

        <?php }else if(!empty($user) && $user['level'] == 1){ ?>

            <br>Welcome 
            <?php echo $user['codigo'] ?>
            ! 
            <br>you're logged
            <a href="config/logout.php">Logout?</a>

            <br>
            <?php //require 'aluno_user.php'; ?>

        <?php }else if(!empty($user) && $user['level'] == 2){ ?>

            <br>Welcome 
            <?php echo $user['codigo'] ?>
            ! 
            <br>you're logged
            <a href="config/logout.php">Logout?</a>

            <br>
            <?php //require 'prof_user.php'; ?>

        <?php }else{ ?>

            <div class="login-container">
            <?php echo $message ?>
            <h1>Login</h1>
                <form action="index.php" method="POST">
                    <input type="text" placeholder="Codigo.." name="codigo">
                    <input type="password" placeholder="Senha.." name="senha">
                    <input type="submit">
                </form>
            </div>    
        <?php } ?>
    </body>

</html>
