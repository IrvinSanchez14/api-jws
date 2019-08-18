<?php

include_once '../config/database.php';
include_once '../api/objects/user.php';


$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if (empty($_GET['user_id'])) { //nos envia las variable mediante metodo GET para verificar si existe, sino nos redirecciona
	header('Location: index.php');
}

if (empty($_GET['token'])) { //nos envia las variable mediante metodo GET para verificar si existe, sino nos redirecciona
	header('Location: index.php');
}

$user_id = $_GET['user_id']; //se obtiene el id
$token = $_GET['token']; //se obtiene el token

if (!$user->verificaTokenPass($user_id, $token)) //aqui se verifica que existan estos datos en la BD mediante la funcion verificaTokenPass
{
	echo 'No se pudo verificar los Datos';
	exit;
}
// si toda la verificaion pasa, se carga el formulario html de abajo, en este formulario se esta enviado el id y el token en campos ocultos

?>

<html>

<head>
	<title>Cambiar Password</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/mycss.css">
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</head>

<body>

	<div class="container">
		<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="panel panel-info">
				<div class="card-panel grey darken-4">
					<div class="panel-title white-text text-darken-2">Cambiar Password</div>
					<!--<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php">Iniciar Sesi&oacute;n</a></div>-->
				</div>

				<div style="padding-top:30px" class="panel-body">

					<form id="loginform" class="form-horizontal" role="form" action="guarda_pass.php" method="POST" autocomplete="off">

						<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" />

						<input type="hidden" id="token" name="token" value="<?php echo $token; ?>" />

						<div class="form-group">
							<label for="password" placerholer="Nueva Password" class="col-md-3 control-label">Nueva contraseña</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="password" placeholder="Password" required style="color:#16a085;">
							</div>
						</div>

						<div class="form-group">
							<label for="con_password" placerholer="Confirmar Password" class="col-md-3 control-label">Confirmar contraseña</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="con_password" placeholder="Confirmar Password" required style="color:#16a085;">
							</div>
						</div>

						<div style="margin-top:10px" class="form-group">
							<div class="col-sm-12 controls">
								<button id="btn-login" type="submit" class="btn waves-effect waves-light" >Modificar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>