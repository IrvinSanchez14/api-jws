<?php
class reporteria
{
  private $conn;
  public $FechaCreacion;
  public $IdSucursal;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function nota_envio_fecha_sucursal()
  {
    $query = "SELECT 
                pc.lote,pro.Nombre as nombreProducto ,CONCAT(po.Cantidad, ' ',um.Nombre)AS porcionNombre, ne.Cantidad,pr.FechaVencimiento, s.Nombre AS nombreSucursal FROM nota_envio ne
              LEFT JOIN 
                produccion pr ON ne.IdProduccion = pr.IdProduccion
              LEFT JOIN 
                produccion_cabecera pc ON pr.IdPC = pc.IdPC
              LEFT JOIN 
                productos pro ON pr.IdProducto=pro.IdProducto
              LEFT JOIN 
                porciones po ON pr.IdPorcion= po.IdPorcion
              LEFT JOIN 
                unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
              LEFT JOIN 
                sucursales s ON ne.IdSucursal=s.IdSucursal
              WHERE 
                DATE(ne.FechaCreacion) = ? AND s.IdSucursal = ?
              GROUP BY 
              s.IdSucursal, ne.IdNotaEnvio ";
    $stmt = $this->conn->prepare($query);
    $this->FechaCreacion = htmlspecialchars(strip_tags($this->FechaCreacion));
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));
    $stmt->bindParam(1, $this->FechaCreacion);
    $stmt->bindParam(2, $this->IdSucursal);
    $stmt->execute();
    return $stmt;
  }
}
