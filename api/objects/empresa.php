<?php
class Empresas
{
  private $conn;
  private $table_name = "empresas";
  public $IdEmpresa;
  public $Nombre;
  public $Razon_Social;
  public $Direccion;
  public $Telefono;
  public $Correo;
  public $Estado;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  em.IdEmpresa, em.Nombre, em.Razon_Social,em.Direccion, em.Telefono, em.Correo, em.Estado, em.FechaCreacion
                FROM
                  " . $this->table_name . " em
                ORDER BY
                  em.FechaCreacion DESC";
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
                Razon_Social = :Razon_Social,
                Direccion = :Direccion,
                Telefono = :Telefono,
                Correo= :Correo,
                Estado = :Estado";
    $stmt = $this->conn->prepare($query);
    $this->IdEmpresa = htmlspecialchars(strip_tags($this->IdEmpresa));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Razon_Social = htmlspecialchars(strip_tags($this->Razon_Social));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Correo = htmlspecialchars(strip_tags($this->Correo));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));

    $stmt->bindParam(':IdEmpresa', $this->IdEmpresa);
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Razon_Social', $this->Razon_Social);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Correo', $this->Correo);
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
                Razon_Social=:Razon_Social,
                Direccion=:Direccion,
                Telefono=:Telefono,
                Correo=:Correo,
                Estado=:Estado
              WHERE
                IdEmpresa=:IdEmpresa";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Razon_Social = htmlspecialchars(strip_tags($this->Razon_Social));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Correo = htmlspecialchars(strip_tags($this->Correo));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdEmpresa = htmlspecialchars(strip_tags($this->IdEmpresa));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Razon_Social', $this->Razon_Social);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Correo', $this->Correo);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdEmpresa', $this->IdEmpresa);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function changeState()
  {
    $query = "UPDATE
                " . $this->table_name . "
              SET
                Estado=:Estado
              WHERE
                IdEmpresa=:IdEmpresa";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdEmpresa = htmlspecialchars(strip_tags($this->IdEmpresa));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdEmpresa', $this->IdEmpresa);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
