<?php 
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

        $result = $conexao->query($sql);

    }

    else {
        //não acessa
        header('Location: login.php');
    }
?>

