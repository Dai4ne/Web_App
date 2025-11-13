<?php 
    if(isset($_POST['submit']))
    {
        include_once('../conexao.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $tipo = '1'; // Tipo fixo: Usuário Comum

        // Proteção contra SQL Injection
        $email_safe = mysqli_real_escape_string($conexao, $email);
        $senha_safe = mysqli_real_escape_string($conexao, $senha);
        $nome_safe = mysqli_real_escape_string($conexao, $nome);
        
        // Insere o novo usuário, definindo 'tipo' como '1' (Comum) e 'primeiro_acesso' como 1
        $sql = "INSERT INTO usuarios(login, senha, nome, tipo, quant_acesso, status, primeiro_acesso) 
                VALUES('$email_safe', '$senha_safe', '$nome_safe', '$tipo', 0, 'A', 1)";
        
        $result = mysqli_query($conexao, $sql);

        if($result) {
            echo "<script>alert('Cadastro realizado com sucesso! Faça seu login.'); window.location.href='../login.php';</script>";
        } else {
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
    <link rel="stylesheet" href="style_usercomum.css">
    <title>Cadastro Comum</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuário Comum</h1>

        <form action="cadastro_comum.php" method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            
            <input type="submit" name="submit" value="Cadastrar" class="submit"> <br>

            <a href="../login.php">Voltar à página de login</a>
        </form>
    </div>
</body>
</html>