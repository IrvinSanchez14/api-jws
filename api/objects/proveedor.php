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

  public $UsuarioCreador;
  public $UsuarioActualiza;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  pr.IdProveedor, pr.Nombre, pr.Direccion, pr.Telefono, pr.Razo_Social, pr.Nombre_Contacto, pr.Email, pr.DUI, pr.NIT, pr.NRC, if(pr.Estado = 0, 'Disponible','Inactivo')AS estadoTexto, pr.FechaCreacion
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
                Nombre = :Nombre,
                Direccion = :Direccion,
                Telefono = :Telefono,
                Razo_Social = :Razo_Social,
                Nombre_Contacto = :Nombre_Contacto,
                Email = :Email,
                DUI = :DUI,
                NIT = :NIT,
                NRC = :NRC,
                Estado = :Estado,
                UsuarioCreador=:UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Razo_Social = htmlspecialchars(strip_tags($this->Razo_Social));
    $this->Nombre_Contacto = htmlspecialchars(strip_tags($this->Nombre_Contacto));
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $this->DUI = htmlspecialchars(strip_tags($this->DUI));
    $this->NIT = htmlspecialchars(strip_tags($this->NIT));
    $this->NRC = htmlspecialchars(strip_tags($this->NRC));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));


    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Razo_Social', $this->Razo_Social);
    $stmt->bindParam(':Nombre_Contacto', $this->Nombre_Contacto);
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':DUI', $this->DUI);
    $stmt->bindParam(':NIT', $this->NIT);
    $stmt->bindParam(':NRC', $this->NRC);
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
                Razo_Social=:Razo_Social,
                Nombre_Contacto=:Nombre_Contacto,
                Email=:Email,
                DUI=:DUI,
                NIT=:NIT,
                NRC=:NRC,
                UsuarioActualiza=:UsuarioActualiza

                WHERE
                IdProveedor=:IdProveedor";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Direccion = htmlspecialchars(strip_tags($this->Direccion));
    $this->Telefono = htmlspecialchars(strip_tags($this->Telefono));
    $this->Razo_Social = htmlspecialchars(strip_tags($this->Razo_Social));
    $this->Nombre_Contacto = htmlspecialchars(strip_tags($this->Nombre_Contacto));
    $this->Email = htmlspecialchars(strip_tags($this->Email));
    $this->DUI = htmlspecialchars(strip_tags($this->DUI));
    $this->NIT = htmlspecialchars(strip_tags($this->NIT));
    $this->NRC = htmlspecialchars(strip_tags($this->NRC));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Direccion', $this->Direccion);
    $stmt->bindParam(':Telefono', $this->Telefono);
    $stmt->bindParam(':Razo_Social', $this->Razo_Social);
    $stmt->bindParam(':Nombre_Contacto', $this->Nombre_Contacto);
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':DUI', $this->DUI);
    $stmt->bindParam(':NIT', $this->NIT);
    $stmt->bindParam(':NRC', $this->NRC);
    $stmt->bindParam(':IdProveedor', $this->IdProveedor);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);

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
  function validateNprov()
  {
    $query = "SELECT 
                Nombre, NRC 
              FROM 
                " . $this->table_name . "
              WHERE 
                 Nombre = ? AND NRC = ? ";
    $stmt = $this->conn->prepare($query);
    $this->NombrePR = htmlspecialchars(strip_tags($this->NombrePR));
    $this->NRCpr = htmlspecialchars(strip_tags($this->NRCpr));
    $stmt->bindParam(1, $this->NombrePR);
    $stmt->bindParam(2, $this->NRCpr);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->Nombre = $row['Nombre'];
      $this->NRC = $row['NRC'];
      return true;
    }
    return false;
  }
}
