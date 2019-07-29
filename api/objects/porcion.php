<?php
class Porcion
{
  private $conn;
  private $table_name = "porciones";

  public $IdPorcion;
  public $Cantidad;
  public $IdUnidadMedida;
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
                  um.IdPorcion, um.Cantidad, um.IdUnidadMedida, um.Estado, um.FechaCreacion
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
                IdUnidadMedida = :IdUnidadMedida,
                Cantidad=:Cantidad,
                UsuarioCreador=:UsuarioCreador,
                Estado=:Estado
                IdPorcion=:IdPorcion";

    $stmt = $this->conn->prepare($query);
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->Cantidad = htmlspecialchars(strip_tags($this->Cantidad));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    
    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));
 
    $stmt->bindParam(':IdUnidadMedida', $this->IdUnidadMedida);
    $stmt->bindParam(':Cantidad', $this->Cantidad);
    $stmt->bindParam(':Cantidad', $this->IdPorcion);
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function update(){
    $query = "UPDATE
                " . $this->table_name . "
              SET
                IdUnidadMedida=:IdUnidadMedida,
                Cantidad=:Cantidad,
                Estado=:Estado,
                UsuarioActualiza=:UsuarioActualiza
              WHERE
                IdPorcion=:IdPorcion";
    $stmt = $this->conn->prepare($query);

    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->Cantidad = htmlspecialchars(strip_tags($this->Cantidad));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));
    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));


    $stmt->bindParam(':IdUnidadMedida', $this->IdUnidadMedida);
    $stmt->bindParam(':Cantidad', $this->Cantidad);
    $stmt->bindParam(':IdPorcion', $this->IdPorcion);    
    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdPorcion = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));

    $stmt->bindParam(1, $this->IdPorcion);

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
                IdPorcion=:IdPorcion";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdPorcion', $this->IdPorcion);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
