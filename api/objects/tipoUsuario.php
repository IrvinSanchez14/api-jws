<?php
class tipos_usuario
{
  private $conn;
  private $table_name = "tipos_usuario";

  public $IdTipoUsuario;
  public $Nombre;
  public $Descripcion;
  public $Estado;
  public $estadoTexto;
  public $UsuarioCreador;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                  tu.IdTipoUsuario, tu.Nombre, tu.Descripcion, if(tu.Estado = 0, 'Disponible','Inactivo')AS estadoTexto
                FROM
                  " . $this->table_name . " tu
                ORDER BY
                  tu.FechaActualizacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
              SET
                Nombre = :Nombre,
                Descripcion = :Descripcion,
                Estado = :Estado,
                UsuarioCreador = :UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
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
                IdTipoUsuario=:IdTipoUsuario";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));
    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);
    $stmt->bindParam(':IdTipoUsuario', $this->IdTipoUsuario);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdTipoUsuario = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));

    $stmt->bindParam(1, $this->IdTipoUsuario);

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
                Estado=:Estado,
                UsuarioActualiza=:UsuarioActualiza
              WHERE
                IdTipoUsuario=:IdTipoUsuario";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));
    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);
    $stmt->bindParam(':IdTipoUsuario', $this->IdTipoUsuario);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
