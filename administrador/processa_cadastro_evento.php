<?php
    session_start();

    // Verificação de Admin
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== '0') {
        header('Location: ../login.php');
        exit;
    }

    // Inclui a conexão com o banco de dados
    include('../conexao.php');

    // Verifica se os dados do formulário foram enviados
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Recebe e sanitiza os dados
        $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
        
        $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
        
        $local = mysqli_real_escape_string($conexao, $_POST['local']);
        
        $data = mysqli_real_escape_string($conexao, $_POST['data']);
        
        $hora = mysqli_real_escape_string($conexao, $_POST['hora']);

        // Capacidade pode ser NULL, mas no formulário foi definido como min=1
        $capacidade = isset($_POST['capacidade']) && is_numeric($_POST['capacidade']) ? (int)$_POST['capacidade'] : null;

        $imagem = mysqli_real_escape_string($conexao, $_POST['imagem']);



        // 2. Prepara a query SQL
        $sql = "INSERT INTO eventos (nome, descricao, local, data, hora, capacidade, imagem) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // 3. Prepara a declaração (Prepared Statement para segurança)
        $stmt = mysqli_prepare($conexao, $sql);

        if ($stmt) {
            // "s" para string, "i" para integer (capacidade), "s" para string
            $tipos = "sssssis"; 
            
            // Tratamento de NULL para 'capacidade' para bind_param, pois ele exige variáveis
            // Se $capacidade for null, passamos a variável para bind_param, mas o tipo é 'i'
            // O MySQL pode aceitar um NULL em um INT se for NULLABLE
            $capacidade_bind = $capacidade;
            
            // 4. Associa os parâmetros e executa
            mysqli_stmt_bind_param($stmt, $tipos, $nome, $descricao, $local, $data, $hora, $capacidade_bind, $imagem);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Evento cadastrado com sucesso!'); window.location.href='principal2_admin.php';</script>";
            } else {
                echo "<script>alert('❌ Erro ao cadastrar evento: " . mysqli_stmt_error($stmt) . "'); window.location.href='principal2_admin.php';</script>";
            }

            // 5. Fecha a declaração
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('❌ Erro na preparação da consulta: " . mysqli_error($conexao) . "'); window.location.href='principal2_admin.php';</script>";
        }

        // 6. Fecha a conexão
        mysqli_close($conexao);

    } else {
        // Se a requisição não for POST, redireciona de volta
        header('Location: principal2_admin.php');
        exit;
    }
?>