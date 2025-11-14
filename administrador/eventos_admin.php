<?php
    session_start();

    // Verificação de Admin: Redireciona se não estiver logado ou não for Administrador (tipo != '0')
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['tipo']) || $_SESSION['tipo'] !== '0') {
        header('Location: ../login.php');
        exit;
    }

    // Defina aqui a sua chave de API do Google Maps
    $google_maps_api_key = "AIzaSyD1ymgJSOFD9yCS4hoC7hNeU8Km40bbQi0"; // Substitua pela sua chave real!
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_admin.css">
    <title>Cadastro de eventos</title>
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

    <main class="content-container">
        <div class="form-section">
            <h2 class="section-title">✨ Novo evento</h2>
            <form action="processa_cadastro_evento.php" method="POST" class="event-form">
                <div class="form-group">
                    <label for="nome">Nome do evento:</label>
                    <input type="text" id="nome" name="nome" required maxlength="120">
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" required maxlength="500"></textarea>
                </div>

                <div class="form-group">
                    <label for="local">Local do evento (endereço completo):</label>
                    <input type="text" id="local" name="local" required maxlength="200" onchange="geocodeAddress()">
                </div>

                <div class="form-row">
                    <div class="form-group half-width">
                        <label for="data">Data:</label>
                        <input type="date" id="data" name="data" required>
                    </div>

                    <div class="form-group half-width">
                        <label for="hora">Hora:</label>
                        <input type="time" id="hora" name="hora" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half-width">
                        <label for="capacidade">Capacidade máxima:</label>
                        <input type="number" id="capacidade" name="capacidade" min="1" maxlength="6" pattern="[0-9]{1,6}">
                    </div>
                    
                    <div class="form-group half-width">
                        <label for="imagem">Caminho da imagem (URL/caminho local):</label>
                        <input type="text" id="imagem" name="imagem" maxlength="255" placeholder="Ex: ../imagens/festa.jpg">
                    </div>
                </div>

                <button type="submit" class="submit-button">Cadastrar Evento</button>
            </form>
        </div>

        <div class="map-section">
            <h2 class="section-title">🗺️ Pré-visualização do Local</h2>
            <div id="map"></div>
        </div>
    </main>

    <script>
        let map;
        let geocoder;
        let marker;

        function initMap() {
            // Inicializa o mapa em uma localização padrão (São Paulo, SP)
            const localizacaoPadrao = { lat: -23.55052, lng: -46.633308 };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: localizacaoPadrao,
            });

            marker = new google.maps.Marker({
                map: map,
                position: localizacaoPadrao,
                title: "Local Padrão",
            });

            geocoder = new google.maps.Geocoder();
            
            // Tenta geocodificar o local do evento se o campo já tiver algo
            geocodeAddress();
        }

        // Função para geocodificar o endereço digitado e atualizar o mapa
        function geocodeAddress() {
            const address = document.getElementById("local").value;
            if (address.trim() === "") {
                return; // Não faz nada se o campo estiver vazio
            }

            geocoder.geocode({ 'address': address }, function(results, status) {
                if (status === 'OK') {
                    const location = results[0].geometry.location;
                    map.setCenter(location);
                    map.setZoom(15); // Zoom mais próximo

                    marker.setPosition(location);
                    marker.setTitle(address);
                } else if (status === 'ZERO_RESULTS') {
                    // console.error
                    alert('Não foi possível encontrar o local: "' + address + '". Tente um endereço mais específico.');
                } else {
                     // console.error
                }
            });
        }
    </script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap">
    </script>
    
</body>
</html>