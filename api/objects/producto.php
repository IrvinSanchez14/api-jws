<?php
class Producto
{
  private $conn;
  private $table_name = "productos";
  /*
IdProducto
Nombre
Descripcion
*/
  public $IdProducto;
  public $Nombre;
  public $Descripcion;
  public $UsuarioCreador;
  public $UsuarioActualiza;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                um.IdProducto, um.Nombre, um.Descripcion,tp.Nombre AS tipoProducto, un.Siglas, p.Nombre AS Proveedor, um.FechaCreacion
              FROM
                productos um
              LEFT JOIN 
                tipo_producto tp ON um.IdTipoProducto=tp.IdTipoProducto
              LEFT JOIN 
                unidad_medida un ON um.IdUnidadMedida=un.IdUnidadMedida
              LEFT JOIN 
              proveedores p ON um.IdProveedor=p.IdProveedor
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

                Nombre = :Nombre,
                Descripcion = :Descripcion,
                IdTipoProducto=:tipoProducto,
                IdUnidadMedida=:Siglas,
                IdProveedor=:Proveedor,
                UsuarioCreador=:UsuarioCreador";

    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':tipoProducto', $this->IdTipoProducto);
    $stmt->bindParam(':Siglas', $this->IdUnidadMedida);
    $stmt->bindParam(':Proveedor', $this->IdProveedor);
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
                IdTipoProducto=:tipoProducto,
                IdUnidadMedida=:Siglas,
                IdProveedor=:Proveedor,
                UsuarioActualiza=:UsuarioActualiza
              WHERE
                IdProducto=:IdProducto";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));
    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':tipoProducto', $this->IdTipoProducto);
    $stmt->bindParam(':Siglas', $this->IdUnidadMedida);
    $stmt->bindParam(':Proveedor', $this->IdProveedor);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);
    $stmt->bindParam(':IdProducto', $this->IdProducto);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdProducto = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));

    $stmt->bindParam(1, $this->IdProducto);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}
