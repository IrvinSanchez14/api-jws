<?php

require 'funcs/conexion.php'; //agregar conexión 
require 'funcs/funcs.php'; //agregar funciones

$errors = array(); //variable para capturar todos los errores

if (!empty($_POST)) //validacion de existencia del post, si hay un post valida lo que esta adentro del if
{
	$nombre = $mysqli->real_escape_string($_POST['nombre']);	//real_escape_string es una funcion de mysqli para ayudar a limpiar la cadena que se recibe
	$usuario = $mysqli->real_escape_string($_POST['usuario']);	//mediante el metodo post, esto solo para evitar el sql injection
	$password = $mysqli->real_escape_string($_POST['password']);	//todos estos elementos se reciben del formulario
	$con_password = $mysqli->real_escape_string($_POST['con_password']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);

	$activo = 0; //dato quemado para indicar que el usuario creado este desactivado
	$tipo_usuario = 2; //tipo de usuario, el usuario administrador(1) solo se crea en la base 
	$secret = '6LcpIrAUAAAAAOB67fOPjsHhz0laOGgoXdrWJOuQ'; //clave secreta del captcha para la comunicación entre el sitio y reCAPTCHA.

	if (!$captcha) { //esto solo valida si el captcha fue seleccionado
		$errors[] = "Por favor verifica el captcha"; //el error se almacena en la variable $errors
	}

	if (isNull($nombre, $usuario, $password, $con_password, $email)) //valida si hay campos vacios
	{
		$errors[] = "Debe llenar todos los campos"; //error se almacena en variable de errores $errors
	}

	if (!isEmail($email)) //se presede de un signo ! ya que en la funcion "isEmail" valida si el campo correo es valido returna true
	{
		$errors[] = "Dirección de correo inválida";
	}

	if (!validaPassword($password, $con_password)) //valida si coinciden las contraseñas mediante la funcion validaPassword
	{
		$errors[] = "Las contraseñas no coinciden";
	}

	if (usuarioExiste($usuario)) //valida si el usuario ya existe en la BD por medio de la funcion usuarioExiste
	{
		$errors[] = "El nombre de usuario $usuario ya existe";
	}

	if (emailExiste($email)) //se valida si el correo ya existe en la BD por medio de la funcion emailExiste
	{
		$errors[] = "El correo electronico $email ya existe";
	}

	if (count($errors) == 0) //aqui se cuentan si existen errores almacenados en la variable $errors, si es igual a 0 es porque no hay errores
	{
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha"); //variable $response es para validar el captcha direcamente en google, en la url enviamos nuestros datos los cuales son $secret y $captcha

		$arr = json_decode($response, TRUE); //nos regresa un json

		if ($arr['success']) //aqui mediante un if validamos que lo que nos regresa google sea correcto
		{

			$pass_hash = hashPassword($password); //lo llamamos en la variable $pass_hash y le enviamos el password "$password"
			$token = generateToken(); //lo mismo para la variable token, al agregar un nuevo usuario se le crea un token unico

			$registro = registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario); //se llama a la funcion registraUsuario para crear al usuario en la BD

			if ($registro > 0) //si el registro es > 0 significa que se registro correctamente porque nos retornaria el ID
			{
				//aqui inicia el devergue para enviar al correo el link de activar el usuario
				$url = /*'http://'.$_SERVER["http://localhost:8080"].*/ 'http://localhost/tesis/api-jws/login/activar.php?id=' . $registro . '&val=' . $token; //saco el nombre del servidor donde estoy, en este caso localhost,le digo que vaya al script activar.php
				//a este script le voy a enviar por metodo get el id del registro que obtuve y el token dentro de la variable $token
				$asunto = 'Activar Cuenta - Sistema de Usuarios'; //este es el asunto del correo electronico
				$cuerpo = "Estimado $nombre: <br /><br />Para continuar con el proceso de registro, es indispensable de click en el siguiente link <a href='$url'>Activar Cuenta</a>"; //cueroi del correo electronico

				if (enviarEmail($email, $nombre, $asunto, $cuerpo)) { //aqui se valida si el correo se envio correctamente

					echo "Para terminar el proceso de registro siga las instrucciones que le hemos enviado la direccion de correo electronico: $email";

					echo "<br><a href='index.php' >Iniciar Sesion</a>";
					exit; //para que se corte el script y no siga con todo lo demas y no me muestre todo el formulario otra vez, pero si hay errores si va a seguir

				} else { //si el correo no fue enviado correcatamen se alamcena el error en la viarable $errors
					$erros[] = "Error al enviar Email";
				}
			} else { //sino se pudo registrar, se alamacena el error en la variable $errors
				$errors[] = "Error al Registrar";
			}
		} else { //si no se selecciona el captcha, el error se alamcena en la variable
			$errors[] = 'Error al comprobar Captcha';
		}
	}
}

?>
<html>

<head>
	<title>Registro</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<script src="js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
	<div class="container">
		<div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Reg&iacute;strate</div>
					<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="index.php">Iniciar Sesi&oacute;n</a></div>
				</div>

				<div class="panel-body">

					<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

						<div id="signupalert" style="display:none" class="alert alert-danger">
							<p>Error:</p>
							<span></span>
						</div>

						<div class="form-group">
							<label for="nombre" class="col-md-3 control-label">Nombre:</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php if (isset($nombre)) echo $nombre; ?>" required>
							</div>
						</div>

						<div class="form-group">
							<label for="usuario" class="col-md-3 control-label">Usuario</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php if (isset($usuario)) echo $usuario; ?>" required>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="col-md-3 control-label">Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="password" placeholder="Password" required>
							</div>
						</div>

						<div class="form-group">
							<label for="con_password" class="col-md-3 control-label">Confirmar Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="con_password" placeholder="Confirmar Password" required>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="col-md-3 control-label">Email</label>
							<div class="col-md-9">
								<input type="email" class="form-control" name="email" placeholder="Email" value="<?php if (isset($email)) echo $email; ?>" required>
							</div>
						</div>

						<div class="form-group">
							<label for="captcha" class="col-md-3 control-label"></label>
							<div class="g-recaptcha col-md-9" data-sitekey="6LcpIrAUAAAAABhcpK9o_xNhneMtpKqiRfrV7TX9
"></div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-3 col-md-9">
								<button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Registrar</button>
							</div>
						</div>
					</form>
					<?php echo resultBlock($errors); //aqui llamamos la funcion para mostrar los errores 
					?>
				</div>
			</div>
		</div>
	</div>
</body>

</html>