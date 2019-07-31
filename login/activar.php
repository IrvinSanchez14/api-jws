<?php
	
	require 'funcs/conexion.php';//llamamos la conexion
	require 'funcs/funcs.php';//llamamos las funciones
	
	if(isset($_GET["id"]) AND isset($_GET['val']))//validamos con el if que nos este enviando los datos por metodo get (id y el valor,el valor es el token unico del usuario)
	{
		
		$idUsuario = $_GET['id'];
		$token = $_GET['val'];
		
		$mensaje = validaIdToken($idUsuario, $token);	//aqui se valida si el token existe en la BD por medio de la funcion validaToken
	}//luego en el html de abajo es solo para mostrar el mensaje y redireccionar al index.php
?>

<html>
	<head>
		<title>Registro</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		
	</head>
	
	<body>
		<div class="container">
			<div class="jumbotron">
				
				<h1><?php echo $mensaje; ?></h1>
				
				<br />
				<p><a class="btn btn-primary btn-lg" href="index.php" role="button">Iniciar Sesi&oacute;n</a></p>
			</div>
		</div>
	</body>
</html>														