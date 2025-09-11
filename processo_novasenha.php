<?php
    if(isset($_POST['submit'])) {
        include_once('conexao.php');

        $email = $_POST['email'];
        $nova_senha = $_POST['nova_senha'];
        $confirma_senha = $_POST['confirma_senha'];

        // 1. Verifica se as senhas coincidem
        if ($nova_senha === $confirma_senha) {
            // 2. Se sim, cria a query de atualização
            $sql_update_senha = "UPDATE usuarios SET senha = '$nova_senha' WHERE login = '$email'";
            
            // 3. Executa a query
            if ($conexao->query($sql_update_senha) === TRUE) {
                echo "Senha alterada com sucesso";
                // Opcional: redirecionar para a página de login
                // header('Location: login.php');
            } else {
                echo "Erro ao alterar a senha: " . $conexao->error;
            }
        } else {
            echo "As senhas não coincidem. Tente novamente.";
            // Opcional: redirecionar de volta para a página de troca de senha
            // header('Location: trocar_senha.php');
        }
    }

    mysqli_close($conexao);
?>