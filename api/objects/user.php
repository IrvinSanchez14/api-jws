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
                  Passwd = :Passwd";
    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $this->Alias = htmlspecialchars(strip_tags($this->Alias));
    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));
    $this->Passwd = htmlspecialchars(strip_tags($this->Passwd));
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':Alias', $this->Alias);
    $stmt->bindParam(':IdTipoUsuario', $this->IdTipoUsuario);
    $password_hash = password_hash($this->Passwd, PASSWORD_BCRYPT);
    $stmt->bindParam(':Passwd', $password_hash);
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function emailExists()
  {
    $query = "SELECT IdUsuario, Nombre, Alias, Passwd
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

  public function update()
  {
    $password_set = !empty($this->password) ? ", password = :password" : "";
    $query = "UPDATE " . $this->table_name . "
              SET
                  firstname = :firstname,
                  lastname = :lastname,
                  email = :email
                  {$password_set}
              WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $this->firstname = htmlspecialchars(strip_tags($this->firstname));
    $this->lastname = htmlspecialchars(strip_tags($this->lastname));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':email', $this->email);
    if (!empty($this->password)) {
      $this->password = htmlspecialchars(strip_tags($this->password));
      $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
      $stmt->bindParam(':password', $password_hash);
    }
    $stmt->bindParam(':id', $this->id);
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}
