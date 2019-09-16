<?php
class Produccion
{
  private $conn;
  private $table_name = "produccion";

  public $IdPC;
  public $lote;
  public $UsuarioCreador;
  public $UsuarioActualiza;
  public $IdProducto;
  public $Cantidad;
  public $FechaVencimineto;
  public $IdPorcion;
  public $IdCP;



  public function __construct($db)
  {
    $this->conn = $db;
  }

  function createCabecera()
  {
    $query = "INSERT INTO produccion_cabecera
              SET
                lote = :lote,
                IdCP = :IdCP,
                UsuarioCreador = :UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->lote = htmlspecialchars(strip_tags($this->lote));
    $this->IdCP = htmlspecialchars(strip_tags($this->IdCP));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':lote', $this->lote);
    $stmt->bindParam(':IdCP', $this->IdCP);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function createDetalle($id, $array)
  {
    $query = "INSERT INTO produccion
              SET
                IdProducto = :IdProducto,
                IdPC = :IdPC,
                Cantidad = :Cantidad,
                IdPorcion = :IdPorcion,
                FechaVencimiento = :FechaVencimiento";

    $stmt = $this->conn->prepare($query);
    $i = 0;
    $len = count($array);
    foreach ($array as $item) {
      $stmt->bindValue(':IdProducto', $item->IdProducto);
      $stmt->bindValue(':IdPC', $id);
      $stmt->bindValue(':Cantidad', $item->Cantidad);
      $stmt->bindValue(':IdPorcion', $item->IdPorcion);
      $stmt->bindValue(':FechaVencimiento', $item->FechaVencimiento);
      if ($stmt->execute()) { } else {
        $arr = $stmt->errorInfo();
      }
      if ($i == $len - 1) {
        return true;
      }
      $i++;
    }
  }


  function createNotaEnvio($array)
  {
    $query = "INSERT INTO nota_envio
              SET
                IdProduccion = :IdProduccion,
                Cantidad = :Cantidad,
                IdSucursal = :IdSucursal,
                UsuarioCreador = :UsuarioCreador";

    $stmt = $this->conn->prepare($query);
    $i = 0;
    $len = count($array);
    foreach ($array as $item) {
      $stmt->bindValue(':IdProduccion', $item->IdProduccion);
      $stmt->bindValue(':Cantidad', $item->Cantidad);
      $stmt->bindValue(':IdSucursal', $item->IdSucursal);
      $stmt->bindValue(':UsuarioCreador', $item->UsuarioCreador);
      if ($stmt->execute()) { } else {
        $arr = $stmt->errorInfo();
      }
      if ($i == $len - 1) {
        return true;
      }
      $i++;
    }
  }

  function readProduccion()
  {
    $query = "SELECT 
                pc.IdPC, pc.IdCP, pc.lote,pc.IdEstado,e.Nombre AS NombreEstado, pc.FechaCreacion FROM produccion_cabecera pc
              LEFT JOIN 
                estados e ON pc.IdEstado=e.IdEstado";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function readDetalleProduccion()
  {
    $query = "SELECT 
                p.IdProduccion, p.IdPC, p.IdProducto, p.Cantidad, p.IdPorcion,p.FechaVencimiento, pr.Nombre AS NombreProducto, CONCAT(po.Cantidad,' ', um.Siglas)AS NombrePorcion
              FROM 
                produccion p
              LEFT JOIN 
                productos pr ON p.IdProducto=pr.IdProducto
              LEFT JOIN 
                porciones po ON p.IdPorcion=po.IdPorcion
              LEFT JOIN 
                unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
              WHERE 
                p.IdPC = ? ";
    $stmt = $this->conn->prepare($query);
    $this->IdPC = htmlspecialchars(strip_tags($this->IdPC));
    $stmt->bindParam(1, $this->IdPC);
    $stmt->execute();
    return $stmt;
  }
}
