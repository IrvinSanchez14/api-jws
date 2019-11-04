<?php
class Factura
{
  private $conn;
  private $table_name = "factura_cabecera";

  public $NoFactura;
  public $IdProveedor;
  public $FechaFactura;
  public $FechaIngreso;
  public $TipoFactura;
  public $TotalSinIva;
  public $IVA;
  public $UsuarioCreador;
  public $IdCP;



  public function __construct($db)
  {
    $this->conn = $db;
  }

  function createCabecera()
  {
    $query = "INSERT INTO factura_cabecera
              SET
                NoFactura = :NoFactura,
                IdProveedor = :IdProveedor,
                FechaFactura = :FechaFactura,
                FechaIngreso  = :FechaIngreso,
                TipoFactura = :TipoFactura,
                TotalSinIva = :TotalSinIva,
                IVA = :IVA,
                IdEstado = 2,
                UsuarioCreador=:UsuarioCreador";
    $stmt = $this->conn->prepare($query);
    $this->NoFactura = htmlspecialchars(strip_tags($this->NoFactura));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $this->FechaFactura = htmlspecialchars(strip_tags($this->FechaFactura));
    $this->FechaIngreso = htmlspecialchars(strip_tags($this->FechaIngreso));
    $this->TipoFactura = htmlspecialchars(strip_tags($this->TipoFactura));
    $this->TotalSinIva = htmlspecialchars(strip_tags($this->TotalSinIva));
    $this->IVA = htmlspecialchars(strip_tags($this->IVA));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':NoFactura', $this->NoFactura);
    $stmt->bindParam(':IdProveedor', $this->IdProveedor);
    $stmt->bindParam(':FechaFactura', $this->FechaFactura);
    $stmt->bindParam(':FechaIngreso', $this->FechaIngreso);
    $stmt->bindParam(':TipoFactura', $this->TipoFactura);
    $stmt->bindParam(':TotalSinIva', $this->TotalSinIva);
    $stmt->bindParam(':IVA', $this->IVA);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function createDetalle($id, $array)
  {
    $query = "INSERT INTO factura_detalle
              SET
                IdCP = :IdCP,
                Lote = :Lote,
                IdProducto = :IdProducto,
                Cantidad = :Cantidad,
                IdUnidadMedida=:IdUnidadMedida";

    $stmt = $this->conn->prepare($query);
    $i = 0;
    $len = count($array);
    foreach ($array as $item) {

      $stmt->bindValue(':IdCP', $id);
      $stmt->bindValue(':Lote', '00' . $id);
      $stmt->bindValue(':IdProducto', $item->Producto);
      $stmt->bindValue(':Cantidad', $item->Cantidad);
      $stmt->bindValue(':IdUnidadMedida', $item->UnidadMedida);
      if ($stmt->execute()) { } else {
        $arr = $stmt->errorInfo();
      }
      if ($i == $len - 1) {
        return true;
      }
      $i++;
    }
  }

  function readLotes()
  {
    $query = "SELECT 
                fc.IdCP, fc.IdEstado, e.Nombre as NombreEstado, CONCAT('00',fc.IdCP)AS Lote , NoFactura, fc.IdProveedor, p.Nombre as NombreProveedor,
                fc.FechaCreacion FROM factura_cabecera fc
              LEFT JOIN 
                estados e ON fc.IdEstado=e.IdEstado
              LEFT JOIN 
                proveedores p ON fc.IdProveedor=p.IdProveedor
              ORDER BY 
                fechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function readDetalleLote()
  {
    $query = "SELECT 
                fd.IdCPdetalle, p.IdProducto,p.Nombre, Cantidad, um.IdUnidadMedida, um.Nombre as NombreUnidad FROM factura_cabecera fc
              LEFT JOIN 
                factura_detalle fd ON fc.IdCP=fd.IdCP
              LEFT JOIN 
                productos p ON fd.IdProducto=p.IdProducto
              LEFT JOIN 
                unidad_medida um ON fd.IdUnidadMedida=um.IdUnidadMedida
              WHERE 
                fc.IdCP = ? ";
    $stmt = $this->conn->prepare($query);
    $this->IdCP = htmlspecialchars(strip_tags($this->IdCP));
    $stmt->bindParam(1, $this->IdCP);
    $stmt->execute();
    return $stmt;
  }
  function changeStateFactura()
  {
    $query = "UPDATE
                factura_cabecera
              SET
                IdEstado=:IdEstado
              WHERE
                IdCP=:IdCP";
    $stmt = $this->conn->prepare($query);

    $this->IdEstado = htmlspecialchars(strip_tags($this->IdEstado));
    $this->IdCP = htmlspecialchars(strip_tags($this->IdCP));

    $stmt->bindParam(':IdEstado', $this->IdEstado);
    $stmt->bindParam(':IdCP', $this->IdCP);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
