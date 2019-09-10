<?php
class PermisoUsuario
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

  function readUsuarios()
  {
    $query = "SELECT 
                um.IdUsuario, um.Nombre AS NombreUsuario, tu.Nombre AS NombreTipo, if(um.Estado = 0, 'Disponible','Inactivo')AS estadoTexto
              FROM
                usuarios um
              LEFT JOIN 
                tipos_usuario tu ON um.IdTipoUsuario=tu.IdTipoUsuario
              WHERE 
                um.Estado = 0 AND tu.Estado = 0
              ORDER BY
                um.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function readPermisosUsuarios()
  {
    $query = "SELECT 
                um.IdPermisosusuario, p.IdPermiso,p.Nombre
               FROM
                permisos_usuarios um
              LEFT JOIN 
                permisos p ON p.IdPermiso=um.IdPermiso
              WHERE
                um.IdUsuario=  ?
              ORDER BY
                um.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $this->IdUsuario = htmlspecialchars(strip_tags($this->IdUsuario));
    $stmt->bindParam(1, $this->IdUsuario);
    $stmt->execute();
    return $stmt;
  }

  function createPermisosUsuario()
  {
    $query = "INSERT INTO permisos_usuarios
              SET
                IdPermiso=:IdPermiso,
                IdUsuario=:IdUsuario,
                UsuarioCreador=:UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->IdPermiso = htmlspecialchars(strip_tags($this->IdPermiso));
    $this->IdUsuario = htmlspecialchars(strip_tags($this->IdUsuario));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':IdPermiso', $this->IdPermiso);
    $stmt->bindParam(':IdUsuario', $this->IdUsuario);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
              SET
                Nombre = :Nombre,
                Descripcion = :Descripcion,
                Estado = :Estado,
                UsuarioCreador = :UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function update()
  {
    $query = "UPDATE
                " . $this->table_name . "
              SET
                Nombre=:Nombre,
                Descripcion=:Descripcion,
                Estado=:Estado,
                FechaCreacion=:FechaCreacion
              WHERE
                IdPermiso=:IdPermiso";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->FechaCreacion = htmlspecialchars(strip_tags($this->FechaCreacion));
    $this->IdPermiso = htmlspecialchars(strip_tags($this->IdPermiso));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':FechaCreacion', $this->FechaCreacion);
    $stmt->bindParam(':IdPermiso', $this->IdPermiso);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM permisos_usuarios WHERE IdPermisosusuario = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdPermisosusuario = htmlspecialchars(strip_tags($this->IdPermisosusuario));

    $stmt->bindParam(1, $this->IdPermisosusuario);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function changeState()
  {
    $query = "UPDATE
                " . $this->table_name . "
              SET
                Estado=:Estado
              WHERE
                IdUsuario=:IdUsuario";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdUsuario = htmlspecialchars(strip_tags($this->IdUsuario));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdUsuario', $this->IdUsuario);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
