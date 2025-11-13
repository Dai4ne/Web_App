<?php 
    session_start();
    include_once('../conexao.php');

    // VERIFICAÇÃO DE ADMIN: Redireciona se não estiver logado ou não for Administrador (tipo != '0')
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== '0') {
        header('Location: ../login.php'); // Redireciona para o login se não for admin (assumindo a estrutura de pastas)
        exit;
    }

    $mensagem = "";

    if(isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];

        // 1. GERA O HASH SEGURO DA SENHA
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Proteção contra SQL Injection
        $email_safe = mysqli_real_escape_string($conexao, $email);
        $nome_safe = mysqli_real_escape_string($conexao, $nome);
        $tipo_safe = mysqli_real_escape_string($conexao, $tipo);
        // Usamos o hash no lugar da senha limpa
        $senha_hash_safe = mysqli_real_escape_string($conexao, $senha_hash); 
        
        // Insere o novo usuário (tipo pode ser 0 ou 1, escolhido no select)
        $sql = "INSERT INTO usuarios(login, senha, nome, tipo, quant_acesso, status, primeiro_acesso) 
                VALUES('$email_safe', '$senha_hash_safe', '$nome_safe', '$tipo_safe', 0, 'A', 1)";
        
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
        <h1>Cadastro de usuário</h1>
        <?php if (!empty($mensagem)): ?>
            <p class="error-message" style="color: green; border-color: #10b981; background-color: #d1fae5;"><?php echo $mensagem; ?></p>
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

            <p>
                <a href="principal_admin.php" class="mudar-de-pagina">Voltar à página principal</a>
            </p>
            
        </form>
    </div>
</body>
</html>