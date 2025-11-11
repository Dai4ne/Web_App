<?php
    session_start();

    // Se o email não estiver na sessão, redireciona para o login
    if(!isset($_SESSION['email'])) {
        header('Location: login.php');
        exit;
    }
    
    // Obtém o email do usuário logado para pré-preencher
    $logged_email = $_SESSION['email'];
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

        <form action="processo_novasenha.php" method="POST">
            <!-- Campo de email preenchido e oculto, usando o email da sessão -->
            <input type="email" name="email" value="<?php echo htmlspecialchars($logged_email); ?>" readonly style="display:none;" required>
            <p>Alterando senha para: <strong><?php echo htmlspecialchars($logged_email); ?></strong></p>

            <input type="password" name="nova_senha" placeholder="Nova senha" required>

            <input type="password" name="confirma_senha" placeholder="Confirmar nova senha" required>

            <input type="submit" name="submit" value="Enviar" class="submit">
        </form> <br>

        <!-- Mantemos a opção de voltar, mas o fluxo ideal é alterar a senha -->
        <a href="login.php" id="trocar_senha">Voltar para a página de login</a>
    </div>
</body>
</html>