<?php
class Permiso
{
  private $conn;
  private $table_name = "permisos";

  public $IdPermiso;
  public $Descripcion;
  public $Nombre;
  public $Estado;
  public $FechaCreacion;
  public $UsuarioCreador;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  um.IdPermiso, um.Descripcion, um.Nombre,if(um.Estado = 0, 'Disponible','Inactivo')AS estadoTexto, um.FechaCreacion
                FROM
                  " . $this->table_name . " um
                ORDER BY
                  um.FechaActualizacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
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
                UsuarioActualiza=:UsuarioActualiza
              WHERE
                IdPermiso=:IdPermiso";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdPermiso = htmlspecialchars(strip_tags($this->IdPermiso));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdPermiso', $this->IdPermiso);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdPermiso = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdPermiso = htmlspecialchars(strip_tags($this->IdPermiso));

    $stmt->bindParam(1, $this->IdPermiso);

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
                IdPermiso=:IdPermiso";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdPermiso = htmlspecialchars(strip_tags($this->IdPermiso));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdPermiso', $this->IdPermiso);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function validateNpermisos()
  {
    $query = "SELECT
                  IdPermiso, Nombre
              FROM
                " . $this->table_name . "
                WHERE
                Nombre = ? ";
    $stmt = $this->conn->prepare($query);
    $this->NombrePE = htmlspecialchars(strip_tags($this->NombrePE));
    $stmt->bindParam(1, $this->NombrePE);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->Nombre = $row['Nombre'];
      return true;
    }
    return false;
  }
}
