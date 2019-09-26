<?php

include_once '../config/database.php';
include_once '../api/objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

//se reciben los campos del formulario cambia_pass.php
$user_id = $_POST['user_id']; //este campo esta oculto en el formulario
$token = $_POST['token']; //este campo esta oculto en el formulario
$password = $_POST['password'];
$con_password = $_POST['con_password'];


if ($user->validaPassword($password, $con_password)) //aqui validamos que la nueva pass y la confimracion de pass sean iguales mediante la funcion validaPassword
{
	$pass_hash = $user->hashPassword($password); //aqui se genra el hash del password para hacer el upddate a la base

	if ($user->cambiaPassword($pass_hash, $user_id, $token)) //aqui validamos que si todo salio correctamente nos muestre el mensaje que se modifico la contraseña
	{
		echo "Contrase&ntilde;a Modificada <br> <a href='http://lapizzeria.restaurantesivar.com/' >Iniciar Sesion</a>";
	} else {

		echo "Error al modificar contrase&ntilde;a";
	}
} else {

	echo 'Las contraseñas no coinciden';
}
