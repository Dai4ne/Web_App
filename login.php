<?php
    session_start();
?>
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

        <div class="filho">
            <?php
            // Bloco PHP para checar a variável de erro
            if (isset($_SESSION['login_erro']) && $_SESSION['login_erro'] == true) {
                echo '<div class="error-message">Usuário ou senha incorretos.</div>';
                // Limpa a variável de sessão
                unset($_SESSION['login_erro']);
            }
            ?>

            <form action="teste_login.php" method="POST">

                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="senha" placeholder="Senha" required>

                <p>
                    <a href="recuperar_senha.php" class="mudar-de-pagina" id="trocar-senha">Esqueceu a senha?</a>
                </p>


                <input type="submit" name="submit" value="Entrar" class="submit">

                <p>
                    <a href="usuario_comum/cadastro_comum.php" class="mudar-de-pagina">Realizar cadastro</a>
                </p>


            </form>
        </div>

    </div>


</body>
</html>