<?php
    session_start();
    include_once('conexao.php');

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Sanitização das entradas (melhorando a segurança da query)
        $email_safe = mysqli_real_escape_string($conexao, $email);
        $senha_safe = mysqli_real_escape_string($conexao, $senha);

        // Consulta o usuário pelo email e senha
        $sql = "SELECT * FROM usuarios WHERE login = '$email_safe' AND senha = '$senha_safe'";
        $result = mysqli_query($conexao, $sql);

        if(mysqli_num_rows($result) < 1) {
            // Login ou senha incorretos
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: login.php'); 
            exit;
        } 
        
        else {
            // Login bem-sucedido
            $user_data = mysqli_fetch_assoc($result);
            
            // ----------------------------------------------------
            // LÓGICA ADICIONADA: Incrementa o contador de acessos
            // ----------------------------------------------------
            $sql_update_acesso = "UPDATE usuarios SET quant_acesso = quant_acesso + 1 WHERE login = '$email_safe'";
            mysqli_query($conexao, $sql_update_acesso);
            // ----------------------------------------------------

            // Armazena dados essenciais na sessão
            $_SESSION['logado'] = true;
            $_SESSION['email'] = $email;
            
            // Verifica a flag de primeiro acesso
            if ($user_data['primeiro_acesso'] == 1) {
                // PRIMEIRO ACESSO: Redireciona para troca de senha
                header('Location: trocar_senha.php');
                exit;
            } else {
                // ACESSOS SEGUINTES: Redireciona para a página principal
                header('Location: principal.php');
                exit;
            }
        }
    } else {
        // Acesso direto sem submissão de formulário
        header('Location: login.php');
        exit;
    }

    mysqli_close($conexao);
?>