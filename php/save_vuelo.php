<?php

include('server.php');

if(isset($_SESSION['idcedula']) && isset($_POST['flightId'])) {
    $flightId = $_POST['flightId'];
    $userId = $_SESSION['idcedula'];
    $userEmail = $_SESSION['correoCliente'] ;

    // Perform database insert into vueloGuardado table
     $db->query("INSERT INTO vueloGuardado (idvuelo, idcliente, correocliente) VALUES ('$flightId', '$userId', '$userEmail')");

    // Return a response to indicate success or failure
    echo "success";
} else {
    echo "error";
}

