<?php
class User
{
  private $conn;
  private $table_name = "usuarios";
  public $IdUsuario;
  public $Nombre;
  public $Alias;
  public $IdTipoUsuario;
  public $Email;
  public $Passwd;
  public $IdPermiso;
  public $Estado;
  public $activacion;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
              SET
                  Nombre = :Nombre,
                  Email = :Email,
                  Alias = :Alias,
                  IdTipoUsuario = :IdTipoUsuario,
                  Passwd = :Passwd,
                  Estado = :Estado,
                  activacion= :activacion";
    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $this->Alias = htmlspecialchars(strip_tags($this->Alias));
    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));
    $this->Passwd = htmlspecialchars(strip_tags($this->Passwd));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->activacion = htmlspecialchars(strip_tags($this->activacion));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':Alias', $this->Alias);
    $stmt->bindParam(':IdTipoUsuario', $this->IdTipoUsuario);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':activacion', $this->activacion);

    $password_hash = password_hash($this->Passwd, PASSWORD_BCRYPT);
    $stmt->bindParam(':Passwd', $password_hash);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }




  function update()
  {
    $query = "UPDATE " . $this->table_name . "
              SET
                  Nombre = :Nombre,
                  Email = :Email,
                  Alias = :Alias,
                  IdTipoUsuario = :IdTipoUsuario,
                  UsuarioActualiza=:UsuarioActualiza
              WHERE
                  IdUsuario=:IdUsuario";
    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $this->Alias = htmlspecialchars(strip_tags($this->Alias));
    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));
    $this->IdUsuario = htmlspecialchars(strip_tags($this->IdUsuario));


    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':Alias', $this->Alias);
    $stmt->bindParam(':IdTipoUsuario', $this->IdTipoUsuario);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);
    $stmt->bindParam(':IdUsuario', $this->IdUsuario);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function updateUsuarioSucursal()
  {
    $query = "UPDATE usuario_sucursal
    SET
        IdSucursal = :IdSucursal,
        UsuarioActualiza = :UsuarioActualiza
        WHERE
          IdUsuario=:IdUsuario";
    $stmt = $this->conn->prepare($query);
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));
    $this->IdUsuario = htmlspecialchars(strip_tags($this->IdUsuario));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));

    $stmt->bindParam(':IdSucursal', $this->IdSucursal);
    $stmt->bindParam(':IdUsuario', $this->IdUsuario);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function emailExists()
  {
    $query = "SELECT IdUsuario, Nombre, Alias, Passwd, IdTipoUsuario, activacion
              FROM " . $this->table_name . "
              WHERE Email = ?
              LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $stmt->bindParam(1, $this->Email);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->IdUsuario = $row['IdUsuario'];
      $this->Nombre = $row['Nombre'];
      $this->Alias = $row['Alias'];
      $this->Passwd = $row['Passwd'];
      $this->IdTipoUsuario = $row['IdTipoUsuario'];
      $this->activacion = $row['activacion'];
      return true;
    }
    return false;
  }

  function permisosUsuarios()
  {
    $query = "SELECT t2.IdPermiso, t2.Nombre, t2.Estado FROM  permisos_usuarios t1
                LEFT JOIN permisos t2 ON t1.IdPermiso=t2.IdPermiso
                LEFT JOIN usuarios t3 ON t1.Idusuario=t3.IdUsuario
                WHERE t3.IdUsuario= ?";

    $stmt = $this->conn->prepare($query);
    $this->IdUsuario = htmlspecialchars(strip_tags($this->IdUsuario));
    $stmt->bindParam(1, $this->IdUsuario);
    $stmt->execute();
    return $stmt;
  }



  function createUsuarioSucursal()
  {
    $query = "INSERT INTO usuario_sucursal
    SET
        IdSucursal = :IdSucursal,
        IdUsuario = :IdUsuario,
        UsuarioCreador = :UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));
    $this->IdUsuario = htmlspecialchars(strip_tags($this->IdUsuario));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':IdSucursal', $this->IdSucursal);
    $stmt->bindParam(':IdUsuario', $this->IdUsuario);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function verUsuarios()
  {
    $query = "SELECT 
                u.IdUsuario, u.Nombre AS Nombre, u.Email, u.Alias, tu.Nombre AS IdTipoUsuario,if(u.Estado = 0, 'Disponible','Inactivo')AS estadoTexto, u.FechaCreacion,
                if(us.IdSucursal != 0, t1.Nombre, 'Sin asignacion de sucursal')AS Sucursal
              FROM 
                usuarios u
              LEFT JOIN 
                tipos_usuario tu ON u.IdTipoUsuario=tu.IdTipoUsuario
              LEFT JOIN 
                usuario_sucursal us ON u.IdUsuario = us.IdUsuario
              LEFT JOIN 
                sucursales t1 ON us.IdSucursal=t1.IdSucursal
              ORDER BY
                u.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function generateToken() //funcion para generar el token
  {
    $gen = md5(uniqid(mt_rand(), false)); //mt_rand nos genera un valor dependiendo la hora y fecha del sistema, uniqid genera un identificador y luego lo pasa a md5
    return $gen;
  }

  function randomPassword()
  {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }

  function generaTokenPass($user_id, $token) //esta funcion genera un token al solicitar cambio de password
  {
    //se llama la funcion que genera los token pero luego hace un update 

    $query = "UPDATE usuarios SET PasswdTmp=?, password_request=1 WHERE IdUsuario = ?"; //este query coloca el token generado en la BD ademas de hacer el update al campo password_request
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $token);
    $stmt->bindParam(2, $user_id);
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function enviarEmail($email, $nombre, $asunto, $cuerpo)
  { //funcion de enviar email, recibe el email, el nombre, asunto y cuerpo

    require_once '../../login/PHPMailer/PHPMailerAutoload.php'; //lebreria phpmailer se usa para el funcionamiento del envio de correo

    $mail = new PHPMailer();
    $mail->isSMTP(); // protocolo de transferencia de correo
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl'; //habilita la encriptacion SSL
    $mail->Host = 'smtp.gmail.com'; // Servidor GMAIL
    $mail->Port = 465; //puerto

    $mail->Username = 'lapizzeriapassrecovery@gmail.com'; //correo emisor
    $mail->Password = 'lapizzeria2019'; //contraseña del correo del emisor

    $mail->setFrom('lapizzeriapassrecovery@gmail.com', 'La Pizzeria'); //se establece quien envia el correo
    $mail->addAddress($email, $nombre); //email y nombre del receptor guardados en sus respectivas variables

    $mail->Subject = $asunto; //se configura cual es el asunto del correo
    $mail->Body    = $cuerpo; //se configura cual es el cuerpo del correo
    $mail->IsHTML(true);

    if ($mail->send())
      return true;
    else
      return false;
  }

  function verificaTokenPass($user_id, $token)
  { //esta funcion es para verificar que el ID y el token sean de un registro valido en la BD
    //ademas verifica si el usuario a solicitado el cambio de password 

    $query = "SELECT IdUsuario FROM usuarios WHERE IdUsuario = ? AND PasswdTmp = ? AND password_request = 1 LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $token);
    $stmt->execute();
    $num = $stmt->rowCount();

    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->IdUsuario = $row['IdUsuario'];
      if ($this->IdUsuario = $row['IdUsuario']) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  function validaPassword($var1, $var2) //funcion para validar el password y la confirmacion de pasword sean iguales
  {
    if (strcmp($var1, $var2) !== 0) { //strcmp hace una comparacion de datos string
      return false;
    } else {
      return true;
    }
  }

  function hashPassword($password) //funcion para "encriptar contraseña"
  {
    $hash = password_hash($password, PASSWORD_DEFAULT); //password_hash($password, PASSWORD_DEFAULT) nos da el hash del password almacenado en la variable $password
    return $hash;
  }

  function cambiaPassword($password, $user_id, $token)
  { //esta funcion hace el update de la nueva password y de los otros campos

    //la query actualiza la contraseña y cambia el campo password_request a 0 y el token_password lo limpia
    $query = "UPDATE usuarios SET Passwd = ?, PasswdTmp='', password_request=0 WHERE IdUsuario = ? AND PasswdTmp = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $password);
    $stmt->bindParam(2, $user_id);
    $stmt->bindParam(3, $token);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function renuevaPassword($password, $user_id)
  { //esta funcion hace el update de la nueva password y de los otros campos

    //la query actualiza la contraseña y cambia el campo password_request a 0 y el token_password lo limpia
    $query = "UPDATE usuarios SET Passwd = ?,  activacion=0 WHERE IdUsuario = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(2, $user_id);

    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bindParam('1', $password_hash);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
