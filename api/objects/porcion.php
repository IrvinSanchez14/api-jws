<?php
class Porcion
{
  private $conn;
  private $table_name = "porciones";

  public $IdPorcion;
  public $Cantidad;
  public $IdUnidadMedida;
  public $Estado;
  public $FechaCreacion;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  um.IdPorcion, um.Cantidad, um.IdUnidadMedida, um.Estado, um.FechaCreacion
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
                IdPorcion = :IdPorcion,
                Cantidad = :Cantidad,
                IdUnidadMedida = :IdUnidadMedida,
                Estado = :Estado";
    $stmt = $this->conn->prepare($query);
    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));
    $this->Cantidad = htmlspecialchars(strip_tags($this->Cantidad));
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));

    $stmt->bindParam(':IdPorcion', $this->IdPorcion);
    $stmt->bindParam(':Cantidad', $this->Cantidad);
    $stmt->bindParam(':IdUnidadMedida', $this->IdUnidadMedida);
    $stmt->bindParam(':Estado', $this->Estado);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                IdUnidadMedida=:IdUnidadMedida,
                Cantidad=:Cantidad,
                Estado=:Estado
              WHERE
                IdPorcion=:IdPorcion";
    $stmt = $this->conn->prepare($query);

    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->Cantidad = htmlspecialchars(strip_tags($this->Cantidad));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));

    $stmt->bindParam(':IdUnidadMedida', $this->IdUnidadMedida);
    $stmt->bindParam(':Cantidad', $this->Cantidad);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdPorcion', $this->IdPorcion);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdPorcion = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));

    $stmt->bindParam(1, $this->IdPorcion);

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
                IdPorcion=:IdPorcion";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdPorcion', $this->IdPorcion);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
