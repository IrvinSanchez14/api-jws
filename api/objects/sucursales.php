<?php
class Sucursales
{
  private $conn;
  private $table_name = "sucursales";

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                su.IdSucursal, su.IdEmpresa, su.Nombre, su.Direccion, su.Telefono, su.IdEncargado, su.Estado, su.FechaCreacion 
                FROM
                  " . $this->table_name . " su
                ORDER BY
                  su.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}
