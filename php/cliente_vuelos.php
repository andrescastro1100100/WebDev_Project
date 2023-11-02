<?php
include('server.php');

// Verify if the user is logged in
if (!isset($_SESSION['correoCliente']) || !isset($_SESSION['role'])) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: login.php");
    exit();
}

// Verify if the user has the role 'cliente'
if ($_SESSION['role'] !== 'client') {
    // Redirect to admin dashboard if not a cliente
    header("Location: admin_dashboard.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['correoCliente']);
    header("location: login.php");
}


$userID = $_SESSION['idcedula'];

$sql = "SELECT V.*, VG.idnotificacion FROM Vuelo V
        INNER JOIN vueloGuardado VG ON V.idVuelo = VG.idvuelo
        WHERE VG.idcliente = $userID";

$result = $db->query($sql);

// Check if there are any saved flights for the user
if ($result->num_rows > 0) {
    $flightDivVG = '';

    while ($row = $result->fetch_assoc()) {
        // Extract vuelo data
        $idvuelo = $row['idVuelo'];
        $vueloOrigen = $row['vueloOrigen'];
        $vueloDestino = $row['vueloDestino'];
        $fechaVuelo = $row['fechaVuelo'];

        // Generate the HTML for the flight div and append it to the $flightDivVG variable
        $flightDivVG .= '<div class="flight">';
        $flightDivVG .= '<div class="gradient"></div>';
        $flightDivVG .= '<div class="content">';
        $flightDivVG .= '<div class="departuretime">'. $vueloArribado . " | " . date(" Y-m-d ", strtotime($fechaVuelo)) . '</div>';
        $flightDivVG .= '<div class="flightinfo">';
        $flightDivVG .= '<span>' . $vueloOrigen . '</span>';
        $flightDivVG .= '<img src="../icons/airplane-takeoff.svg" alt="">';
        $flightDivVG .= '<span>' . $vueloDestino . '</span>';
        $flightDivVG .= '</div>';
        $flightDivVG .= '<div class="flightcode"><span>Flight Number: </span>' . $idvuelo . '</div>';
        $flightDivVG .= '</div>';
        $flightDivVG .= '<div class="actions">';
        $flightDivVG .= '<img src="../icons/airplane-remove.svg" alt="" class="remove-flight" data-flight-id="' . $idvuelo . '">';
        $flightDivVG .= '<img src="../icons/alarm-light-outline.svg" alt="">';
        $flightDivVG .= '</div>';
        $flightDivVG .= '</div>';
    }
} else {
   
    $flightDivVG = '<p>No tienes vuelos guardados</p>';
}


if(isset($_SESSION['idcedula']) && isset($_POST['flightId'])) {
    $userID = $_SESSION['idcedula'];
    $flightId = $_POST['flightId'];

    $sql = "DELETE FROM vueloGuardado WHERE idcliente = $userID AND idvuelo = $flightId";
    
    if ($db->query($sql) === TRUE) {
        $deletedSuccessfully = true;
        $delete_success = "Flight removed successfully";
    } else {
        echo "Error removing flight: " . $db->error;
    }
} else {
    // echo "Invalid request";
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <script rel="text/javascript" href="../js/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Francois+One&family=Wix+Madefor+Display:wght@400;500&display=swap" rel="stylesheet">
    <title>flightScanner</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




</head>

<body>

    <?php include 'menu_cliente.php'; ?>

    <div class="flightcontent">
        
        <div class="text">Tus Vuelos: </div>
    
        <div class="flightcontainer">
       
        
    
        <?php echo $flightDivVG; ?>




        </div>



    </div>

</body>
<script>
        $(document).ready(function() {
            $(".remove-flight").on("click", function() {
                var flightId = $(this).data("flight-id");

                $.post("cliente_vuelos.php", {
                    flightId: flightId
                }, function(data) {
                    location.reload();
                  
                });
            });
        });
    </script>
</html>