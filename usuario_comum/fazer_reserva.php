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

    // 1. Verifica a disponibilidade e se o usuário já tem uma reserva ativa
    $sql_check = "SELECT 
                    e.capacidade,
                    (SELECT COUNT(id_reserva) FROM reservas r WHERE r.id_evento = ? AND r.status = 'A') AS reservas_ativas,
                    (SELECT status FROM reservas r WHERE r.id_evento = ? AND r.login = ?) AS status_reserva_usuario
                  FROM 
                    eventos e 
                  WHERE 
                    e.id_evento = ?";
    
    $stmt_check = mysqli_prepare($conexao, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "iisi", $id_evento, $id_evento, $login_usuario, $id_evento);
    mysqli_stmt_execute($stmt_check);
    $resultado_check = mysqli_stmt_get_result($stmt_check);
    $evento_info = mysqli_fetch_assoc($resultado_check);
    mysqli_stmt_close($stmt_check);

    if (!$evento_info) {
        echo "<script>alert('❌ Evento não encontrado.'); window.location.href='principal.php';</script>";
        exit;
    }

    $capacidade = $evento_info['capacidade'];
    $reservas_ativas = $evento_info['reservas_ativas'];
    $status_reserva_usuario = $evento_info['status_reserva_usuario'];
    $vagas_disponiveis = $capacidade - $reservas_ativas;

    if ($capacidade !== null && $vagas_disponiveis <= 0) {
        echo "<script>alert('As vagas para este evento esgotaram.'); window.location.href='principal.php';</script>";
        exit;
    }

    if ($status_reserva_usuario === 'A') {
        echo "<script>alert('⚠️ Você já tem uma reserva para este evento.'); window.location.href='principal.php';</script>";
        exit;
    }

    // 2. Realiza a Reserva/Atualiza status
    if ($status_reserva_usuario === 'C') {
        // Se já tem uma reserva cancelada, apenas ativa-a novamente
        $sql = "UPDATE reservas SET status = 'A' WHERE id_evento = ? AND login = ?";
        $action_message = 'Reserva reativada com sucesso!';
    } else {
        // Se não tem reserva, insere uma nova
        $sql = "INSERT INTO reservas (status, login, id_evento) VALUES ('A', ?, ?)";
        $action_message = 'Reserva realizada com sucesso!';
    }
    
    $stmt = mysqli_prepare($conexao, $sql);

    if ($status_reserva_usuario === 'C') {
        mysqli_stmt_bind_param($stmt, "is", $id_evento, $login_usuario);
    } else {
        mysqli_stmt_bind_param($stmt, "si", $login_usuario, $id_evento);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('✅ " . $action_message . "'); window.location.href='principal.php';</script>";
    } else {
        echo "<script>alert('❌ Erro ao processar reserva: " . mysqli_stmt_error($stmt) . "'); window.location.href='principal.php';</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
?>