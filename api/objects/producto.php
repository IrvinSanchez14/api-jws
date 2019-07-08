<?php
class Producto
{
  private $conn;
  private $table_name = "productos";
/*
IdProducto
Nombre
Descripcion
*/
  public $IdProducto;
  public $Nombre;
  public $Descripcion;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  um.IdProducto, um.Nombre, um.Descripcion, um.FechaCreacion
                FROM
                  " . $this->table_name . " um
                ORDER BY
                  um.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function create(){
    $query = "INSERT INTO " . $this->table_name . "
              SET
                IdProducto = :IdProducto,
                Nombre = :Nombre,
                Descripcion = :Descripcion";
    $stmt = $this->conn->prepare($query);
    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));

    $stmt->bindParam(':IdProducto', $this->IdProducto);
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                Nombre=:Nombre,
                Descripcion=:Descripcion
              WHERE
                IdProducto=:IdProducto";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':IdProducto', $this->IdProducto);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdProducto = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));

    $stmt->bindParam(1, $this->IdProducto);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

}
