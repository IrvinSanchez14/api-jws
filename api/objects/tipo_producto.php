<?php
class TipoProducto
{
  private $conn;
  private $table_name = "tipo_producto";

  public $IdTipoProducto;
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
                  um.IdTipoProducto, um.Descripcion, um.Nombre, um.Estado, um.FechaCreacion
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
                Estado = :Estado";
    $stmt = $this->conn->prepare($query);
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));

    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Estado', $this->Estado);

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
                IdTipoProducto=:IdTipoProducto";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->FechaCreacion = htmlspecialchars(strip_tags($this->FechaCreacion));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':FechaCreacion', $this->FechaCreacion);
    $stmt->bindParam(':IdTipoProducto', $this->IdTipoProducto);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdTipoProducto = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));

    $stmt->bindParam(1, $this->IdTipoProducto);

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
                IdTipoProducto=:IdTipoProducto";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdTipoProducto', $this->IdTipoProducto);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
