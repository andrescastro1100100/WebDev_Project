<?php
session_start();



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';


$errors = array();

//Conexion a base de datos
$db = mysqli_connect('localhost', 'root', '', 'project');




// Initialize variables to hold form input
$nombre = "";
$apellido = "";
$cedula = "";
$correoCliente = "";
$date = date('Y-m-d H:i:s');


//USUARIOS - CLIENTES

// Process form submission
if (isset($_POST['reg_user'])) {
    // Retrieve data from form
    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($db, $_POST['apellido']);
    $cedula = mysqli_real_escape_string($db, $_POST['cedula']);
    $fechaNacimiento = date("Y-m-d", strtotime($_POST["fechaNacimiento"]));
    $correoCliente = mysqli_real_escape_string($db, $_POST['correoCliente']);
    $clave_1 = mysqli_real_escape_string($db, $_POST['clave_1']);
    $clave_2 = mysqli_real_escape_string($db, $_POST['clave_2']);


    // Validate form data
    if (empty($nombre)) {
        array_push($errors, "Nombre is required");
    }
    if (empty($apellido)) {
        array_push($errors, "Apellido is required");
    }
    if (empty($cedula)) {
        array_push($errors, "Cedula is required");
    }
    if (empty($fechaNacimiento)) {
        array_push($errors, "Fecha de Nacimiento is required");
    }
    if (empty($correoCliente)) {
        array_push($errors, "Email is required");
    }
    if (empty($clave_1)) {
        array_push($errors, "Contraseña is required");
    }
    if ($clave_1 != $clave_2) {
        array_push($errors, "The two passwords do not match");
    }


    $check_cedula_sql = "SELECT idcedula FROM Usuario WHERE idcedula='$cedula' LIMIT 1";
    $check_correo_sql = "SELECT correo FROM Usuario WHERE correo='$correoCliente' LIMIT 1";

    $cedula_result = mysqli_query($db, $check_cedula_sql);
    $correo_result = mysqli_query($db, $check_correo_sql);

    if (mysqli_num_rows($cedula_result) > 0) {
        array_push($errors, "Cedula already exists");
    }

    if (mysqli_num_rows($correo_result) > 0) {
        array_push($errors, "Email already exists");
    }

    // If there are no errors, insert data into the database
    if (count($errors) == 0) {

        $activo = 1; // Assuming 1 means active
        $sql_usuario = "INSERT INTO Usuario (idcedula, clave, correo, fechacreacion, activo)
                            VALUES ('$cedula', '$clave_1', '$correoCliente','$date', '$activo')";

        // Insert data into Cliente table
        $sql_cliente = "INSERT INTO Cliente (idcedula, nombre, apellido, fechanacimiento)
                            VALUES ('$cedula', '$nombre', '$apellido', '$fechaNacimiento')";

        // Execute both queries
        if (mysqli_query($db, $sql_usuario) && mysqli_query($db, $sql_cliente)) {
            header('location: login.php');
        } else {
            echo "Error: " . mysqli_error($db);
        }
    }
}



// Process login form submission
if (isset($_POST['login_user'])) {
    $correoCliente = mysqli_real_escape_string($db, $_POST['correoCliente']);
    $clave = mysqli_real_escape_string($db, $_POST['clave']);

    // Validate form data
    $errors = array();
    if (empty($correoCliente)) {
        array_push($errors, "Email is required");
    }
    if (empty($clave)) {
        array_push($errors, "Password is required");
    }

    // If there are no errors, try to log in
    if (count($errors) == 0) {


        $login_query = "SELECT * FROM Usuario WHERE correo='$correoCliente' AND clave='$clave' AND activo = 1 LIMIT 1";
        $result = mysqli_query($db, $login_query);

        if (mysqli_num_rows($result) == 1) {
            // User found, login successful
            $user = mysqli_fetch_assoc($result);

            // Check if the user is an admin or a client and redirect to the appropriate dashboard
            $admin_query = "SELECT * FROM Administrador WHERE id_cedula = " . $user['idcedula'];
            $admin_result = mysqli_query($db, $admin_query);

            if (mysqli_num_rows($admin_result) == 1) {
                // User is an admin, redirect to admin dashboard
                $_SESSION['correoCliente'] = $correoCliente;
                $_SESSION['role'] = 'admin'; // Set the role as admin
                header("Location: admin_dashboard.php");
                exit();
            } else {
                // User is a client, redirect to client dashboard
                $_SESSION['correoCliente'] = $correoCliente;
                $_SESSION['idcedula'] = $user['idcedula'];
                $_SESSION['role'] = 'client'; // Set the role as client
                header("Location: cliente_dashboard.php");
                exit();
            }
        } else {
            // User not found or incorrect login credentials
            array_push($errors, "Invalid email or password");
        }
    }
}



// VUELO

//POST for vuelo inserts into db

if (isset($_POST['agregar_vuelo'])) {

    // Get form data
    $vueloOrigen = isset($_POST['vueloOrigen']) ? $_POST['vueloOrigen'] : '';
    $vueloDestino = isset($_POST['vueloDestino']) ? $_POST['vueloDestino'] : '';
    $idAeronave = isset($_POST['idAeronave']) ? $_POST['idAeronave'] : '';
    $tipoAeronave = '';
    $fechaVuelo = date("Y-m-d", strtotime($_POST["fechaVuelo"]));
    $vueloArribado = $_POST['vueloArribado'];
    $estado = $_POST['estado'];



    if ($idAeronave === '1') {
        $tipoAeronave = 'Boeing 737';
    } elseif ($idAeronave === '2') {
        $tipoAeronave = 'Airbus A320';
    } elseif ($idAeronave === '3') {
        $tipoAeronave = 'Embraer E190';
    } elseif ($idAeronave === '4') {
        $tipoAeronave = 'Boeing 787';
    } elseif ($idAeronave === '5') {
        $tipoAeronave = 'Airbus A380';
    }


    $sql = "INSERT INTO vuelo (vueloOrigen, vueloDestino, idAeronave, tipoAeronave, fechaVuelo, vueloArribado, vuelorRuta, estado) 
            VALUES ('$vueloOrigen', '$vueloDestino', '$idAeronave', '$tipoAeronave', '$fechaVuelo', '$vueloArribado', '', '$estado')";

    if ($db->query($sql) === TRUE) {
        $insertedSuccessfully = true;

        //if succesful, send email to all users in table usuario
        $userEmailsQuery = "SELECT correo FROM Usuario WHERE activo = 1";
        $userEmailsResult = $db->query($userEmailsQuery);

        if ($userEmailsResult->num_rows > 0) {
            $subject = "Nuevo Vuelo Disponible";
            $message = "Un nuevo vuelo fue agregado, visita la página!\n";
            $message .= "Origen: $vueloOrigen\n";
            $message .= "Destino: $vueloDestino\n";
            $message .= "Número de la Aeronave: $idAeronave\n";
            $message .= "Tipo de Aeronave: $tipoAeronave\n";
            $message .= "Fecha del Vuelo: $fechaVuelo\n";
           

            // Create a new PHPMailer instance
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = ''; 
            $mail->Password = ''; 
            $mail->SMTPSecure = 'ssl'; 
            $mail->Port = 465;

           
            $mail->setFrom('proyectodesarrolloweb2023@gmail.com', 'Proyecto Desarrollo Web 2023');

            while ($userRow = $userEmailsResult->fetch_assoc()) {
                $userEmail = $userRow['correo'];

                // Clear previous recipients
                $mail->clearAddresses();

                // Add recipient
                $mail->addAddress($userEmail);

                // Set email subject and body
                $mail->Subject = $subject;
                $mail->Body = $message;

                // Send the email
                if (!$mail->send()) {
                    array_push($errors, "Error sending email to $userEmail: " . $mail->ErrorInfo);
                }
            }
        }
    } else {
        array_push($errors, "Error al insertar el vuelo: " . $db->error);
    }
}




$sql = "SELECT * FROM Vuelo";
$result = $db->query($sql);

// Check if there are any flights in the database and generate HTML USUARIOS
if ($result->num_rows > 0) {
    // Initialize a variable to store the flight divs HTML
    $flightDivs = '';

    // Loop through each vuelo and generate the HTML for each flight
    while ($row = $result->fetch_assoc()) {
        // Extract the vuelo data
        $idvuelo = $row['idVuelo'];
        $vueloOrigen = $row['vueloOrigen'];
        $vueloDestino = $row['vueloDestino'];
        $tipoAeronave = $row['tipoAeronave'];
        $fechaVuelo = $row['fechaVuelo'];
        $idAeronave = $row['idAeronave'];
        $vueloArribado = $row['vueloArribado'];


        // Generate the HTML for the flight div and append it to the $flightDivs variable
        $flightDivs .= '<div class="flight">';
        $flightDivs .= '<div class="gradient"></div>';
        $flightDivs .= '<div class="content">';

        $flightDivs .= '<div class="departuretime">'. $vueloArribado . " | " . date(" Y-m-d ", strtotime($fechaVuelo)) . '</div>';
        $flightDivs .= '<div class="flightinfo">';
        $flightDivs .= '<span>' . $vueloOrigen . '</span>';
        $flightDivs .= '<img src="../icons/airplane-takeoff.svg" alt="">';
        $flightDivs .= '<span>' . $vueloDestino . '</span>';
        $flightDivs .= '</div>';
        $flightDivs .= '<div class="flightcode"><span>Flight Number: </span>' . $idvuelo . '</div>';
        $flightDivs .= '</div>';
        $flightDivs .= '<div class="actions">';
        $flightDivs .= '<img src="../icons/airplane-plus.svg" alt="" class="save-flight" data-flight-id="' . $idvuelo . '">';
        $flightDivs .= '<img src="../icons/alarm-light-outline.svg" alt="">';
        $flightDivs .= '</div>';
        $flightDivs .= '</div>';
    }
} else {
    // Handle the case where no flights are found in the database
    $flightDivs = '<p>No hay vuelos disponibles</p>';
}




$sql = "SELECT * FROM Vuelo";
$resultado = $db->query($sql);
// Check if there are any flights in the database and generate HTML ADMIN
if ($resultado->num_rows > 0) {
    // Initialize a variable to store the flight divs HTML
    $flightDivsAdmin = '';

    // Loop through each vuelo and generate the HTML for each flight
    while ($row = $resultado->fetch_assoc()) {
        // Extract the vuelo data
        $idvuelo = $row['idVuelo'];
        $vueloOrigen = $row['vueloOrigen'];
        $vueloDestino = $row['vueloDestino'];
        $tipoAeronave = $row['tipoAeronave'];
        $fechaVuelo = $row['fechaVuelo'];
        $idAeronave = $row['idAeronave'];

        // Generate the HTML for the flight div and append it to the $flightDivsAdmin variable
        $flightDivsAdmin .= '<div class="flight">';
        $flightDivsAdmin .= '<div class="gradient"></div>';
        $flightDivsAdmin .= '<div class="content">';

        $flightDivsAdmin .= '<div class="departuretime">' . date("g:i a | Y-m-d ", strtotime($fechaVuelo)) . '</div>';
        $flightDivsAdmin .= '<div class="flightinfo">';
        $flightDivsAdmin .= '<span>' . $vueloOrigen . '</span>';
        $flightDivsAdmin .= '<img src="../icons/airplane-takeoff.svg" alt="">';
        $flightDivsAdmin .= '<span>' . $vueloDestino . '</span>';
        $flightDivsAdmin .= '</div>';
        $flightDivsAdmin .= '<div class="flightcode"><span>Flight Number: </span>' . $idvuelo . '</div>';
        $flightDivsAdmin .= '</div>';
        $flightDivsAdmin .= '</div>';
    }
} else {
    // Handle the case where no flights are found in the database
    $flightDivsAdmin = '<p>No hay vuelos disponibles</p>';
}




//DELETE VUELO
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

  
    $db->begin_transaction();

    
    $deleteGuardadoQuery = "DELETE FROM vueloguardado WHERE idvuelo = ?";
    $stmtGuardado = $db->prepare($deleteGuardadoQuery);
    $stmtGuardado->bind_param("i", $id);

    $deleteVueloQuery = "DELETE FROM vuelo WHERE idVuelo = ?";
    $stmtVuelo = $db->prepare($deleteVueloQuery);
    $stmtVuelo->bind_param("i", $id);

   
    if ($stmtGuardado->execute() && $stmtVuelo->execute()) {
        
        $db->commit();

        header("Location: modify_vuelo.php");
        $deletedSuccessfully = true; // Show success message
        // Deletion successful, redirect back to the page
        exit();
    } else {
     
        $db->rollback();

        // Error occurred, handle it accordingly
        echo "Error deleting record: " . $stmtGuardado->error . " | " . $stmtVuelo->error;
    }

    // Close the prepared statements
    $stmtGuardado->close();
    $stmtVuelo->close();
}


// UPDATE VUELO
if (isset($_POST['actualizar_vuelo'])) {
    $idVuelo = $_POST['id'];

    // Get data from the form fields
    $vueloOrigen = $_POST['vueloOrigen'];
    $vueloDestino = $_POST['vueloDestino'];
    $idAeronave = $_POST['idAeronave'];
    $fechaVuelo = $_POST['fechaVuelo'];
    $vueloArribado = $_POST['vueloArribado'];
    $estado = $_POST['estado'];

    // Update query
    $updateQuery = "UPDATE Vuelo SET vueloOrigen='$vueloOrigen', vueloDestino='$vueloDestino', 
                    idAeronave='$idAeronave', fechaVuelo='$fechaVuelo', vueloArribado='$vueloArribado', 
                    estado='$estado' WHERE idVuelo='$idVuelo'";

    if ($db->query($updateQuery)) {
        // Update successful, you can redirect or display a success message
        //if succesful, send email to all users in table usuario
        $userEmailsQuery = "SELECT correo FROM Usuario WHERE activo = 1";
        $userEmailsResult = $db->query($userEmailsQuery);

        if ($userEmailsResult->num_rows > 0) {
            $subject = "Vuelo Actualizado";
            $message = "Un vuelo fue actualizado, visita la página!\n";
            $message .= "Id del vuelo: $idVuelo\n"; 
            $message .= "Origen: $vueloOrigen\n";
            $message .= "Destino: $vueloDestino\n";
            $message .= "Número de la Aeronave: $idAeronave\n";
            $message .= "Tipo de Aeronave: $tipoAeronave\n";
            $message .= "Fecha del Vuelo: $fechaVuelo\n";
            // Include other flight details in the message

            // Create a new PHPMailer instance
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'proyectodesarrolloweb2023@gmail.com'; // Replace with your email
            $mail->Password = 'bllswkgcqcjyeasb'; // Replace with your email password
            $mail->SMTPSecure = 'ssl'; // Use 'ssl' if required by your SMTP server
            $mail->Port = 465;

            // Set the 'from' address
            $mail->setFrom('proyectodesarrolloweb2023@gmail.com', 'Proyecto Desarrollo Web 2023');

            while ($userRow = $userEmailsResult->fetch_assoc()) {
                $userEmail = $userRow['correo'];

                // Clear previous recipients
                $mail->clearAddresses();

                // Add recipient
                $mail->addAddress($userEmail);

                // Set email subject and body
                $mail->Subject = $subject;
                $mail->Body = $message;

                // Send the email
                if (!$mail->send()) {
                    array_push($errors, "Error sending email to $userEmail: " . $mail->ErrorInfo);
                }
            }
        }
        $modifiedSuccessfully = true;
    } else {
        // Update failed, handle the error
        echo "Error updating flight data: " . $db->error;
    }
}






//AREONAVE
//Add aeronave
if (isset($_POST["agregar_aeronave"])) {
    // Database connection parameters


    // Get the highest idaeronave value
    $sql_max_id = "SELECT MAX(idaeronave) as max_id FROM aeronave";
    $result = $db->query($sql_max_id);
    $row = $result->fetch_assoc();
    $next_id = $row["max_id"] + 1;

    // Get form data
    $tipoAeronave = $_POST["tipoAeronave"];
    $rangoAltitud = $_POST["rangoAltitud"];
    $rangoVelocidad = $_POST["rangoVelocidad"];

    
    $stmt = $db->prepare("INSERT INTO aeronave (idaeronave, tipoAeronave, rangoAltitud, rangoVelocidad) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $next_id, $tipoAeronave, $rangoAltitud, $rangoVelocidad);

    // Execute the statement
    if ($stmt->execute()) {
        $inserted = true;
    } else {
        echo "Error: " . $stmt->error;
    }
}





//AEROPUERTO
//Add aeropuerto
if (isset($_POST['agregar_aeropuerto'])) {
    // This is for adding a new record
    $idAeropuerto = $_POST['idAeropuerto'];
    $ciudadAeropuerto = $_POST['ciudadAeropuerto'];

    // Check if the data already exists in the database
    $checkSql = "SELECT idAeropuerto FROM aeropuerto WHERE idAeropuerto = '$idAeropuerto'";
    $checkResult = $db->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Data already exists, show an error
        $error = "Aeropuerto con ID '$idAeropuerto' ya existe.";
        array_push($errors, $error);
    } else {
        // Data doesn't exist, proceed with insertion
        $sql = "INSERT INTO aeropuerto (idAeropuerto, ciudadAeropuerto) VALUES ('$idAeropuerto', '$ciudadAeropuerto')";
        
        if ($db->query($sql) === TRUE) {
            $inserted = true;
        } else {
            array_push($errors, "Error: " . $sql . "<br>" . $db->error);
        }
    }
} else {
    // echo "Invalid request";
}








