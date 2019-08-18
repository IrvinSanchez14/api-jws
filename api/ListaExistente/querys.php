/*
SELECT le.IdListaExistene, su.Nombre, us.Nombre AS Nombre_Uuario, es.Nombre AS Estado, le.FechaCreacion from lista_existente le
LEFT JOIN sucursales su ON le.IdSucursal=su.IdSucursal
LEFT JOIN usuarios us ON le.UsuarioCreador= us.IdUsuario
LEFT JOIN estados es ON le.IdEstado = es.IdEstado
WHERE DATE (le.FechaCreacion)="2019-08-15"


Query 
SELECT ld.IdLista AS lista, le.IdListaExistene AS lista_Existente, pr.Nombre AS Producto, ld.Cantidad, CONCAT( po.Cantidad," ",um.Siglas) AS Porcion FROM lista_existente_detalle ld
LEFT JOIN productos pr ON ld.IdProducto=pr.IdProducto
LEFT JOIN porciones po ON ld.IdPorcion=po.IdPorcion
LEFT JOIN lista_existente le ON ld.IdListaExistene=le.IdListaExistene
LEFT JOIN unidad_medida um ON po.IdUnidadMedida=um.IdUnidadMedida
WHERE le.IdListaExistene = 1
*/




api lista exitentene carpeta
pdf file

objetos lista_existente
+ver cabecera lista 
    fecha
+ver lista 
    idLista