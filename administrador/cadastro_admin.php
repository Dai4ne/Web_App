<?php 
    session_start();
    include_once('../conexao.php');

    // VERIFICAÇÃO DE ADMIN: Redireciona se não estiver logado ou não for Administrador (tipo != '0')
    // É necessário ter a variável $_SESSION['tipo'] definida, o que será feito em teste_login.php
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== '0') {
        header('Location: login.php'); // Redireciona para o login se não for admin
        exit;
    }

    $mensagem = "";

    if(isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];

        // Proteção contra SQL Injection
        $email_safe = mysqli_real_escape_string($conexao, $email);
        $senha_safe = mysqli_real_escape_string($conexao, $senha);
        $nome_safe = mysqli_real_escape_string($conexao, $nome);
        $tipo_safe = mysqli_real_escape_string($conexao, $tipo);
        
        // Insere o novo usuário (tipo pode ser 0 ou 1, escolhido no select)
        $sql = "INSERT INTO usuarios(login, senha, nome, tipo, quant_acesso, status, primeiro_acesso) 
                VALUES('$email_safe', '$senha_safe', '$nome_safe', '$tipo_safe', 0, 'A', 1)";
        
        $result = mysqli_query($conexao, $sql);

        if($result) {
            $mensagem = "Usuário **" . htmlspecialchars($nome) . "** cadastrado como " . ($tipo == '0' ? "Administrador" : "Usuário Comum") . " com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar: E-mail já existe ou erro no banco. " . mysqli_error($conexao);
        }

        mysqli_close($conexao);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Cadastro de usuário</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuário (Admin)</h1>
        <?php if (!empty($mensagem)): ?>
            <p style="color: green; font-weight: bold;"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form action="cadastro_admin.php" method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>

            <select name="tipo" required>
                <option disabled selected>Tipo de usuário</option>
                <option value="0">Administrador</option>
                <option value="1">Usuário comum</option>
            </select>
            
            <input type="submit" name="submit" value="Cadastrar" class="submit"> <br>

            <a href="eventos_admin.php">Voltar à página principal do Admin</a>
        </form>
    </div>
</body>
</html>