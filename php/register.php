<?php include('server.php') ?>
<!DOCTYPE html>
<html>

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

<!-- Form to Register new Usuario and Cliente info -->
    <div class="form-container">
        <div class="form-header">
            Registration
        </div>
        <form method="post" action="register.php">

            <?php include('errors.php'); ?>
            <div class="input-group">
                <label>Nombre</label>
                <input style="padding-left: 1px;"  type="text" name="nombre" maxlength = "30"  >
            </div>
            <div class="input-group">
                <label>Apellido</label>
                <input style="padding-left: 1px;"  type="text" name="apellido" maxlength = "30" >
            </div>
            <div class="input-group">
                <label>Cedula</label>
                <input style="padding-left: 1px;"  type="text" name="cedula" maxlength = "9" pattern="\d{1,9}" oninput="restrictInput(this)"  title="Please enter a 9-digit number" >
            </div>

            <div class="input-group">
                <label>Fecha de Nacimiento </label>
                <input style="padding-left: 1px;"  type="date" id="star" name="fechaNacimiento" value="" max="" required />
            </div>

            <div class="input-group">
                <label>Email</label>
                <input style="padding-left: 1px;"  type="email" name="correoCliente" maxlength = "100" >
            </div>
            <div class="input-group">
                <label>Contraseña</label>
                <input style="padding-left: 1px;"  type="password" name="clave_1" maxlength = "15" >
            </div>
            <div class="input-group">
                <label>Confirme su contraseña</label>
                <input style="padding-left: 1px;"  type="password" name="clave_2" maxlength = "15" >
            </div>
            <div class="input-group">
                <button type="submit" class="btn btn-outline-primary" name="reg_user">Register</button>
            </div>
            <p>
                Already a member of FlighTracker? <a href="login.php">Sign in</a>
            </p>


        </form>
    </div>
    <script > 
        function restrictInput(input) {
            input.value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            if (input.value.length > 9) {
                input.value = input.value.substr(0, 9); // Limit to 9 characters
            }
        }
    </script>

</body>

</html>