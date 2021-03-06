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
  public $UsuarioCreador;
  public $UsuarioActualiza;

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
               Estado = :Estado,
               UsuarioCreador=:UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->IdEmpresa = htmlspecialchars(strip_tags($this->IdEmpresa));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));
 
    $stmt->bindParam(':IdEmpresa', $this->IdEmpresa);
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
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
                Direccion=:Direccion,
                Telefono=:Telefono,
                Estado=:Estado,
                UsuarioActualiza=:UsuarioActualiza
              WHERE
              IdSucursal=:IdSucursal";

    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));
    
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdSucursal', $this->IdSucursal);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);

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

  function validateNSucu()
  {
    $query = "SELECT 
                IdSucursal, Nombre 
              FROM 
                " .$this->table_name . "
              WHERE 
                 Nombre = ? ";
    $stmt = $this->conn->prepare($query);
    $this->NombreSU = htmlspecialchars(strip_tags($this->NombreSU));
    $stmt->bindparam(1, $this->NombreSU);
    $stmt->execute();
    $num =$stmt->rowCount();
    if($num > 0)
    {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->Nombre = $row['Nombre'];
      return true;
    }
    return false;
  }
}
