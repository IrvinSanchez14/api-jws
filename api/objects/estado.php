<?php
class estados
{
  private $conn;
  private $table_name = "estados";
  /**
   * IdEstado
   * Nombre
   * Descripcion
   * IdEstadoAnterior
   * IdEstadoSiguiente
   */
  public $IdEstado;
  public $Descripcion;
  public $Nombre;
  public $IdEstadoAnterior;
  public $IdEstadoSiguientes;
  public $Disponible;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  um.IdEstado, um.Nombre, um.Descripcion,um.FechaCreacion,if(um.Disponible = 0, 'Disponible','Inactivo')AS estadoTexto
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
                Disponible = :Disponible,
                UsuarioCreador=:UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Disponible = htmlspecialchars(strip_tags($this->Disponible));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Disponible', $this->Disponible);
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
                IdEstado=:IdEstado";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->IdEstado = htmlspecialchars(strip_tags($this->IdEstado));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':IdEstado', $this->IdEstado);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdEstado = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdEstado = htmlspecialchars(strip_tags($this->IdEstado));

    $stmt->bindParam(1, $this->IdEstado);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function validateNestado()
  {
    $query = "SELECT 
                IdEstado, Nombre
              FROM 
                " . $this->table_name . "
              WHERE 
                  Nombre = ? ";
    $stmt = $this->conn->prepare($query);
    $this->NombreES = htmlspecialchars(strip_tags($this->NombreES));
    $stmt->bindParam(1, $this->NombreES);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->Nombre = $row['Nombre'];
      return true;
    }
    return false;
  }

  function changeState()
  {
    $query = "UPDATE
                " . $this->table_name . "
              SET
                Disponible=:Disponible
              WHERE
                IdEstado=:IdEstado";
    $stmt = $this->conn->prepare($query);

    $this->Disponible = htmlspecialchars(strip_tags($this->Disponible));
    $this->IdEstado = htmlspecialchars(strip_tags($this->IdEstado));

    $stmt->bindParam(':Disponible', $this->Disponible);
    $stmt->bindParam(':IdEstado', $this->IdEstado);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
