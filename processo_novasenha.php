<?php
    session_start();

    if(isset($_POST['submit'])) {
        include_once('conexao.php');

        $email = $_POST['email'];
        $nova_senha = $_POST['nova_senha'];
        $confirma_senha = $_POST['confirma_senha'];

        // Se as senhas coincidem
        if ($nova_senha === $confirma_senha) {

            $hash_nova_senha = password_hash($nova_senha, PASSWORD_DEFAULT);

            // Atualiza a senha no banco de dados com o hash
            $stmt = $conexao->prepare("UPDATE usuarios SET senha = ?, primeiro_acesso = 0 WHERE login = ?");
            // Tipos de variáveis: 's' para string
            $stmt->bind_param("ss", $hash_nova_senha, $email);

            if ($stmt->execute()) {


                // Após a troca de senha bem-sucedida, o usuário já está logado.
                header('Location: usuario_comum/principal.php');
                exit;
            } else {
                // Erro ao executar o statement
                echo "Erro ao alterar a senha: " . $stmt->error;
            }

            $stmt->close();

        } else {
            // Senhas não coincidem - o ideal é notificar o erro e redirecionar
            echo "As senhas não coincidem. Tente novamente.";
        }

        mysqli_close($conexao);
    }
    // Se não for submetido, redireciona para login (prevenção de acesso direto)
    else {
        header('Location: login.php');
        exit;
    }
?>