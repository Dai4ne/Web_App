<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Troca de senha</title>
</head>
<body>
    <div class="container">
        <h1>Troca de senha</h1>

        <form action="processo_novasenha.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="nova_senha" placeholder="Nova senha" required>

            <input type="password" name="confirma_senha" placeholder="Confirmar nova senha" required>

            <input type="submit" name="submit" value="Enviar" class="submit">
        </form> <br>

        <a href="login.php" id="trocar_senha">Voltar para a página de login</a>
    </div>
</body>
</html>