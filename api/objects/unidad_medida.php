<?php
class UnidadMedida
{
  private $conn;
  private $table_name = "unidad_medida";

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
}
