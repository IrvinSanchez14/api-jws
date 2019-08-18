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
    $query = "SELECT le.IdListaExistene, su.Nombre as Sucursal, us.Nombre AS Nombre_Usuario, es.Nombre AS Estado, le.FechaCreacion from lista_existente le
    LEFT JOIN sucursales su ON le.IdSucursal=su.IdSucursal
    LEFT JOIN usuarios us ON le.UsuarioCreador= us.IdUsuario
    LEFT JOIN estados es ON le.IdEstado = es.IdEstado
    WHERE DATE (le.FechaCreacion)= ?";

    $stmt = $this->conn->prepare($query);
    $this->FechaCreacion = htmlspecialchars(strip_tags($this->FechaCreacion));
    $stmt->bindParam(1, $this->FechaCreacion);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->IdListaExistene = $row['IdListaExistene'];
      $this->Sucursal = $row['Sucursal'];
      $this->Nombre_Usuario = $row['Nombre_Usuario'];
      $this->Estado = $row['Estado'];
      $this->FechaCreacion = $row['FechaCreacion'];
      return true;
    }
    return false;
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
