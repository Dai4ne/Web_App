<?php
    // Inclusão da conexão
    include_once('conexao.php');
    
    // Variável para armazenar mensagens de feedback
    $mensagem = "";

    if(isset($_POST['submit'])) {
        
        $email = $_POST['email'];
        $nova_senha = $_POST['nova_senha'];
        $confirma_senha = $_POST['confirma_senha'];

        // Proteção contra SQL Injection (usando mysqli_real_escape_string)
        $email_safe = mysqli_real_escape_string($conexao, $email);
        $nova_senha_safe = mysqli_real_escape_string($conexao, $nova_senha);

        // Verifica se as senhas coincidem
        if ($nova_senha !== $confirma_senha) {
            $mensagem = "Erro: As novas senhas não coincidem.";
        } else {
            // Verifica se o e-mail existe no banco de dados
            $sql_check_email = "SELECT login FROM usuarios WHERE login = '$email_safe'";
            $result_check = mysqli_query($conexao, $sql_check_email);

            if (mysqli_num_rows($result_check) == 0) {
                $mensagem = "Erro: O e-mail informado não está cadastrado.";
            } else {
                // Atualiza a senha no banco de dados
                // NOTA: Para este fluxo, não alteramos a flag 'primeiro_acesso',
                // pois o usuário pode ter esquecido a senha antes ou depois do primeiro login.
                $sql_update_senha = "UPDATE usuarios SET senha = '$nova_senha_safe' WHERE login = '$email_safe'";
                
                if (mysqli_query($conexao, $sql_update_senha)) {
                    $mensagem = "Sucesso: Senha alterada com sucesso! Você será redirecionado para o login.";
                    // Redireciona após 3 segundos
                    header("Refresh: 3; url=login.php");
                } else {
                    $mensagem = "Erro ao alterar a senha no banco de dados: " . mysqli_error($conexao);
                }
            }
        }
    } else {
        $mensagem = "Acesso inválido. Por favor, utilize o formulário de recuperação.";
    }

    // Fechamento da conexão
    if(isset($conexao)) {
        mysqli_close($conexao);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Processando Recuperação</title>
</head>
<body>
    <div class="container">
        <h1>Resultado da Recuperação</h1>
        <p><?php echo htmlspecialchars($mensagem); ?></p>
        <br>
        <a href="login.php">Voltar para Login</a>
    </div>
</body>
</html>