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

if (isset($_POST['update_usuario'])) {
    $nuevoNombre = mysqli_real_escape_string($db, $_POST['nombre_usuario']);
    $nuevoApellido = mysqli_real_escape_string($db, $_POST['apellido_usuario']);
    $correoCliente = $_SESSION['correoCliente'];

    $updateQuery = "UPDATE Cliente SET nombre = '$nuevoNombre', apellido = '$nuevoApellido' WHERE idcedula IN (SELECT idcedula FROM Usuario WHERE correo = '$correoCliente')";

    if (mysqli_query($db, $updateQuery)) {
        $update_success = "Información actualizada exitosamente";
    } else {
        $update_error = "Error al actualizar la información: " . mysqli_error($db);
    }
}

// Obtener los datos actuales del usuario
$correoCliente = $_SESSION['correoCliente'];
$query = "SELECT nombre, apellido FROM Cliente WHERE idcedula IN (SELECT idcedula FROM Usuario WHERE correo = '$correoCliente')";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
}

if (isset($_POST['update_correo'])) {
    $nuevoCorreo = mysqli_real_escape_string($db, $_POST['nuevo_correo']);
    $correoCliente = $_SESSION['correoCliente'];

    // Verificar si el nuevo correo no está en uso por otro usuario
    $correoCheckQuery = "SELECT idcedula FROM Usuario WHERE correo = '$nuevoCorreo' LIMIT 1";
    $correoCheckResult = mysqli_query($db, $correoCheckQuery);

    if (mysqli_num_rows($correoCheckResult) > 0) {
        $update_email_error = "El nuevo correo ya está en uso por otro usuario.";
    } else {
        $updateEmailQuery = "UPDATE Usuario SET correo = '$nuevoCorreo' WHERE correo = '$correoCliente'";

        if (mysqli_query($db, $updateEmailQuery)) {
            $_SESSION['correoCliente'] = $nuevoCorreo;
            $update_email_success = "Correo electrónico actualizado exitosamente.";
        } else {
            $update_email_error = "Error al actualizar el correo electrónico: " . mysqli_error($db);
        }
    }
}

if (isset($_POST['update_password'])) {
    $currentPassword = mysqli_real_escape_string($db, $_POST['current_password']);
    $newPassword = mysqli_real_escape_string($db, $_POST['new_password']);
    $confirmPassword = mysqli_real_escape_string($db, $_POST['confirm_password']);
    $correoCliente = $_SESSION['correoCliente'];

    // Verificar si la contraseña actual coincide
    $passwordCheckQuery = "SELECT idcedula FROM Usuario WHERE correo = '$correoCliente' AND clave = '$currentPassword' LIMIT 1";
    $passwordCheckResult = mysqli_query($db, $passwordCheckQuery);

    if (mysqli_num_rows($passwordCheckResult) == 0) {
        $update_password_error = "La contraseña actual no coincide.";
    } elseif ($newPassword !== $confirmPassword) {
        $update_password_error = "Las contraseñas nuevas no coinciden.";
    } else {
        $updatePasswordQuery = "UPDATE Usuario SET clave = '$newPassword' WHERE correo = '$correoCliente'";

        if (mysqli_query($db, $updatePasswordQuery)) {
            $update_password_success = "Contraseña actualizada exitosamente.";
        } else {
            $update_password_error = "Error al actualizar la contraseña: " . mysqli_error($db);
        }
    }
}

if (isset($_POST['cargar_imagen'])) {
    $correoCliente = $_SESSION['correoCliente'];

    $rutaDestino = 'ruta/del/directorio/'; // Ruta donde se guardarán las imágenes
    if (!is_dir($rutaDestino)) {
        mkdir($rutaDestino, 0777, true);
    }

    $nombreImagen = $_FILES['imagen_perfil']['name'];
    $rutaImagen = $rutaDestino . $nombreImagen;

    if (move_uploaded_file($_FILES['imagen_perfil']['tmp_name'], $rutaImagen)) {
        // Actualizar la columna imagen_perfil en la tabla Usuario
        $updateImagenQuery = "UPDATE Usuario SET imagen_perfil = '$rutaImagen' WHERE correo = '$correoCliente'";
        
        if (mysqli_query($db, $updateImagenQuery)) {
            $update_imagen_success = "Imagen de perfil cargada exitosamente.";
        } else {
            $update_imagen_error = "Error al cargar la imagen de perfil: " . mysqli_error($db);
        }
    } else {
        $update_imagen_error = "Error al subir la imagen de perfil.";
    }
}


// Obtener la ruta de la imagen desde la base de datos (como lo hiciste antes)
$consultaImagenQuery = "SELECT imagen_perfil FROM Usuario WHERE correo = '$correoCliente'";
$resultadoImagen = mysqli_query($db, $consultaImagenQuery);

if (mysqli_num_rows($resultadoImagen) == 1) {
    $filaImagen = mysqli_fetch_assoc($resultadoImagen);
    $rutaImagen = $filaImagen['imagen_perfil'];
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

    <?php include 'menu_cliente.php'; ?>

    <div class="flightcontent">
        <div class="text">Configuración del usuario: </div>
        <div class="flightcontainer">

            
    <form method="post" action="info_usuario.php">
    <!-- Otros campos del formulario -->
        <div class="input-group" >
            <label  for="nombre_usuario">Nombre:</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" maxlength = "30" style="width:300px" value="<?php echo $nombre; ?>" required>
        </div>

        <div class="input-group">
            <label for="apellido_usuario">Apellido:</label>
            <input type="text" name="apellido_usuario" id="apellido_usuario" maxlength = "30" style="width:300px" value="<?php echo $apellido; ?>" required>
        </div>

        <!-- Otros campos del formulario -->

        <?php if (isset($update_error)) : ?>
            <div class="input-group">
                <p class="error"><?php echo $update_error; ?></p>
            </div>
        <?php elseif (isset($update_success)) : ?>
            <div class="input-group">
                <p class="success"><?php echo $update_success; ?></p>
            </div>
        <?php endif; ?>

        <div class="input-group">
            <button type="submit" name="update_usuario">Actualizar</button>
        </div>

         </form>

         <form method="post" action="info_usuario.php">
            <div class="input-group">
                <label for="nuevo_correo">Nuevo Correo Electrónico:</label>
                <input type="email" name="nuevo_correo" style="width:350px" maxlength = "100" id="nuevo_correo" required>
            </div>

            <?php if (isset($update_email_error)) : ?>
                <div class="input-group">
                    <p class="error"><?php echo $update_email_error; ?></p>
                </div>
            <?php elseif (isset($update_email_success)) : ?>
                <div class="input-group">
                    <p class="success"><?php echo $update_email_success; ?></p>
                </div>
            <?php endif; ?>

            <div class="input-group">
                <button type="submit" name="update_correo">Actualizar Correo</button>
            </div>
        </form>
        
        <form method="post" action="info_usuario.php">
            <div class="input-group">
                <label for="current_password">Contraseña Actual:</label>
                <input type="password" name="current_password" maxlength = "15" style="width:300px" id="current_password" required>
            </div>

            <div class="input-group">
                <label for="new_password">Nueva Contraseña:</label>
                <input type="password" name="new_password" maxlength = "15" style="width:300px" id="new_password" required>
            </div>

            <div class="input-group">
                <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                <input type="password" name="confirm_password" maxlength = "15" style="width:300px" id="confirm_password" required>
            </div>

            <?php if (isset($update_password_error)) : ?>
                <div class="input-group">
                    <p class="error"><?php echo $update_password_error; ?></p>
                </div>
            <?php elseif (isset($update_password_success)) : ?>
                <div class="input-group">
                    <p class="success"><?php echo $update_password_success; ?></p>
                </div>
            <?php endif; ?>

            <div class="input-group">
                <button type="submit" name="update_password">Actualizar Contraseña</button>
            </div>
        </form>

        <form method="post" action="info_usuario.php" enctype="multipart/form-data">
    <!-- ... Tus otros campos ... -->
    <div class="input-group">
        <label for="imagen_perfil">Selecciona una imagen:</label>
        <input type="file" name="imagen_perfil" id="imagen_perfil" accept=".jpg, .jpeg, .png">
    </div>
    <div class="input-group">
        <button type="submit" name="cargar_imagen">Cargar Imagen</button>
    </div>
</form>

<!-- Dentro del <div class="flightcontent"> -->
<?php if (isset($rutaImagen)) : ?>
    <div class="input-group">
        <label>Imagen Actual de Perfil:</label>
        <button onclick="mostrarImagen('<?php echo $rutaImagen; ?>')">Mostrar Imagen</button>
    </div>
<?php endif; ?>

<!-- Agrega este script JavaScript al final de tu archivo HTML -->
<script>
    function mostrarImagen(ruta) {
        var ventana = window.open('', '', 'width=600,height=400');
        ventana.document.write('<img src="' + ruta + '" alt="Imagen de perfil" style="max-width: 100%; max-height: 100%;">');
    }
</script>

    </div>

    

    </div>

</body>

</html>