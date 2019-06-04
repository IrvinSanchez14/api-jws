<?php
class Proveedor
{
  private $conn;
  private $table_name = "proveedores";

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  pr.IdProveedor, pr.Nombre, pr.Direccion, pr.Telefono, pr.Razo_Social, pr.Tipo, pr.Nombre_Contacto, pr.Email, pr.DUI, pr.NIT, pr.NRC, pr.Estado, pr.FechaCreacion
                FROM
                  " . $this->table_name . " pr
                ORDER BY
                  pr.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}
