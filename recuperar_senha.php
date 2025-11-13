<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Recuperar Senha</title>
</head>
<body>
    <div class="container">
        <h1>Recuperar Senha</h1>
        <p>Informe seu e-mail e a nova senha.</p>

        <form action="processo_recuperacao.php" method="POST">
            
            <input type="email" name="email" placeholder="Seu e-mail de cadastro" required>

            <input type="password" name="nova_senha" placeholder="Nova senha" required>

            <input type="password" name="confirma_senha" placeholder="Confirmar nova senha" required>

            <input type="submit" name="submit" value="Alterar senha" class="submit">
        </form> <br>

        <p>
            <a href="login.php">Voltar para a página de login</a>
        </p>
        
    </div>
</body>
</html>