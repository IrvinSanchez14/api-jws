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

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  um.IdPermiso, um.Descripcion, um.Nombre, um.Estado, um.FechaCreacion
                FROM
                  " . $this->table_name . " um
                ORDER BY
                  um.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
              SET
                Descripcion = :Descripcion,
                Nombre = :Nombre,
                Estado = :Estado,
                UsuarioCreador=:UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Nombre', $this->Nombre);
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
                FechaCreacion=:FechaCreacion,
                UsuarioActualiza=:UsuarioActualiza
              WHERE
                IdPermiso=:IdPermiso";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->FechaCreacion = htmlspecialchars(strip_tags($this->FechaCreacion));
    $this->IdPermiso = htmlspecialchars(strip_tags($this->IdPermiso));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':FechaCreacion', $this->FechaCreacion);
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
    $this->IdPermiso = htmlspecialchars(strip_tags($this->IdTipoProducto));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdPermiso', $this->IdPermiso);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
