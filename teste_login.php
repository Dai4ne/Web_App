<?php
    session_start();
    include_once('conexao.php');

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $senha_digitada = $_POST['senha'];

        $email_safe = mysqli_real_escape_string($conexao, $email);

        // Consulta o usuário APENAS pelo email para obter o HASH da senha e os dados

        $sql = "SELECT login, senha, tipo, primeiro_acesso FROM usuarios WHERE login = '$email_safe' LIMIT 1";
        $result = mysqli_query($conexao, $sql);

        if(mysqli_num_rows($result) === 1) {
            $user_data = mysqli_fetch_assoc($result);
            $hash_armazenado = $user_data['senha'];

            // Verificação de senha usando HASH (password_verify)
            if (password_verify($senha_digitada, $hash_armazenado)) {
                // Senha correta: Login bem-sucedido

                // contador de acessos
                $sql_update_acesso = "UPDATE usuarios SET quant_acesso = quant_acesso + 1 WHERE login = '$email_safe'";
                mysqli_query($conexao, $sql_update_acesso);

                // Armazena dados essenciais na sessão
                $_SESSION['logado'] = true;
                $_SESSION['login'] = $email;
                $_SESSION['tipo'] = $user_data['tipo'];

                // Verifica se é primeiro acesso (TINYINT 1 ou 0 no MySQL)
                if ($user_data['primeiro_acesso'] == 1) {
                    // PRIMEIRO ACESSO: Redireciona para troca de senha
                    header('Location: trocar_senha.php');
                    exit;
                } else {
                    // ACESSOS SEGUINTES: Redireciona baseado no tipo de usuário
                    if ($user_data['tipo'] == '0') {
                        // Administrador
                        header('Location: administrador/principal_admin.php');
                    } else {
                        // Usuário Comum
                        header('Location: usuario_comum/principal.php');
                    }
                    exit;
                }
            } else {
                // Senha incorreta após verificar o hash
                $_SESSION['login_erro'] = true;
                header('Location: login.php');
                exit;
            }

        } else {
            // Usuário não encontrado (ou login incorreto)
            $_SESSION['login_erro'] = true;
            header('Location: login.php');
            exit;
        }

    } else {
        // Acesso direto sem submissão de formulário
        header('Location: login.php');
        exit;
    }

    mysqli_close($conexao);
?>