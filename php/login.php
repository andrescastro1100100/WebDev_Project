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

<div class="form-container">
	<div class="form-header">
		LOGIN
	</div>

	<!-- Form to check if data is in Usuario-Cliente or Usuario-Administrador, and the redirect to their specific dashboard -->
	<form method="post" action="login.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Correo</label>
			<input style="padding-left: 1px;"  type="text" name="correoCliente" maxlength = "100">
		</div>
		<div class="input-group">
			<label>Contraseña</label>
			<input style="padding-left: 1px; " type="password" name="clave" maxlength = "15">
		</div>
		<div class="input-group">
			<button   type="submit" class="btn btn-outline-primary" name="login_user">Login</button>
		</div>
		<p>
			Not yet a member of FlightTracker? <a href="register.php">Sign up</a>
		</p>
	</form>
</div>
</body>

</html>