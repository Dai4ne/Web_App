<?php
    session_start();

   
    // Defina aqui a sua chave de API do Google Maps
    $google_maps_api_key = "AIzaSyD1ymgJSOFD9yCS4hoC7hNeU8Km40bbQi0";


    // Verifica se o usuário está logado
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        header('Location: login.php');
        exit;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Página Principal</title>
</head>
<body>
    <div class="container">
        <h1>Login feito com sucesso!</h1>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['email']); ?>. Você está na página principal.</p>
        <a href="logout.php" id="trocar_senha">Sair</a>

        
        <h2>📍 Exemplo de Integração do Google Maps com PHP</h2>
        <div id="map"></div>

        <script>
            // Função que inicializa o mapa
            function initMap() {
                // Define as coordenadas (latitude e longitude) do local desejado
                const localizacao = { lat: -23.55052, lng: -46.633308 }; // São Paulo, SP 

                // Cria o mapa centralizado no local
                const mapa = new google.maps.Map(document.getElementById("map"), {
                    zoom: 12,
                    center: localizacao,
                });

                // Adiciona um marcador no mapa
                const marcador = new google.maps.Marker({
                    position: localizacao,
                    map: mapa,
                    title: "São Paulo - SP",
                });
            }
        </script>

        <!-- Script da API do Google Maps (com a chave PHP inserida dinamicamente) -->
        <script async
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initMap">
        </script>
    
    </div>
</body>
</html>