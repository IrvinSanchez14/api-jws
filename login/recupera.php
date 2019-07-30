<?php
	
	require 'funcs/conexion.php';//se llama la conexion
	include 'funcs/funcs.php';//se llaman las funciones
	
	session_start();
	
	if(isset($_SESSION["id_usuario"])){
		header("Location: welcome.php");
	}
	
	$errors = array();//como en los demas, esta variable almacena los errores
	
	if(!empty($_POST))//aqui se valida si se envio el post
	{
		$email = $mysqli->real_escape_string($_POST['email']);//se recibe el correo electronico ingresado
		
		if(!isEmail($email))//aqui se valida si es un email valido mediante la funcion isEmail
		{
			$errors[] = "Debe ingresar un correo electronico valido";
		}
		
		if(emailExiste($email))//aqui validamos si el correo electronico existe en la BD mediante la funcion emailExiste
		{			
			$user_id = getValor('id', 'correo', $email);//llamo el id en una variable y le digo que campo quiero (id) mediante que lo quiero filtrar (correo) y cual es el valor ($email)
			$nombre = getValor('nombre', 'correo', $email);//mismo comentario de arriba
			
			$token = generaTokenPass($user_id);//genero un token para enviar mediante el correo electronico por medio de la funcion generaTokenPass
			//se procede a creal la URL al igual como se hizo cuando se registra un usuario
			$url = /*$_SERVER["http://localhost:8080"].*/'http://localhost:8080/login/cambia_pass.php?user_id='.$user_id.'&token='.$token;//la url redirecciona a cambia_pass.php + el id del usuario y el token generado
			
			$asunto = 'Recuperar Password - Sistema de Usuarios';
			$cuerpo = "Hola $nombre: <br /><br />Se ha solicitado un reinicio de contrase&ntilde;a. <br/><br/>Para restaurar la contrase&ntilde;a, hacer clic en el siquiente link: <a href='$url'>Cambiar Password</a>";
			
			if(enviarEmail($email, $nombre, $asunto, $cuerpo)){
				echo "Hemos enviado un correo electronico a las direcion $email para restablecer tu password.<br />";
				echo "<a href='index.php' >Iniciar Sesion</a>";
				exit;
			}
			} else {
			$errors[] = "La direccion de correo electronico no existe";
		}
	}
	
?>
<html>
	<head>
		<title>Recuperar Password</title>
		
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		
	</head>
	
	<body>
		
		<div class="container">    
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Recuperar Password</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php">Iniciar Sesi&oacute;n</a></div>
					</div>     
					
					<div style="padding-top:30px" class="panel-body" >
						
						<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
						
						<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="email" type="email" class="form-control" name="email" placeholder="email" required>                                        
							</div>
							
							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<button id="btn-login" type="submit" class="btn btn-success">Enviar</a>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										No tiene una cuenta! <a href="registro.php">Registrate aquí</a>
									</div>
								</div>
							</div>    
						</form>
						<?php echo resultBlock($errors); ?>
					</div>                     
				</div>  
			</div>
		</div>
	</body>
</html>							