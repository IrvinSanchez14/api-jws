<?php
class lista_producto_porcion
{
  private $conn;
  private $table_name = "lista_producto_porcion";

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
                lpp.IdListaPP, pr.Nombre AS NombreProducto, CONCAT(po.Cantidad,' ',um.Siglas) AS Porcion, po.IdPorcion, if(lpp.Estado = 0, 'Disponible','Inactivo')AS estadoTexto
              FROM 
                lista_producto_porcion lpp
              LEFT JOIN 
                productos pr ON lpp.IdProducto=pr.IdProducto 
              LEFT JOIN 
                porciones po ON lpp.IdPorcion=po.IdPorcion
              LEFT JOIN 
                unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
              ORDER BY 
                lpp.FechaCreacion DESC ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function leerProductos()
  {
    $query = "SELECT 
                lpp.IdListaPP, pr.Nombre AS NombreProducto,pr.IdProducto, if(lpp.Estado = 0, 'Disponible','Inactivo')AS estadoTexto
              FROM 
                lista_producto_porcion lpp
              LEFT JOIN 
                productos pr ON lpp.IdProducto=pr.IdProducto 
              LEFT JOIN 
                porciones po ON lpp.IdPorcion=po.IdPorcion
              LEFT JOIN 
                unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
              GROUP BY 
                pr.IdProducto
              ORDER BY 
                lpp.FechaCreacion DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function leerPorcionProducto()
  {
    $query = "SELECT 
                lpp.IdListaPP, pr.Nombre AS NombreProducto, CONCAT(po.Cantidad,' ',um.Siglas) AS Porcion, po.IdPorcion, if(lpp.Estado = 0, 'Disponible','Inactivo')AS estadoTexto
              FROM 
                lista_producto_porcion lpp
              LEFT JOIN 
                productos pr ON lpp.IdProducto=pr.IdProducto 
              LEFT JOIN 
                porciones po ON lpp.IdPorcion=po.IdPorcion
              LEFT JOIN 
                unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
              WHERE
                pr.IdProducto = ?
              ORDER BY 
                lpp.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));
    $stmt->bindParam(1, $this->IdProducto);
    $stmt->execute();
    return $stmt;
  }

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
              SET
                IdProducto = :NombreProducto,
                IdPorcion=:Porcion,
                Estado=:Estado,
                UsuarioCreador=:UsuarioCreador";

    $stmt = $this->conn->prepare($query);
    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));
    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':NombreProducto', $this->IdProducto);
    $stmt->bindParam(':Porcion', $this->IdPorcion);
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
                IdProducto = :NombreProducto,
                IdPorcion=:Porcion,
                UsuarioActualiza=:UsuarioActualiza
              WHERE
                IdListaPP=:IdListaPP";
    $stmt = $this->conn->prepare($query);

    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));
    $this->IdPorcion = htmlspecialchars(strip_tags($this->IdPorcion));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));
    $this->IdListaPP = htmlspecialchars(strip_tags($this->IdListaPP));

    $stmt->bindParam(':NombreProducto', $this->IdProducto);
    $stmt->bindParam(':Porcion', $this->IdPorcion);
    $stmt->bindParam(':IdListaPP', $this->IdListaPP);
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
