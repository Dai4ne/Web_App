<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "web_app";

    //Conexão
    $conexao = mysqli_connect ($servername, $username, $password, $database);

    //Verificando se a conexão foi feita 
    if (!$conexao) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    echo "Conexão realizada com sucesso";
?>