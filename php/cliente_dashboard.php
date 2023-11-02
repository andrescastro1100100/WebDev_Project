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
    <script>
        $(document).on('click', '.save-flight', function() {
            var flightId = $(this).data('flight-id');
            $.ajax({
                url: 'save_vuelo.php', // Create this PHP script
                method: 'POST',
                data: {
                    flightId: flightId
                },
                success: function(response) {
                    alert(response); // Handle success (e.g., update UI to indicate the flight is saved)
                },
                error: function() {
                    // Handle error
                }
            });
        });
    </script>

</head>

<body>

    <?php include 'menu_cliente.php'; ?>


    <div class="flightcontent">
        <div class="text">Vuelos Disponibles: </div>
        <div class="flightcontainer">
            <!-- flightDivs prints all of the elements in Vuelos as div class flight -->
            <?php echo $flightDivs; ?>




        </div>



    </div>

</body>




</html>