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
                  Estado = :Estado";
    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $this->Alias = htmlspecialchars(strip_tags($this->Alias));
    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));
    $this->Passwd = htmlspecialchars(strip_tags($this->Passwd));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':Alias', $this->Alias);
    $stmt->bindParam(':IdTipoUsuario', $this->IdTipoUsuario);
    $stmt->bindParam(':Estado', $this->Estado);

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

  function emailExists()
  {
    $query = "SELECT IdUsuario, Nombre, Alias, Passwd,IdTipoUsuario
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

  function verUsuarios()
  {
    $query = "SELECT 
                u.IdUsuario, u.Nombre AS Nombre, u.Email, u.Alias, tu.Nombre AS IdTipoUsuario,if(u.Estado = 0, 'Disponible','Inactivo')AS estadoTexto, u.FechaCreacion FROM usuarios u
              LEFT JOIN 
                tipos_usuario tu ON u.IdTipoUsuario=tu.IdTipoUsuario
              ORDER BY
                u.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function generateToken()//funcion para generar el token
	{
		$gen = md5(uniqid(mt_rand(), false));//mt_rand nos genera un valor dependiendo la hora y fecha del sistema, uniqid genera un identificador y luego lo pasa a md5
		return $gen;
	}

  function generaTokenPass($user_id, $token)//esta funcion genera un token al solicitar cambio de password
	{	
		//se llama la funcion que genera los token pero luego hace un update 
		
    $query = "UPDATE usuarios SET PasswdTmp=?, password_request=1 WHERE IdUsuario = ?";//este query coloca el token generado en la BD ademas de hacer el update al campo password_request
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $token);
    $stmt->bindParam(2, $user_id);
    if ($stmt->execute()) {
      return true;
    }
    return false;
	}


}
