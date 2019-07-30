<?php
	
	require 'funcs/conexion.php';
	require 'funcs/funcs.php';
	//se reciben los campos del formulario cambia_pass.php
	$user_id = $mysqli->real_escape_string($_POST['user_id']);//este campo esta oculto en el formulario
	$token = $mysqli->real_escape_string($_POST['token']);//este campo esta oculto en el formulario
	$password = $mysqli->real_escape_string($_POST['password']);
	$con_password = $mysqli->real_escape_string($_POST['con_password']);
	
	if(validaPassword($password, $con_password))//aqui validamos que la nueva pass y la confimracion de pass sean iguales mediante la funcion validaPassword
	{
		
		$pass_hash = hashPassword($password);//aqui se genra el hash del password para hacer el upddate a la base
		
		if(cambiaPassword($pass_hash, $user_id, $token))//aqui validamos que si todo salio correctamente nos muestre el mensaje que se modifico la contraseña
		{
			echo "Contrase&ntilde;a Modificada <br> <a href='index.php' >Iniciar Sesion</a>";
			} else {
			
			echo "Error al modificar contrase&ntilde;a";
			
		}
		
		} else {
		
		echo 'Las contraseñas no coinciden';
		
	}
	
?>	