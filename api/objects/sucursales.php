<?php
class Sucursales
{
  private $conn;
  private $table_name = "sucursales";

  public $IdSucursal;
  public $IdEmpresa;
  public $Nombre;
  public $Direccion;
  public $Telefono;
  public $Estado;
  public $IdEncargado;
  public $FechaCreacion;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                su.IdSucursal, su.IdEmpresa, su.Nombre, su.Direccion, su.Telefono,
                 su.IdEncargado, su.Estado, su.FechaCreacion 
                FROM
                  " . $this->table_name . " su
                ORDER BY
                  su.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
              SET
               IdEmpresa = :IdEmpresa,
               Nombre = :Nombre,
               Direccion = :Direccion,
               Telefono = :Telefono,
               Estado = :Estado";
    $stmt = $this->conn->prepare($query);
    $this->IdEmpresa = htmlspecialchars(strip_tags($this->IdEmpresa));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));

    $stmt->bindParam(':IdEmpresa', $this->IdEmpresa);
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
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
                Direccion=:Direccion,
                Telefono=:Telefono,
                Estado=:Estado
              WHERE
              IdSucursal=:IdSucursal";

    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdSucursal', $this->IdSucursal);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdSucursal = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));

    $stmt->bindParam(1, $this->IdSucursal);

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
                IdSucursal=:IdSucursal";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdSucursal', $this->IdSucursal);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
