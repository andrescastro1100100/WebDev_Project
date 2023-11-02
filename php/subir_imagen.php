<?php
include('server.php');

if (isset($_POST['subir_imagen'])) {
    $imagen = $_FILES['imagen'];
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];

    // Directorio donde se guardarán las imágenes
    $directorio_destino = 'ruta/del/directorio/'; // Cambia esto a tu directorio deseado

    // Mover la imagen al directorio de destino
    $ruta_destino = $directorio_destino . $imagen_nombre;
    move_uploaded_file($imagen_tmp, $ruta_destino);

    // Actualizar la ruta de la imagen en la base de datos
    $correoCliente = $_SESSION['correoCliente'];
    $actualizarImagenQuery = "UPDATE Usuario SET imagen_perfil = '$ruta_destino' WHERE correo = '$correoCliente'";
    mysqli_query($db, $actualizarImagenQuery);
}
?>
