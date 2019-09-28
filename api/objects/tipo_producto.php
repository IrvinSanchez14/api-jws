<?php
class TipoProducto
{
  private $conn;
  private $table_name = "tipo_producto";

  public $IdTipoProducto;
  public $Descripcion;
  public $Nombre;
  public $Estado;
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
                  um.IdTipoProducto, um.Descripcion, um.Nombre, if(um.Estado = 0, 'Disponible','Inactivo')AS estadoTexto, um.FechaCreacion
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
                Descripcion = :Descripcion,
                Nombre = :Nombre,
                Estado = :Estado,
                UsuarioCreador=:UsuarioCreador";

    $stmt = $this->conn->prepare($query);
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));


    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Nombre', $this->Nombre);
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
                Descripcion=:Descripcion,
                UsuarioActualiza=:UsuarioActualiza
              WHERE
                IdTipoProducto=:IdTipoProducto";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));


    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':IdTipoProducto', $this->IdTipoProducto);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdTipoProducto = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));

    $stmt->bindParam(1, $this->IdTipoProducto);

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
                IdTipoProducto=:IdTipoProducto";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdTipoProducto', $this->IdTipoProducto);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function validateNtipo()
  {
    $query = "SELECT 
                IdTipoProducto, Nombre 
                FROM 
                  " . $this->table_name . "
                WHERE 
                 Nombre = ? ";
    $stmt = $this->conn->prepare($query);
    $this->NombreTP = htmlspecialchars(strip_tags($this->NombreTP));
    $stmt->bindParam(1, $this->NombreTP);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->Nombre = $row['Nombre'];
      return true;
    }
    return false;
  }
}
