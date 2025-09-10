<?php 
    session_start();

    if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        //acessa
        include_once('conexao.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        //Teste para ver se o POST está funcionando
        //print_r('Email: ' . $email); 
        //print_r('Senha: ' . $senha); 

        $sql = "SELECT * FROM usuarios WHERE login = '$email' and senha = '$senha'";

        $resultado = $conexao->query($sql);

        //Teste para ver se a query e o $sql estão funcionando
        //print_r($resultado);
        //print_r($sql);

        if(mysqli_num_rows($resultado) < 1)
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']); //exclui as variáveis inválidas que tenham senha ou email
            header('Location: login.php');
        }

        else {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;

            header('Location: principal.php');
        }
    }

    else {
        //não acessa
        header('Location: login.php');
    }
?>

