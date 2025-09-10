<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
    content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <form action="teste_login.php" method="POST">

            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <a href="trocar_senha.php" id="trocar-senha">Esqueceu a senha?</a>
            
            <input type="submit" name="submit" value="Logar" class="submit"> <br>

            <a href="cadastro.php">Realizar cadastro</a>

        </form>

    </div>


</body>
</html>