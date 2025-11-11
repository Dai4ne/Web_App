<?php
    session_start();

    // Verifica se o usuário está logado
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        header('Location: login.php');
        exit;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Página Principal</title>
</head>
<body>
    <div class="container">
        <h1>Login feito com sucesso!</h1>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['email']); ?>. Você está na página principal.</p>
        <a href="logout.php" id="trocar_senha">Sair</a>
    </div>
</body>
</html>