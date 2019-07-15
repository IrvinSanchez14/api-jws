<?php
class Proveedor
{
  private $conn;
  private $table_name = "proveedores";

  public $IdProveedor;
  public $Nombre;
  public $Direccion;
  public $Telefono;
  public $Razo_Social;
  public $Tipo;
  public $Nombre_Contacto;
  public $Email;
  public $DUI;
  public $NIT;
  public $NRC;
  public $Estado;

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

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
              SET
                IdProveedor = :IdProveedor,
                Nombre = :Nombre,
                Direccion = :Direccion,
                Telefono = :Telefono,
                Razo_Social = :Razo_Social,
                Tipo = :Tipo,
                Nombre_Contacto = :Nombre_Contacto,
                Email = :Email,
                DUI = :DUI,
                NIT = :NIT,
                NRC = :NRC,
                Estado = :Estado";
    $stmt = $this->conn->prepare($query);
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Razo_Social = htmlspecialchars(strip_tags($this->Razo_Social));
    $this->Tipo = htmlspecialchars(strip_tags($this->Tipo));
    $this->Nombre_Contacto = htmlspecialchars(strip_tags($this->Nombre_Contacto));
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $this->DUI = htmlspecialchars(strip_tags($this->DUI));
    $this->NIT = htmlspecialchars(strip_tags($this->NIT));
    $this->NRC = htmlspecialchars(strip_tags($this->NRC));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    
    $stmt->bindParam(':IdProveedor', $this->IdProveedor);
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Razo_Social', $this->Razo_Social);
    $stmt->bindParam(':Tipo', $this->Tipo);
    $stmt->bindParam(':Nombre_Contacto', $this->Nombre_Contacto);
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':DUI', $this->DUI);
    $stmt->bindParam(':NIT', $this->NIT);
    $stmt->bindParam(':NRC', $this->NRC);
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
                Razo_Social=:Razo_Social,
                Tipo=:Tipo,
                Nombre_Contacto=:Nombre_Contacto,
                Email=:Email,
                DUI=:DUI,
                NIT=:NIT,
                NRC=:NRC,
                Estado=:Estado
                WHERE
                IdProveedor=:IdProveedor";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Razo_Social = htmlspecialchars(strip_tags($this->Razo_Social));
    $this->Tipo = htmlspecialchars(strip_tags($this->Tipo));
    $this->Nombre_Contacto = htmlspecialchars(strip_tags($this->Nombre_Contacto));
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $this->DUI = htmlspecialchars(strip_tags($this->DUI));
    $this->NIT = htmlspecialchars(strip_tags($this->NIT));
    $this->NRC = htmlspecialchars(strip_tags($this->NRC));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Razo_Social', $this->Razo_Social);
    $stmt->bindParam(':Tipo', $this->Tipo);
    $stmt->bindParam(':Nombre_Contacto', $this->Nombre_Contacto);
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':DUI', $this->DUI);
    $stmt->bindParam(':NIT', $this->NIT);
    $stmt->bindParam(':NRC', $this->NRC);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdProveedor', $this->IdProveedor);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }

  }

  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdProveedor = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));

    $stmt->bindParam(1, $this->IdProveedor);

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
              IdProveedor=:IdProveedor";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdProveedor', $this->IdProveedor);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
 }
}