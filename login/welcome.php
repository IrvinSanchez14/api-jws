<?php
	session_start();//estamos indicando que vamos a iniciar la sesion o reanudar una sesion activa
	require 'funcs/conexion.php';//se llama la conexion
	include 'funcs/funcs.php';//se llaman las funciones
	
	if(!isset($_SESSION["id_usuario"])){ //se valida que el usuario haya iniciado sesion, esto es para evitar ingresar al sistema mediante url
		header("Location: index.php");//Si no se ha iniciado sesión redirecciona a index.php
	}
	
	$idUsuario = $_SESSION['id_usuario'];
	
	$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'";//este query es solo para concer el id y el nombre del usuario
	$result = $mysqli->query($sql);//se ejeucta la query
	
	$row = $result->fetch_assoc();//se traen todos los resultados a la variable $row mediante un fecth asociativo
?>

<html>
	<head>
		<title>Bienvenido</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		
		<style>
			body {
			padding-top: 20px;
			padding-bottom: 20px;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			
			<nav class='navbar navbar-default'>
				<div class='container-fluid'>
					<div class='navbar-header'>
						<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
							<span class='sr-only'>Men&uacute;</span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
						</button>
					</div>
					
					<div id='navbar' class='navbar-collapse collapse'>
						<ul class='nav navbar-nav'>
							<li class='active'><a href='welcome.php'>Inicio</a></li>			
						</ul>
						
						<?php if($_SESSION['tipo_usuario']==1) { ?>
							<ul class='nav navbar-nav'>
								<li><a href='#'>Administrar Usuarios</a></li>
							</ul>
						<?php } ?>
						
						<ul class='nav navbar-nav navbar-right'>
							<li><a href='logout.php'>Cerrar Sesi&oacute;n</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<div class="jumbotron">
				<h2><?php echo 'Bienvenid@ '.utf8_decode($row['nombre']); ?></h1>
				<br />
			</div>
		</div>
	</body>
</html>		