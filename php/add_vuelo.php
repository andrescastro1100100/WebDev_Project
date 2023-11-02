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



// Queries to bring info from the database, and feed the dropdowns
$aeronaveQuery = "SELECT idaeronave, tipoAeronave FROM aeronave";
$aeronaveResult = $db->query($aeronaveQuery);

$aeropuertoQuery = "SELECT idAeropuerto, ciudadAeropuerto FROM aeropuerto";
$aeropuertoResult = $db->query($aeropuertoQuery)

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
        <?php
        

        if (isset($insertedSuccessfully) && $insertedSuccessfully) {
            echo ' <div style="background-color: #c6efce;
            color: #006100;
            padding: 10px;
            border: 1px solid #006100;
            border-radius: 5px;
            margin: 10px 0;" class="success-message">Vuelo insertado correctamente.</div>';
        }
        ?>

        <div class="input-group">
            <h2 style="color:#172554">Agregar vuelo</h2>
        </div>
        <!-- Forms to insert new vuelo into Vuelo table -->
        <form method="post" action="add_vuelo.php">
            <div class="input-group">
                <label for="vueloOrigen">Origen del vuelo:</label>
                <select style="color: black;  width: 100%; padding: 10px; font-size: 16px;  border: 1px solid #ccc;  border-radius: 5px; background-color: white;" name="vueloOrigen" id="vueloOrigen"required>
                    <option style="color: black; background-color: white;" value="" selected disabled>Elija el Aeropuerto de Origen</option>
                    <?php
                    $aeropuertoResult->data_seek(0);
                    while ($row = $aeropuertoResult->fetch_assoc()) {
                        echo '<option style="color: black; background-color: white;" value="' . $row["idAeropuerto"] . '">' . $row["ciudadAeropuerto"] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="input-group">
                <label for="vueloDestino">Destino del vuelo:</label>
                <select style="color: black;  width: 100%; padding: 10px; font-size: 16px;  border: 1px solid #ccc;  border-radius: 5px; background-color: white;" name="vueloDestino" id="vueloDestino" required>
                    <option style="color: black; background-color: white;" value="" selected disabled>Elija el Aeropuerto de Destino</option>
                    <?php
                    $aeropuertoResult->data_seek(0);
                    while ($row = $aeropuertoResult->fetch_assoc()) {
                        echo '<option style="color: black; background-color: white;" value="' . $row["idAeropuerto"] . '">' . $row["ciudadAeropuerto"] . '</option>';
                    }
                    ?>
                </select>
                <br>
            </div>

            <div class="input-group">
                <label for="idAeronave">Aeronave:</label>
                <select style="color: black;  width: 100%; padding: 10px; font-size: 16px;  border: 1px solid #ccc;  border-radius: 5px; background-color: white;" name="idAeronave" id="idAeronave" required>
                    <option style="color: black; background-color: white;" value="" selected disabled>Elija la aeronave</option>
                    <?php
                    while ($row = $aeronaveResult->fetch_assoc()) {
                        echo '<option style="color: black; background-color: white;" value="' . $row["idaeronave"] . '">' . $row["tipoAeronave"] . '</option>';
                    }
                    ?>
                </select>
                <br>
            </div>

            <div class="input-group">
                <label for="fechaVuelo">Fecha del Vuelo:</label>
                <input type="date" name="fechaVuelo" id="fechaVuelo" min="<?php echo date("Y-m-d"); ?>" required>
                <br>
            </div>

            <div class="input-group">
                <label for="vueloArribado">Estado de arribo:</label>
                <select style="color: black;  width: 100%; padding: 10px; font-size: 16px;  border: 1px solid #ccc;  border-radius: 5px; background-color: white;" type="text" name="vueloArribado" id="vueloArribado" required>
                    <option style="color: black; background-color: white;" value="" selected disabled>Elija el estado de arribo del vuelo</option>
                    <option style="color: black; background-color: white;">No arribado</option>
                    <option style="color: black; background-color: white;">Arribado</option>
                </select>
                <br>
            </div>



            <div class="input-group">
                <label for="estado">Estado de actividad:</label>
                <select style="color: black;  width: 100%; padding: 10px; font-size: 16px;  border: 1px solid #ccc;  border-radius: 5px; background-color: white;" type="text" name="estado" id="estado" required>
                    <option style="color: black; background-color: white;" value="" selected disabled>Elija el estado del vuelo</option>
                    <option style="color: black; background-color: white;">Activo</option>
                    <option style="color: black; background-color: white;">Pendiente</option>
                </select>
                <br>
            </div>

            <div class="input-group">
                <button type="submit" name="agregar_vuelo"> Guardar</button>
            </div>

        </form>
    </div>

</body>

</html>