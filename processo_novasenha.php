<?php
    session_start();
    
    if(isset($_POST['submit'])) {
        include_once('conexao.php');

        $email = $_POST['email'];
        $nova_senha = $_POST['nova_senha'];
        $confirma_senha = $_POST['confirma_senha'];

        // Se as senhas coincidem
        if ($nova_senha === $confirma_senha) {
            // 1. Atualiza a senha
            $sql_update_senha = "UPDATE usuarios SET senha = '$nova_senha' WHERE login = '$email'";
            
            if ($conexao->query($sql_update_senha) === TRUE) {
                
                // 2. IMPORTANTE: Limpa a flag de primeiro acesso
                $sql_clear_flag = "UPDATE usuarios SET primeiro_acesso = 0 WHERE login = '$email'";
                $conexao->query($sql_clear_flag); // Executa, mesmo que não seja verificado aqui

                echo "Senha alterada com sucesso. Redirecionando...";
                
                // 3. Redireciona para a página principal após a alteração
                header('Location: usuario_comum/principal.php');
                exit;
            } else {
                echo "Erro ao alterar a senha: " . $conexao->error;
            }
        } else {
            echo "As senhas não coincidem. Tente novamente.";
            // O ideal seria redirecionar de volta para trocar_senha.php
        }
    }

    // A chamada a mysqli_close precisa estar fora do if(isset) ou dentro de um bloco 
    // que garanta que $conexao foi definida e aberta. 
    if(isset($conexao)) {
        mysqli_close($conexao);
    }
?>