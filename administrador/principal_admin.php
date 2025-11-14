<?php
    session_start();

    // Verificação de Admin: Redireciona se não estiver logado ou não for Administrador (tipo != '0')
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== '0') {
        header('Location: ../login.php');
        exit;
    }

    include('../conexao.php'); // Inclui o arquivo de conexão

    // Query para buscar todos os eventos e o número de reservas ativas
    $sql_eventos = "
        SELECT
            e.*,
            (SELECT COUNT(id_reserva) FROM reservas r WHERE r.id_evento = e.id_evento AND r.status = 'A') AS reservas_ativas
        FROM
            eventos e
        ORDER BY
            e.data ASC, e.hora ASC
    ";

    $resultado_eventos = mysqli_query($conexao, $sql_eventos);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_admin.css">
    <title>Eventos</title>
</head>
<body>
    <header class="main-header">
        <div class="logo-container">
            <img src="../imagens/logo_estrela.gif" alt="Logo" id="logo">
        </div>

        <nav class="nav-icons">
            <div class="icon-box">
                <a href="principal_admin.php">EVENTOS</a>
            </div>

            <div class="icon-box">
                <a href="eventos_admin.php">NOVO EVENTO</a>
            </div>

            <div class="icon-box">
                <a href="cadastro_admin.php">CADASTRAR</a>
            </div>
           
            <div class="icon-box">
                <a href="../logout.php">SAIR</a>
            </div>
        </nav>
    </header>

    <main class="content-container-full">
        <h2 class="page-title">📋 Eventos</h2>

        <div class="event-list">
            <?php if (mysqli_num_rows($resultado_eventos) > 0): ?>
                <?php while ($evento = mysqli_fetch_assoc($resultado_eventos)):
                    $capacidade_total = $evento['capacidade'];
                    $reservas_ativas = $evento['reservas_ativas'];
                    $capacidade_disponivel = $capacidade_total !== null ? $capacidade_total - $reservas_ativas : '∞';
                    $esgotado = ($capacidade_total !== null && $capacidade_disponivel <= 0);
                ?>
                    <div class="event-card admin-card">
                        <div class="event-image-container">
                            <?php if (!empty($evento['imagem'])): ?>
                                <img src="<?php echo htmlspecialchars($evento['imagem']); ?>" alt="Imagem do Evento">
                            <?php else: ?>
                                <div class="no-image">🖼️ Sem imagem</div>
                            <?php endif; ?>
                        </div>
                       
                        <div class="event-details">
                            <h3 class="event-title"><?php echo htmlspecialchars($evento['nome']); ?></h3>
                            <p class="event-description"><?php echo nl2br(htmlspecialchars($evento['descricao'])); ?></p>
                           
                            <ul class="event-info-list">
                               
                                <li>📅 Data: <?php echo date('d/m/Y', strtotime($evento['data'])); ?></li>
                                <li>⏰ Hora: <?php echo date('H:i', strtotime($evento['hora'])); ?></li>
                                <li>📍 Local: <?php echo htmlspecialchars($evento['local']); ?></li>
                               
                                <li class="availability">
                                    <span class="admin-label">👥 Reservas: </span>
                                    <span class="<?php echo $esgotado ? 'admin-esgotado' : 'admin-disponivel'; ?>">
                                        <?php echo $reservas_ativas; ?> Reservados
                                    </span>
                                    <?php if ($capacidade_total !== null): ?>
                                        <span> / <?php echo $capacidade_total; ?> Total</span>
                                        <span class="<?php echo $esgotado ? 'admin-danger' : 'admin-success'; ?>">
                                            (<?php echo $capacidade_disponivel; ?> Vagas)
                                        </span>
                                    <?php else: ?>
                                        <span> / Capacidade ilimitada</span>
                                    <?php endif; ?>
                                </li>
                            </ul>

                           
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-events-message">Nenhum evento cadastrado no momento. <a href="principal_admin.php">Crie um novo evento aqui.</a></p>
            <?php endif; ?>
        </div>

    </main>
   
    <?php mysqli_close($conexao); // Fecha a conexão após buscar os eventos ?>
</body>
</html>
