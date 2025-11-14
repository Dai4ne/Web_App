<?php 
    //session_start(); 

    if(isset($_POST['submit']))
    {
        include_once('../conexao.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $tipo = '1'; // Tipo fixo: Usuário Comum

        // 1. GERA O HASH SEGURO DA SENHA
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Proteção contra SQL Injection
        $email_safe = mysqli_real_escape_string($conexao, $email);
        $nome_safe = mysqli_real_escape_string($conexao, $nome);

        $senha_hash_safe = mysqli_real_escape_string($conexao, $senha_hash); 
        
        // Insere o novo usuário, usando o hash da senha
        $sql = "INSERT INTO usuarios(login, senha, nome, tipo, quant_acesso, status, primeiro_acesso) 
                VALUES('$email_safe', '$senha_hash_safe', '$nome_safe', '$tipo', 0, 'A', 1)";
        
        $result = mysqli_query($conexao, $sql);

        if($result) {
            header('Location: ../login.php?cadastro=sucesso');
            exit;
        } else {
            // Em caso de erro, exibe mensagem (pode ser problema de e-mail duplicado)
            echo "<script>alert('Erro ao cadastrar: E-mail já existe ou erro no banco.');</script>";
        }

        mysqli_close($conexao);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>

        <form action="cadastro_comum.php" method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            
            <input type="submit" name="submit" value="Cadastrar" class="submit"> 

            <p>
               <a href="../login.php" class="mudar-de-pagina">Voltar à página de login</a> 
            </p>
            
        </form>
    </div>
</body>
</html>