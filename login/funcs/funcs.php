<?php
	
	function isNull($nombre, $user, $pass, $pass_con, $email){//esta funcion valida si algun campo del formulario registro.php es nulo
		if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1)
		{
			return true;//si algun campo es nulo regresa true
			} else {
			return false;//sino regresa false
		}		
	}
	
	function isEmail($email)//funcion para validar que el correo tenga un formato valido mediante la funcion FILTER_VALIDATE_EMAIL de php
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}
	
	function validaPassword($var1, $var2)//funcion para validar el password y la confirmacion de pasword sean iguales
	{
		if (strcmp($var1, $var2) !== 0){//strcmp hace una comparacion de datos string
			return false;
			} else {
			return true;
		}
	}
	
	function minMax($min, $max, $valor){//esta funcion es solo para establecer un minimo o maximo
		if(strlen(trim($valor)) < $min)
		{
			return true;
		}
		else if(strlen(trim($valor)) > $max)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function usuarioExiste($usuario)//funcion para verificar si el usuario existe en la base
	{
		global $mysqli;// se usa la variable local mysqli para heredar la conexion
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");//query que trae el usuario y lo iguala a ? que es el valor que se esta agregando en $usuario
		$stmt->bind_param("s", $usuario);//el singo ? indica que estoy esperando un elemento, ese elemento se definde en esta linea ("s", $usuario) "s"= string
		$stmt->execute();//se ejecuta el query 
		$stmt->store_result();//se traen los resultados
		$num = $stmt->num_rows;//se verifican el numero de resultados que trae el query
		$stmt->close();//se cierra la conexion
		
		if ($num > 0){//se validan los resultados que nos trae el query, si es > 0 el usuario ya existe
			return true;
			} else {
			return false;
		}
	}
	
	function emailExiste($email)//esta funcion es igual a "usuarioExiste" pero aqui se valida si el correo ya existe
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function generateToken()//funcion para generar el token
	{
		$gen = md5(uniqid(mt_rand(), false));//mt_rand nos genera un valor dependiendo la hora y fecha del sistema, uniqid genera un identificador y luego lo pasa a md5
		return $gen;
	}
	
	function hashPassword($password)//funcion para "encriptar contraseña"
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);//password_hash($password, PASSWORD_DEFAULT) nos da el hash del password almacenado en la variable $password
		return $hash;
	}
	
	function resultBlock($errors){//esta funcion es para mostrar todos los errores almacenados en la variable $error en un div con estilo bootstrap
		if(count($errors) > 0)
		{
			echo "<div id='error' class='alert alert-danger' role='alert'>
			<a href='#' onclick=\"showHide('error');\">[X]</a>
			<ul>";
			foreach($errors as $error)//con el foreach se va recorriendo todo el array para mostrar todos los errores
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div>";
		}
	}
	
	function registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario){//esta funcion es para agregar el nuevo registro del usuario nuevo a la BD
		
		global $mysqli; //variable local que llama la conexion
		
		$stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, password, nombre, correo, activacion, token, id_tipo) VALUES(?,?,?,?,?,?,?)");//query que inserta el nuevo registro
		$stmt->bind_param('ssssisi', $usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);//ssssisi son los tipos de datos (string"s" y entero"i")
		
		if ($stmt->execute()){
			return $mysqli->insert_id;//al registrar el ususario nos regresa el id del registro (insert_id)
			} else {
			return 0;	
		}		
	}
	
	function enviarEmail($email, $nombre, $asunto, $cuerpo){//funcion de enviar email, recibe el email, el nombre, asunto y cuerpo
		
		require_once 'PHPMailer/PHPMailerAutoload.php';//lebreria phpmailer se usa para el funcionamiento del envio de correo
		
		$mail = new PHPMailer();
		$mail->isSMTP(); // protocolo de transferencia de correo
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl'; //habilita la encriptacion SSL
		$mail->Host = 'smtp.gmail.com'; // Servidor GMAIL
		$mail->Port = 465; //puerto
		
		$mail->Username = 'lapizzeriapassrecovery@gmail.com';//correo emisor
		$mail->Password = 'lapizzeria2019'; //contraseña del correo del emisor
		
		$mail->setFrom('lapizzeriapassrecovery@gmail.com', 'La Pizzeria'); //se establece quien envia el correo
		$mail->addAddress($email, $nombre);//email y nombre del receptor guardados en sus respectivas variables
		
		$mail->Subject = $asunto;//se configura cual es el asunto del correo
		$mail->Body    = $cuerpo;//se configura cual es el cuerpo del correo
		$mail->IsHTML(true);
		
		if($mail->send())
		return true;
		else
		return false;
	}
	
	function validaIdToken($id, $token){//esta funcion es para validar el token de un usuario que no esta activo
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");//query para cansultar la existencia del token 
		$stmt->bind_param("is", $id, $token);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			$stmt->bind_result($activacion);
			$stmt->fetch();
			
			if($activacion == 1){// si el campo activacion es igual a uno quiere decir que el usuario ya esta activo
				$msg = "La cuenta ya se activo anteriormente.";
				} else {//si no es igual a 1 entonces se manda a llamar a la funcion activarUsuario
				if(activarUsuario($id)){
					$msg = 'Cuenta activada.';
					} else {
					$msg = 'Error al Activar Cuenta';
				}
			}
			} else {
			$msg = 'No existe el registro para activar.';//este mensaje se muestra si no ecuentra registros
		}
		return $msg;
	}
	
	function activarUsuario($id)//esta funcion activa al usuario en la BD
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");//el query basicamente hace un update al campo activacion
		$stmt->bind_param('s', $id);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	
	function isNullLogin($usuario, $password){//funcion que valida que el usuario y la contraseña no sean nulos en el formulario
		if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function login($usuario, $password)//funcion para loguear
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id, id_tipo, password FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");//con esta query se validan credenciales del usuario
		$stmt->bind_param("ss", $usuario, $usuario);
		$stmt->execute();//se ejecuta el query
		$stmt->store_result();//traemos los resutlados
		$rows = $stmt->num_rows;//verificacomos si nos regresa algun resultado
		
		if($rows > 0) {
			
			if(isActivo($usuario)){//aqui verificamos si el usuario esta activo mediante la funcion isActivo
				
				$stmt->bind_result($id, $id_tipo, $passwd);//se traen los resultados de la consulta
				$stmt->fetch();//se traen los datos 
				
				$validaPassw = password_verify($password, $passwd);//funcion de php (password_verify)para verificar que las contraseñas coincidan ($password viene del fomurlario y $passwd viene de la BD)
				
				if($validaPassw){//aqui se dice con un if si las contraseñas con correctas, permite iniciar sesion
					
					lastSession($id);//al iniciar sesion se llama la funcion lastSession
					$_SESSION['id_usuario'] = $id;
					$_SESSION['tipo_usuario'] = $id_tipo;
					
					header("location: welcome.php");//redireccion a la pag welcome.php
					} else {
					
					$errors = "La contrase&ntilde;a es incorrecta";
				}
				} else {
				$errors = 'El usuario no esta activo';
			}
			} else {
			$errors = "El nombre de usuario o correo electr&oacute;nico no existe";
		}
		return $errors;
	}
	
	function lastSession($id)//esta funcion es para hacer un update al campo last_session cada vez que se inicia sesion
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=0 WHERE id = ?");
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$stmt->close();
	}
	
	function isActivo($usuario)//funcion para validar si el usuario esta activo
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");//mediante esta query se valida que el usuario este activo
		$stmt->bind_param('ss', $usuario, $usuario);
		$stmt->execute();
		$stmt->bind_result($activacion);
		$stmt->fetch();
		
		if ($activacion == 1)//si la validacion es 1 , regresa true indicando que el usuario esta activo
		{
			return true;
		}
		else
		{
			return false;	
		}
	}	
	
	function generaTokenPass($user_id)//esta funcion genera un token al solicitar cambio de password
	{
		global $mysqli;
		
		$token = generateToken();//se llama la funcion que genera los token pero luego hace un update 
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id = ?");//este query coloca el token generado en la BD ademas de hacer el update al campo password_request
		$stmt->bind_param('ss', $token, $user_id);
		$stmt->execute();
		$stmt->close();
		
		return $token;
	}
	
	function getValor($campo, $campoWhere, $valor)//esta funcion basicamente nos regresa un select a la BD
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");//laquery indica el campo que requerimos ($campo), el campo con el cual vamos a filtrar ($campoWhere) y el valor ($valor) 
		$stmt->bind_param('s', $valor);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($_campo);
			$stmt->fetch();
			return $_campo;
		}
		else
		{
			return null;	
		}
	}
	
	function getPasswordRequest($id)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT password_request FROM usuarios WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->bind_result($_id);
		$stmt->fetch();
		
		if ($_id == 1)
		{
			return true;
		}
		else
		{
			return null;	
		}
	}
	
	function verificaTokenPass($user_id, $token){//esta funcion es para verificar que el ID y el token sean de un registro valido en la BD
		//ademas verifica si el usuario a solicitado el cambio de password 
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
		$stmt->bind_param('is', $user_id, $token);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($activacion);
			$stmt->fetch();
			if($activacion == 1)
			{
				return true;
			}
			else 
			{
				return false;
			}
		}
		else
		{
			return false;	
		}
	}
	
	function cambiaPassword($password, $user_id, $token){//esta funcion hace el update de la nueva password y de los otros campos
		
		global $mysqli;
		//la query actualiza la contraseña y cambia el campo password_request a 0 y el token_password lo limpia
		$stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?");
		$stmt->bind_param('sis', $password, $user_id, $token);
		
		if($stmt->execute()){
			return true;
			} else {
			return false;		
		}
	}		