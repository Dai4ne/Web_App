<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
    content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>

        <input class="campos" type="text" placeholder="Nome">

        <input class="campos" type="text" placeholder="E-mail">

        <input class="campos" type="password" placeholder="Senha">

        <select name="tipo">
            <option class="campos" disabled selected >Tipo de usuário</option>
            <option value="0">Administrador</option>
            <option value="1">Usuário comum</option>
        </select>
        
        <button>Enviar</button>
    </div>
</body>
</html>