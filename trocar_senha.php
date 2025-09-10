<?php 
    include_once('conexao.php');

    if (!isset($_SESSION['email'])) {
    die("Acesso negado. Faça login.");
}
?>


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

        <form action="processo_novasenha" method="POST">

            <input type="password" name="nova_senha" placeholder="Nova Senha" required>

            <input type="password" name="confirma_senha" placeholder="Confirmar Nova Senha" required>

            <input type="submit" name="submit" value="Logar" class="submit"> <br>


        </form>
    </div>
</body>
</html>