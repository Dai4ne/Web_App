<?php
    session_start();

    // Verificação de Usuário Comum: Redireciona se não estiver logado ou não for Usuário Comum (tipo != '1')
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== '1') {
        header('Location: ../login.php');
        exit;
    }

    include('../conexao.php'); // Inclui o arquivo de conexão
    
    // Defina aqui a sua chave de API do Google Maps (Necessária para a função do mapa abaixo)
    $google_maps_api_key = "AIzaSyD1ymgJSOFD9yCS4hoC7hNeU8Km40bbQi0"; // Substitua pela sua chave real!
    
    // Login do usuário logado
    $login_usuario = isset($_SESSION['login']) ? $_SESSION['login'] : '';
    
    // Query para buscar todos os eventos e verificar o status da reserva do usuário
    $sql_eventos = "
        SELECT 
            e.*,
            (SELECT COUNT(id_reserva) FROM reservas r WHERE r.id_evento = e.id_evento AND r.status = 'A') AS reservas_ativas,
            r.status AS status_reserva_usuario
        FROM 
            eventos e
        LEFT JOIN 
            reservas r ON e.id_evento = r.id_evento AND r.login = ?
        ORDER BY 
            e.data ASC, e.hora ASC
    ";
    
    $stmt_eventos = mysqli_prepare($conexao, $sql_eventos);
    mysqli_stmt_bind_param($stmt_eventos, "s", $login_usuario);
    mysqli_stmt_execute($stmt_eventos);
    $resultado_eventos = mysqli_stmt_get_result($stmt_eventos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_usercomum.css">
    <title>Página Principal - Eventos</title>
</head>
<body>

    <header class="main-header">
        <div class="logo-container">
            <img src="../imagens/logo_estrela.gif" alt="Logo" id="logo">
        </div>
        <nav class="nav-icons">

            <div class="icon-box">
                <a href="../logout.php">SAIR</a>
            </div>
        </nav>
    </header>

    <main class="content-container">
        <h2 class="page-title">🎉 Eventos Disponíveis</h2>

        <div class="event-list">
            <?php if (mysqli_num_rows($resultado_eventos) > 0): ?>
                <?php while ($evento = mysqli_fetch_assoc($resultado_eventos)): 
                    $capacidade_disponivel = $evento['capacidade'] - $evento['reservas_ativas'];
                    $esgotado = $capacidade_disponivel <= 0 && $evento['capacidade'] !== null;
                ?>
                    <div class="event-card" id="evento-<?php echo $evento['id_evento']; ?>">
                        <div class="event-image-container">
                            <?php if (!empty($evento['imagem']) && @file_exists($evento['imagem'])): ?>
                                <img src="<?php echo htmlspecialchars($evento['imagem']); ?>" alt="Imagem do Evento">
                            <?php else: ?>
                                <div class="no-image">🖼️ Sem Imagem</div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="event-details">
                            <h3 class="event-title"><?php echo htmlspecialchars($evento['nome']); ?></h3>
                            <p class="event-description"><?php echo nl2br(htmlspecialchars($evento['descricao'])); ?></p>
                            
                            <ul class="event-info-list">
                                <li>📅 **Data:** <?php echo date('d/m/Y', strtotime($evento['data'])); ?></li>
                                <li>⏰ **Hora:** <?php echo date('H:i', strtotime($evento['hora'])); ?></li>
                                <li>📍 **Local:** <?php echo htmlspecialchars($evento['local']); ?> 
                                    <button class="map-button" onclick="showMapModal('<?php echo htmlspecialchars(addslashes($evento['local'])); ?>', '<?php echo htmlspecialchars($evento['nome']); ?>')">Ver Mapa</button>
                                </li>
                                <?php if ($evento['capacidade'] !== null): ?>
                                    <li class="availability">
                                        👥 **Vagas:** <span class="<?php echo $esgotado ? 'esgotado' : 'disponivel'; ?>">
                                            <?php echo $capacidade_disponivel; ?> / <?php echo $evento['capacidade']; ?>
                                        </span>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <div class="action-buttons">
                                <?php 
                                    $status_reserva = $evento['status_reserva_usuario'];
                                    $id_evento = $evento['id_evento'];
                                ?>
                                
                                <?php if ($status_reserva === 'A'): ?>
                                    <span class="reservation-status reserved">RESERVADO</span>
                                    <form action="cancelar_reserva.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_evento" value="<?php echo $id_evento; ?>">
                                        <button type="submit" class="action-button cancel-button" onclick="return confirm('Tem certeza que deseja cancelar esta reserva?');">
                                            Cancelar Reserva
                                        </button>
                                    </form>
                                <?php elseif ($status_reserva === 'C'): ?>
                                    <span class="reservation-status canceled">RESERVA CANCELADA</span>
                                    <?php if (!$esgotado): ?>
                                        <form action="fazer_reserva.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_evento" value="<?php echo $id_evento; ?>">
                                            <button type="submit" class="action-button reserve-button">
                                                Refazer Reserva
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php elseif ($esgotado): ?>
                                    <span class="reservation-status sold-out">ESGOTADO</span>
                                <?php else: ?>
                                    <form action="fazer_reserva.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_evento" value="<?php echo $id_evento; ?>">
                                        <button type="submit" class="action-button reserve-button">
                                            Fazer Reserva
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-events-message">Nenhum evento disponível no momento.</p>
            <?php endif; ?>
        </div>

    </main>
    
    <div id="mapModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeMapModal()">&times;</span>
            <h3 id="modalTitle">Localização do Evento</h3>
            <div id="modalMap"></div>
        </div>
    </div>

    <script>
        let modalMap;
        let modalMarker;
        let geocoder;

        function initMapModal() {
            // Inicializa o Geocoder uma única vez
            geocoder = new google.maps.Geocoder();

            // Configuração do mapa dentro do modal (inicialmente centralizado em um ponto neutro)
            const mapContainer = document.getElementById('modalMap');
            modalMap = new google.maps.Map(mapContainer, {
                zoom: 12,
                center: { lat: 0, lng: 0 }, // Centro neutro
                mapTypeId: 'roadmap'
            });

            // Cria um marcador sem posição inicial
            modalMarker = new google.maps.Marker({
                map: modalMap,
            });
        }

        function showMapModal(address, title) {
            document.getElementById('modalTitle').innerText = '📍 Local: ' + title;
            document.getElementById('mapModal').style.display = 'block';

            // Garante que o mapa foi renderizado após o modal ser exibido
            setTimeout(() => {
                // Tenta geocodificar o endereço
                if (geocoder) {
                    geocoder.geocode({ 'address': address }, function(results, status) {
                        if (status === 'OK') {
                            const location = results[0].geometry.location;
                            modalMap.setCenter(location);
                            modalMap.setZoom(15); 
                            modalMarker.setPosition(location);
                            modalMarker.setTitle(address);
                        } else {
                            alert('Não foi possível localizar o endereço no mapa: ' + address);
                        }
                    });
                }
            }, 100); // Pequeno atraso para garantir o CSS do modal
        }

        function closeMapModal() {
            document.getElementById('mapModal').style.display = 'none';
        }
    </script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMapModal">
    </script>

    <?php mysqli_close($conexao); // Fecha a conexão após buscar os eventos ?>
</body>
</html>