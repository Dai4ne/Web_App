<?php
    session_start();
    include('../conexao.php');

    // Verificação de Usuário Comum
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo'] !== '1' || $_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: ../login.php');
        exit;
    }

    $id_evento = mysqli_real_escape_string($conexao, $_POST['id_evento']);
    $login_usuario = $_SESSION['login'];

    // Query para mudar o status da reserva para 'C' (Cancelada)
    $sql = "UPDATE reservas SET status = 'C' WHERE id_evento = ? AND login = ? AND status = 'A'";
    
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "is", $id_evento, $login_usuario);
    
    if (mysqli_stmt_execute($stmt)) {
        // Verifica se alguma linha foi afetada (se a reserva realmente existia e estava ativa)
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "<script>alert('✅ Reserva cancelada com sucesso!'); window.location.href='principal.php';</script>";
        } else {
            echo "<script>alert('⚠️ Nenhuma reserva ativa para este evento foi encontrada.'); window.location.href='principal.php';</script>";
        }
    } else {
        echo "<script>alert('❌ Erro ao cancelar reserva: " . mysqli_stmt_error($stmt) . "'); window.location.href='principal.php';</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
?>