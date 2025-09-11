<?php
    if(isset($_POST['submit'])) {
        include_once('conexao.php');

        $email = $_POST['email'];
        $nova_senha = $_POST['nova_senha'];
        $confirma_senha = $_POST['confirma_senha'];

        //se as senhas coincidem
        if ($nova_senha === $confirma_senha) {
            // cria a query de atualização se as senhas estiverem iguais 
            $sql_update_senha = "UPDATE usuarios SET senha = '$nova_senha' WHERE login = '$email'";
            
            if ($conexao->query($sql_update_senha) === TRUE) {
                echo "Senha alterada com sucesso";
                
                
            } else {
                echo "Erro ao alterar a senha: " . $conexao->error;
            }
        } else {
            echo "As senhas não coincidem. Tente novamente.";

            // header('Location: trocar_senha.php');
        }
    }

    mysqli_close($conexao);
?>