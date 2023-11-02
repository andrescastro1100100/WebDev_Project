<?php
include('server.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correoCliente']) || !isset($_SESSION['role'])) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: login.php");
    exit();
}

// Verificar si el usuario tiene el rol de 'cliente'
if ($_SESSION['role'] !== 'client') {
    // Redirigir al panel de administrador si no es un cliente
    header("Location: admin_dashboard.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['correoCliente']);
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Francois+One&family=Wix+Madefor+Display:wght@400;500&display=swap" rel="stylesheet">
    <title>flightScanner</title>
    <style>

    </style>


</head>

<body>
    <?php include 'menu_cliente.php'; ?>

    <div class="flightcontent">
        <div class="text">Galería de Aviones: </div>
        <div class="flightcontainer">

            <!-- Mostrar la galería de imágenes de aviones -->
            <?php
            // Definir la clave de API de Google Custom Search JSON
            $api_key = 'AIzaSyBf6O8W_uudNaLpYsmUffbm3ZSmoR15w7U';

            // Consulta de búsqueda para imágenes de aviones
            $search_query = 'Boeing Airplane';

            // URL de la API de búsqueda de imágenes de Google
            $url = "https://www.googleapis.com/customsearch/v1?q=aviones%20de%20aeropuerto&cx=1052d6935595a4b93&key=$api_key&searchType=image";

            // Realizar la solicitud a la API
            $response = file_get_contents($url);
            $data = json_decode($response);

            // Mostrar las imágenes en la galería con un tamaño pequeño
            if ($data && property_exists($data, 'items')) {
                foreach ($data->items as $item) {
                    echo '<img class="small-image" src="' . $item->link . '" alt="Imagen de avión" onclick="displayRandomFact()"> ';
                }
            }
            ?>
            <div id="myModal" class="FlightFactModal">
                <div class="FlightFactModal-content">
                    <span class="close">&times;</span>
                    <p id="factText">Random airplane fact will be displayed here.</p>
                </div>
            </div>


        </div>
    </div>
</body>


<script>
    // Get the modal and the <span> element that closes it
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];

    // Array of random airplane facts
    var airplaneFacts = [
        "Los hermanos Wright, Orville y Wilbur, son reconocidos por inventar y construir el primer avión exitoso del mundo.",
        "El Boeing 747, también conocido como el 'Jumbo Jet', fue en su momento el avión de pasajeros más grande del mundo.",
        "El Airbus A380 es actualmente el avión de pasajeros más grande del mundo, capaz de transportar a más de 800 pasajeros.",
        "El Concorde fue un avión de pasajeros supersónico que podía viajar más rápido que la velocidad del sonido.",
        "El término 'caja negra' se refiere al registrador de datos de vuelo y al grabador de voz de cabina que se utilizan en los aviones.",
        "El Boeing 737 es uno de los aviones más vendidos en la historia de la aviación comercial.",
        "El Airbus A320 introdujo el uso generalizado de la tecnología fly-by-wire en aviones de pasajeros.",
        "El primer vuelo comercial del Concorde tuvo lugar en 1976 y ofrecía vuelos supersónicos entre Europa y América del Norte.",
        "El Boeing 787 Dreamliner utiliza materiales compuestos y tecnología avanzada para mejorar la eficiencia y la comodidad de los pasajeros.",
        "El Antonov An-225 es el avión de carga más grande y pesado del mundo, capaz de transportar cargas excepcionalmente grandes y pesadas.",
        "El Airbus A350 es conocido por su eficiencia en el consumo de combustible y su diseño aerodinámico avanzado.",
        "El Douglas DC-3, un avión icónico de la década de 1930, fue uno de los primeros en popularizar los vuelos comerciales.",
        "El Boeing 777 es conocido por su alcance y capacidad para vuelos de larga distancia."

    ];

    // Function to display a random fact in the modal
    function displayRandomFact() {
        var randomIndex = Math.floor(Math.random() * airplaneFacts.length);
        document.getElementById("factText").textContent = airplaneFacts[randomIndex];
        modal.style.display = "block";
    }

    // Attach click event listeners to each small image
    var smallImages = document.getElementsByClassName("small-image");
    for (var i = 0; i < smallImages.length; i++) {
        smallImages[i].addEventListener("click", displayRandomFact);
    }

    span.addEventListener("click", function() {
        modal.style.display = "none";
    });

    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
</script>

</html>