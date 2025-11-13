<?php
    session_start();

    // Verificação de Admin: Redireciona se não estiver logado ou não for Administrador (tipo != '0')
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== '0') {
        header('Location: ../login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Painel do Administrador</title>
</head>
<body>
    <div class="container">
        <h1>Painel do Administrador</h1>
        <p>Bem-vindo, Administrador <?php echo htmlspecialchars($_SESSION['login']); ?>.</p>
        
        <p>Você pode gerenciar as reservas e os usuários.</p>
        
        <a href="cadastro_admin.php" id="trocar_senha" style="background-color: green; margin-bottom: 20px;">
            Cadastrar novo usuário
        </a>

        <a href="principal2_admin.php">Página principal de evento</a>

        <a href="../logout.php" id="trocar_senha">Sair</a>
        
    </div>
</body>
</html>