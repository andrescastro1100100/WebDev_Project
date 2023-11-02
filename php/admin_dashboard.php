<?php
include('server.php');
// Verify if the user is logged in
if (!isset($_SESSION['correoCliente']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Verify if the user has the role 'admin'
if ($_SESSION['role'] !== 'admin') {
    // Redirect to client dashboard if not an admin
    header("Location: cliente_dashboard.php");
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
    <script rel="text/javascript" href="../js/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Francois+One&family=Wix+Madefor+Display:wght@400;500&display=swap" rel="stylesheet">
    <title>flightScanner</title>
</head>

<body>
    <?php include 'menu_admin.php'; ?>




    <div class="flightcontent">
        <div class="text">Current Flights: </div>
        <div class="flightcontainer">

            <!-- flightDivs prints all of the elements in Vuelos as div class flight -->
            <?php echo $flightDivsAdmin; ?>

        



    </div>

</body>

</html>