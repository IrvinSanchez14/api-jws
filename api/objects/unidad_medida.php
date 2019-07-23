<?php
class UnidadMedida
{
  private $conn;
  private $table_name = "unidad_medida";

  public $IdUnidadMedida;
  public $Siglas;
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
                  um.IdUnidadMedida, um.Siglas, um.Nombre, um.Estado, um.FechaCreacion
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
                IdUnidadMedida = :IdUnidadMedida,
                Siglas = :Siglas,
                Nombre = :Nombre,
                Estado = :Estado";
    $stmt = $this->conn->prepare($query);
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->Siglas = htmlspecialchars(strip_tags($this->Siglas));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));

    $stmt->bindParam(':IdUnidadMedida', $this->IdUnidadMedida);
    $stmt->bindParam(':Siglas', $this->Siglas);
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
                Siglas=:Siglas,
                Estado=:Estado
              WHERE
                IdUnidadMedida=:IdUnidadMedida";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Siglas = htmlspecialchars(strip_tags($this->Siglas));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Siglas', $this->Siglas);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdUnidadMedida', $this->IdUnidadMedida);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdUnidadMedida = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));

    $stmt->bindParam(1, $this->IdUnidadMedida);

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
                IdUnidadMedida=:IdUnidadMedida";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdUnidadMedida', $this->IdUnidadMedida);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
