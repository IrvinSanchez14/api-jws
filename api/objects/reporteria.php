<?php
class reporteria
{
  private $conn;
  public $FechaCreacion;
  public $IdSucursal;
  public $FechaDesde;
  public $FechaHasta;
  public $IdProducto;
  public $IdTipoProducto;
  public $IdProveedor;
  public $TipoFactura;
  public $NoFactura;
  public $IdCP;

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

  function facturaporfecha()
  {
    $query = "SELECT 
                 facab.IdCP,facab.NoFactura, prov.Nombre AS Proveedor, facab.FechaFactura, if(facab.TipoFactura =1,'Factura','Credito Fiscal' )AS tipoDocumento, facab.TotalSinIva ,facab.IVA, facab.FechaCreacion
              FROM 
                factura_cabecera AS facab
              LEFT JOIN 
                proveedores prov ON facab.IdProveedor = prov.IdProveedor
              WHERE 
                date(facab.FechaCreacion) = ?
              GROUP BY 
                facab.IdCP
              ORDER BY 
                facab.FechaCreacion DESC";

    $stmt = $this->conn->prepare($query);
    $this->FechaCreacion = htmlspecialchars(strip_tags($this->FechaCreacion));
    $stmt->bindParam(1, $this->FechaCreacion);
    $stmt->execute();
    return $stmt;
  }

  function facrangofechyprovee()
  {
    $query = "SELECT 
                facab.IdCP,facab.NoFactura, prov.Nombre AS Proveedor, facab.FechaFactura, if(facab.TipoFactura =1,'Factura','Credito Fiscal' )AS TipoFactura, facab.TotalSinIva ,facab.IVA, facab.fechaCreacion FROM factura_cabecera AS facab
              LEFT JOIN 
                proveedores prov ON facab.IdProveedor = prov.IdProveedor
              WHERE 
                date(facab.FechaCreacion) between ? AND ? AND prov.IdProveedor = ?
              GROUP BY 
                facab.IdCP
              ORDER BY 
                facab.FechaCreacion DESC";

    $stmt = $this->conn->prepare($query);
    $this->FechaDesde = htmlspecialchars(strip_tags($this->FechaDesde));
    $this->FechaHasta = htmlspecialchars(strip_tags($this->FechaHasta));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $stmt->bindParam(1, $this->FechaDesde);
    $stmt->bindParam(2, $this->FechaHasta);
    $stmt->bindParam(3, $this->IdProveedor);
    $stmt->execute();
    return $stmt;
  }

  function facturaportipo()
  {
    $query = "SELECT 
                facab.IdCP,facab.NoFactura, prov.Nombre AS Proveedor, facab.FechaFactura, if(facab.TipoFactura =1,'Factura','Credito Fiscal' )AS tipoDocumento, facab.TotalSinIva ,facab.IVA, facab.FechaCreacion FROM factura_cabecera AS facab
              LEFT JOIN 
                proveedores prov ON facab.IdProveedor = prov.IdProveedor
              WHERE 
                date(facab.FechaCreacion) between ? AND ? AND facab.TipoFactura = ?
              GROUP BY 
                facab.IdCP
              ORDER BY 
                facab.FechaCreacion DESC";

    $stmt = $this->conn->prepare($query);
    $this->FechaDesde = htmlspecialchars(strip_tags($this->FechaDesde));
    $this->FechaHasta = htmlspecialchars(strip_tags($this->FechaHasta));
    $this->TipoFactura = htmlspecialchars(strip_tags($this->TipoFactura));
    $stmt->bindParam(1, $this->FechaDesde);
    $stmt->bindParam(2, $this->FechaHasta);
    $stmt->bindParam(3, $this->TipoFactura);
    $stmt->execute();
    return $stmt;
  }

  function facturadetalle()
  {
    $query = "SELECT prod.Nombre AS Producto, facdet.Cantidad, unmed.Nombre AS UnidadMedida FROM factura_detalle AS facdet
    LEFT JOIN factura_cabecera fc ON facdet.IdCP = fc.IdCP 
    LEFT JOIN productos prod ON facdet.IdProducto = prod.IdProducto
    LEFT JOIN unidad_medida unmed ON facdet.IdUnidadMedida = unmed.IdUnidadMedida
    WHERE facdet.IdCP = ?
    GROUP BY facdet.IdCPdetalle
    ORDER BY fc.FechaCreacion DESC";

    $stmt = $this->conn->prepare($query);
    $this->IdCP = htmlspecialchars(strip_tags($this->IdCP));
    $stmt->bindParam(1, $this->IdCP);
    $stmt->execute();
    return $stmt;
  }

  function facturapornumero()
  {
    $query = "SELECT 
                facab.IdCP,facab.NoFactura, prov.Nombre AS Proveedor, facab.FechaFactura, if(facab.TipoFactura =1,'Factura','Credito Fiscal' )AS TipoFactura, facab.TotalSinIva ,facab.IVA, facab.FechaCreacion FROM factura_cabecera AS facab
              LEFT JOIN 
                proveedores prov ON facab.IdProveedor = prov.IdProveedor
              WHERE 
                prov.IdProveedor = ? AND facab.NoFactura = ?
              GROUP BY 
                facab.IdCP
              ORDER BY 
                facab.FechaCreacion DESC";

    $stmt = $this->conn->prepare($query);
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $this->NoFactura = htmlspecialchars(strip_tags($this->NoFactura));
    $stmt->bindParam(1, $this->IdProveedor);
    $stmt->bindParam(2, $this->NoFactura);
    $stmt->execute();
    return $stmt;
  }

  function nota_envio_sucursal()
  {
    $query = "SELECT pc.lote,pro.Nombre,CONCAT(po.Cantidad, ' ',um.Nombre)AS porcionNombre, ne.Cantidad,pr.FechaVencimiento, s.Nombre as Sucursal FROM nota_envio ne
    LEFT JOIN produccion pr ON ne.IdProduccion = pr.IdProduccion
    LEFT JOIN produccion_cabecera pc ON pr.IdPC = pc.IdPC
    LEFT JOIN productos pro ON pr.IdProducto=pro.IdProducto
    LEFT JOIN porciones po ON pr.IdPorcion= po.IdPorcion
    LEFT JOIN unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
    LEFT JOIN sucursales s ON ne.IdSucursal=s.IdSucursal
    WHERE DATE(ne.FechaCreacion) = '2019-11-03' AND s.IdSucursal = 1
    GROUP BY s.IdSucursal, ne.IdNotaEnvio";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function nota_envio_rangofecha_sucursal()
  {
    $query = "SELECT pc.lote,pro.Nombre AS producto,um.Nombre AS UnidadMedida, sum(ne.Cantidad * po.Cantidad)AS CantidadTotal,pr.FechaVencimiento, s.Nombre AS Sucursal FROM nota_envio ne
    LEFT JOIN produccion pr ON ne.IdProduccion = pr.IdProduccion
    LEFT JOIN produccion_cabecera pc ON pr.IdPC = pc.IdPC
    LEFT JOIN productos pro ON pr.IdProducto=pro.IdProducto
    LEFT JOIN porciones po ON pr.IdPorcion= po.IdPorcion
    LEFT JOIN unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
    LEFT JOIN sucursales s ON ne.IdSucursal=s.IdSucursal
    WHERE DATE(ne.FechaCreacion) BETWEEN  ? AND ?  AND pro.IdProducto = ?
    GROUP BY s.IdSucursal, pro.IdProducto";

    $stmt = $this->conn->prepare($query);
    $this->FechaDesde = htmlspecialchars(strip_tags($this->FechaDesde));
    $this->FechaHasta = htmlspecialchars(strip_tags($this->FechaHasta));
    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));
    $stmt->bindParam(1, $this->FechaDesde);
    $stmt->bindParam(2, $this->FechaHasta);
    $stmt->bindParam(3, $this->IdProducto);
    $stmt->execute();
    return $stmt;
  }

  function nota_envio_portipo()
  {
    $query = "SELECT pc.lote,pro.Nombre as Producto,CONCAT(po.Cantidad, ' ',um.Nombre)AS porcionNombre, ne.Cantidad,pr.FechaVencimiento, s.Nombre as Sucursal FROM nota_envio ne
LEFT JOIN produccion pr ON ne.IdProduccion = pr.IdProduccion
LEFT JOIN produccion_cabecera pc ON pr.IdPC = pc.IdPC
LEFT JOIN productos pro ON pr.IdProducto=pro.IdProducto
LEFT JOIN porciones po ON pr.IdPorcion= po.IdPorcion
LEFT JOIN unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
LEFT JOIN sucursales s ON ne.IdSucursal=s.IdSucursal
LEFT JOIN tipo_producto tp ON pro.IdTipoProducto = tp.IdTipoProducto
WHERE DATE(ne.FechaCreacion) BETWEEN  ? AND ? AND tp.IdTipoProducto = ? AND s.IdSucursal= ?
GROUP BY s.IdSucursal, ne.IdNotaEnvio
";

    $stmt = $this->conn->prepare($query);
    $this->FechaDesde = htmlspecialchars(strip_tags($this->FechaDesde));
    $this->FechaHasta = htmlspecialchars(strip_tags($this->FechaHasta));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));
    $stmt->bindParam(1, $this->FechaDesde);
    $stmt->bindParam(2, $this->FechaHasta);
    $stmt->bindParam(3, $this->IdTipoProducto);
    $stmt->bindParam(4, $this->IdSucursal);
    $stmt->execute();
    return $stmt;
  }

  function lista_existente_sucursal()
  {
    $query = "SELECT le.IdListaExistene, su.Nombre as Sucursal, us.Nombre AS Nombre_Usuario, es.Nombre AS Estado, le.FechaCreacion from lista_existente le
    LEFT JOIN sucursales su ON le.IdSucursal=su.IdSucursal
    LEFT JOIN usuarios us ON le.UsuarioCreador= us.IdUsuario
    LEFT JOIN estados es ON le.IdEstado = es.IdEstado
    WHERE DATE (le.FechaCreacion)= '2019-11-03' AND su.IdSucursal=1";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}
