<?php 
    session_start();

    if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        include_once('conexao.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE login = '$email' and senha = '$senha'";
        $resultado = $conexao->query($sql);

        //sem acesso
        if(mysqli_num_rows($resultado) < 1)
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: login.php');
        }
        else 
        {
            // com acesso
            // pega os dadss do usuário que acabaram de ser encontrados/preenchidos
            $usuario = mysqli_fetch_assoc($resultado);
            $quant_acesso_atual = $usuario['quant_acesso'];

            //quantidade de acessos
            $nova_quant_acesso = $quant_acesso_atual + 1;

            //atualização
            $sql_update = "UPDATE usuarios SET quant_acesso = '$nova_quant_acesso' WHERE login = '$email'";

            $conexao->query($sql_update);

            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            header('Location: principal.php');
        }
    }
    
    else 
    {
        header('Location: login.php');
    }

    mysqli_close($conexao);
?>