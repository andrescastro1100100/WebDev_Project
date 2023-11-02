<?php
include('server.php');

// Verify if logged in
if (!isset($_SESSION['correoCliente']) || !isset($_SESSION['role'])) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: login.php");
    exit();
}

// Verify if client
if ($_SESSION['role'] !== 'client') {
    // Redirect to admin dash if not a client
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
        <div  ><h2 style="color:#172554">Aeropuertos</h2> </div>
        <div class="flightcontainer">

        <div>
        <h3 style="color:#172554" >John F. Kennedy Airport, New York</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3027.331406567782!2d-73.7797035!3d40.6446245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c26650d5404947%3A0xec4fb213489f11f0!2sAeropuerto%20Internacional%20John%20F.%20Kennedy!5e0!3m2!1ses-419!2scr!4v1692556998733!5m2!1ses-419!2scr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div>
        <h3 style="color:#172554"  class="text">Logan International Airport, Boston</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2947.903739097086!2d-71.017547!3d42.36589070000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e3703dbc314c39%3A0x86456df9d5bdcee5!2sBoston%20Logan%20International%20Airport!5e0!3m2!1ses-419!2scr!4v1692557078469!5m2!1ses-419!2scr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div>
        <h3 style="color:#172554"  class="text">Miami International Airport</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3592.2554311333865!2d-80.27950919999999!3d25.795145899999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b74d4eb94ac1%3A0x989fdae0cba2f8e1!2sAeropuerto%20Internacional%20de%20Miami!5e0!3m2!1ses-419!2scr!4v1692557149967!5m2!1ses-419!2scr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div>
        <h3 style="color:#172554"  class="text">Juan Santamaria International Airport</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.229155441597!2d-84.20401489999999!3d9.9979207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0f9c450507873%3A0xb27b62220e3f31a4!2sAeropuerto%20Internacional%20Juan%20Santamar%C3%ADa%2C%20San%20Jose!5e0!3m2!1ses-419!2scr!4v1692557196314!5m2!1ses-419!2scr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div>
        <h3 style="color:#172554" class="text">Madrid-Barajas International Airport</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3034.1124306837437!2d-3.5793543999999997!3d40.4948968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4231d000000001%3A0x6e7725ea0f85ceef!2sAeropuerto%20Adolfo%20Su%C3%A1rez%20Madrid-Barajas!5e0!3m2!1ses-419!2scr!4v1692557256313!5m2!1ses-419!2scr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>


        </div>
    </div>
</body>


<script>
   
</script>

</html>