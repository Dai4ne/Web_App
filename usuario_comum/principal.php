<?php
    session_start();

    // Verificação de Admin: Redireciona se não estiver logado ou não for Administrador (tipo != '0')
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== '1') {
        header('Location: ../login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_usercomum.css">
    <title>Página Principal</title>
</head>
<body>
    <div class="container">
        <h1>Login feito com sucesso!</h1>

        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['login']); ?>.</p>

        <a href="principal2.php">Clique aqui para ver a futura página principal</a>

        <a href="../logout.php" id="trocar_senha">Sair</a>

        
    </div>
</body>
</html>