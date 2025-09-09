<?php 
    if(isset($_POST['submit']))
    {

        include_once('conexao.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];

        $result = mysqli_query($conexao, "INSERT INTO usuarios(login, senha, nome, tipo) VALUES('$email', '$senha', '$nome', '$tipo')");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
    content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>

        <form action="cadastro.php" method="POST">
            <input type="text" name="nome" placeholder="Nome" required>

            <input type="text" name="email" placeholder="E-mail" required>

            <input type="password" name="senha" placeholder="Senha" required>

            <select name="tipo" required>
                <option disabled selected>Tipo de usuário</option>
                <option value="0">Administrador</option>
                <option value="1">Usuário comum</option>
            </select>
            
            <input type="submit" name="submit" value="Cadastrar" class="submit">
        </form>
    </div>

</body>
</html>