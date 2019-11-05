<?php
class lista_existente
{
  private $conn;
  private $table_name = "lista_existente";

  public $Sucursal;
  public $Fecha;
  public $IdListaExistene;
  public $Estado;
  public $UsuarioCreador;
  public $IdProducto;
  public $IdPorcion;
  public $Cantidad;
  public $IdSucursal;

  public function __construct($db)
  {
    $this->conn = $db;
  }


  function create()
  {
    $query = "INSERT INTO lista_existente
              SET
                IdSucursal = :Sucursal,
                IdEstado=:Estado,
                UsuarioCreador=:UsuarioCreador";

    $stmt = $this->conn->prepare($query);
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));
    $this->IdEstado = htmlspecialchars(strip_tags($this->IdEstado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Sucursal', $this->IdSucursal);
    $stmt->bindParam(':Estado', $this->IdEstado);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }


  function ListaExistente()
  {
    $query = "SELECT 
                le.IdListaExistene, su.Nombre as Sucursal, us.Nombre AS Nombre_Usuario, es.Nombre AS Estado, le.FechaCreacion from lista_existente le
              LEFT JOIN 
                sucursales su ON le.IdSucursal=su.IdSucursal
              LEFT JOIN 
                usuarios us ON le.UsuarioCreador= us.IdUsuario
              LEFT JOIN 
                estados es ON le.IdEstado = es.IdEstado
              WHERE 
                DATE(le.FechaCreacion)= ? AND su.IdSucursal = ?";

    $stmt = $this->conn->prepare($query);
    $this->FechaCreacion = htmlspecialchars(strip_tags($this->FechaCreacion));
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));
    $stmt->bindParam(1, $this->FechaCreacion);
    $stmt->bindParam(2, $this->IdSucursal);
    $stmt->execute();
    return $stmt;
  }

  function ListaDetalle()
  {
    $query = "SELECT pr.Nombre AS Producto, ld.Cantidad, CONCAT( po.Cantidad,' ',um.Siglas) AS Porcion FROM lista_existente_detalle ld
    LEFT JOIN productos pr ON ld.IdProducto=pr.IdProducto
    LEFT JOIN porciones po ON ld.IdPorcion=po.IdPorcion
    LEFT JOIN lista_existente le ON ld.IdListaExistene=le.IdListaExistene
    LEFT JOIN unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
    WHERE le.IdListaExistene = ?";

    $stmt = $this->conn->prepare($query);
    $this->IdListaExistene = htmlspecialchars(strip_tags($this->IdListaExistene));
    $stmt->bindParam(1, $this->IdListaExistene);
    $stmt->execute();
    return $stmt;
  }

  function verAdministradores()
  {
    $query = "SELECT 
                IdUsuario, Email FROM usuarios
              WHERE 
                IdTipoUsuario = 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function createDetalle($id, $array)
  {
    $query = "INSERT INTO lista_existente_detalle
              SET
                IdListaExistene = :IdListaExistene,
                IdProducto=:IdProducto,
                IdPorcion=:IdPorcion,
                Cantidad=:Cantidad";

    $stmt = $this->conn->prepare($query);
    $i = 0;
    $len = count($array);
    foreach ($array as $item) {

      $stmt->bindValue(':IdListaExistene', $id);
      $stmt->bindValue(':IdProducto', $item->IdProducto);
      $stmt->bindValue(':IdPorcion', $item->IdPorcion);
      $stmt->bindValue(':Cantidad', $item->Cantidad);
      if ($stmt->execute()) { } else {
        $arr = $stmt->errorInfo();
        print_r($arr);
      }
      if ($i == $len - 1) {
        return true;
      }
      $i++;
    }
  }
}
