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
                  em.IdEmpresa, em.Nombre, em.Razon_Social,em.Direccion, em.Telefono, em.Correo, if(em.Estado = 0, 'Disponible','Inactivo')AS estadoTexto, em.FechaCreacion
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
                Nombre = :Nombre,
                Razon_Social = :Razon_Social,
                Direccion = :Direccion,
                Telefono = :Telefono,
                Correo= :Correo,
                Estado = :Estado,
                UsuarioCreador=:UsuarioCreador";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Razon_Social = htmlspecialchars(strip_tags($this->Razon_Social));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Correo = htmlspecialchars(strip_tags($this->Correo));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Razon_Social', $this->Razon_Social);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Correo', $this->Correo);
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
                Razon_Social=:Razon_Social,
                Direccion=:Direccion,
                Telefono=:Telefono,
                Correo=:Correo,
                Estado=:Estado,
                UsuarioActualiza=:UsuarioActualiza

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
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Razon_Social', $this->Razon_Social);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Correo', $this->Correo);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdEmpresa', $this->IdEmpresa);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);

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
  function validateNempresa()
  {
    $query = "SELECT 
                IdEmpresa, Nombre
              FROM
                " .$this->table_name . "
              WHERE
                  Nombre = ? ";
    $stmt = $this->conn->prepare($query);
    $this->NombreEM = htmlspecialchars(strip_tags($this->NombreEM));
    $stmt->bindParam(1, $this->NombreEM);
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
