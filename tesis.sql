-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.38-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para tesis
CREATE DATABASE IF NOT EXISTS `tesis` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tesis`;

-- Volcando estructura para tabla tesis.centro_produccion
CREATE TABLE IF NOT EXISTS `centro_produccion` (
  `Id` int(11) NOT NULL,
  `Lote` varchar(15) NOT NULL,
  `IdEmpresa` int(11) NOT NULL,
  `NoFactura` varchar(20) NOT NULL,
  `IdProveedor` int(11) NOT NULL,
  `FechaFactura` datetime DEFAULT NULL,
  `FechaIngreso` datetime DEFAULT NULL,
  `TipoFactura` varchar(5) NOT NULL,
  `TotalSinIva` decimal(14,7) DEFAULT NULL,
  `Iva` decimal(14,7) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEmpresa`,`NoFactura`,`TipoFactura`,`IdProveedor`,`Lote`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  KEY `IdProveedor` (`IdProveedor`),
  CONSTRAINT `centro_produccion_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `centro_produccion_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `centro_produccion_ibfk_3` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedores` (`IdProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.centro_produccion: ~0 rows (aproximadamente)
DELETE FROM `centro_produccion`;
/*!40000 ALTER TABLE `centro_produccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `centro_produccion` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.centro_produccion_detalle
CREATE TABLE IF NOT EXISTS `centro_produccion_detalle` (
  `IdCentroProduccionDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `Lote` varchar(15) DEFAULT NULL,
  `IdEmpresa` int(11) DEFAULT NULL,
  `NoFactura` varchar(20) DEFAULT NULL,
  `TipoFactura` varchar(5) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  `IdProducto` int(11) DEFAULT NULL,
  `PrecioUnitario` decimal(14,7) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `IdUnidadMedida` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdCentroProduccionDetalle`),
  KEY `IdEmpresa` (`IdEmpresa`,`NoFactura`,`TipoFactura`,`IdProveedor`,`Lote`),
  CONSTRAINT `centro_produccion_detalle_ibfk_1` FOREIGN KEY (`IdEmpresa`, `NoFactura`, `TipoFactura`, `IdProveedor`, `Lote`) REFERENCES `centro_produccion` (`IdEmpresa`, `NoFactura`, `TipoFactura`, `IdProveedor`, `Lote`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.centro_produccion_detalle: ~0 rows (aproximadamente)
DELETE FROM `centro_produccion_detalle`;
/*!40000 ALTER TABLE `centro_produccion_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `centro_produccion_detalle` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `IdEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(500) NOT NULL,
  `Razon_Social` varchar(150) NOT NULL,
  `Direccion` text NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEmpresa`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `empresas_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.empresas: ~5 rows (aproximadamente)
DELETE FROM `empresas`;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`IdEmpresa`, `Nombre`, `Razon_Social`, `Direccion`, `Telefono`, `Correo`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'La Pizzeria', 'Siete Grados S.A de C.V', 'santa elena', '22436017', 'a.molina@mupi.com.sv', 0, '2019-05-31 14:58:35', 1, '2019-05-31 14:58:56', NULL),
	(2, 'Picnic', 'Picnic S.A de C.V', 'Boqueron', '22436017', 'a.molna@mupi.com.sv', 0, '2019-07-05 18:42:27', 1, '2019-07-05 18:43:13', NULL),
	(3, 'La Isla', 'La Isla S.A de C.V', 'Palmarcito', '22436017', 'a.molina@mupi.com.sv', 0, '2019-07-14 20:42:33', NULL, '2019-07-14 20:42:33', NULL),
	(4, 'a', 'a', 'atest', '2222222', 'aaaa@aaa.com', 0, '2019-07-15 18:24:51', NULL, '2019-07-16 22:18:13', NULL),
	(5, 'b', 'basura', 'b', '4444444', 'bbbb@bb.com', 0, '2019-07-15 18:26:11', NULL, '2019-07-16 22:18:08', NULL),
	(6, 'testdd', 'testssss', 'testss', '222222211', '22212@2222.com', 0, '2019-07-16 22:04:19', NULL, '2019-07-19 17:23:28', NULL);
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.estados
CREATE TABLE IF NOT EXISTS `estados` (
  `IdEstado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text NOT NULL,
  `IdEstadoAnterior` int(11) DEFAULT NULL,
  `IdEstadoSiguiente` int(11) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEstado`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  CONSTRAINT `estados_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `estados_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.estados: ~0 rows (aproximadamente)
DELETE FROM `estados`;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` (`IdEstado`, `Nombre`, `Descripcion`, `IdEstadoAnterior`, `IdEstadoSiguiente`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Enviado', 'eviado', 1, 2, '2019-07-14 20:35:24', 1, '2019-07-14 20:35:26', NULL);
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.lista_existente
CREATE TABLE IF NOT EXISTS `lista_existente` (
  `IdListaExistene` int(11) NOT NULL AUTO_INCREMENT,
  `IdSucursal` int(11) NOT NULL,
  `FechaPedido` datetime NOT NULL,
  `IdEstado` int(11) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) NOT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UsuarioActualiza` int(11) NOT NULL,
  PRIMARY KEY (`IdListaExistene`),
  KEY `FK1_sucursal2` (`IdSucursal`),
  KEY `FK2_estado2` (`IdEstado`),
  KEY `FK3_usuario2` (`UsuarioCreador`),
  CONSTRAINT `FK2_estado2` FOREIGN KEY (`IdEstado`) REFERENCES `estados` (`IdEstado`) ON UPDATE CASCADE,
  CONSTRAINT `FK3_usuario2` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.lista_existente: ~0 rows (aproximadamente)
DELETE FROM `lista_existente`;
/*!40000 ALTER TABLE `lista_existente` DISABLE KEYS */;
/*!40000 ALTER TABLE `lista_existente` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.lista_producto_porcion
CREATE TABLE IF NOT EXISTS `lista_producto_porcion` (
  `IdListaPP` int(11) NOT NULL AUTO_INCREMENT,
  `IdProducto` int(11) NOT NULL,
  `IdPorcion` int(11) NOT NULL,
  `Estado` int(11) NOT NULL,
  `FechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdListaPP`),
  KEY `FK1_producto` (`IdProducto`),
  KEY `FK2_produccion` (`IdPorcion`),
  KEY `FK3_usuario` (`UsuarioCreador`),
  CONSTRAINT `FK1_producto` FOREIGN KEY (`IdProducto`) REFERENCES `productos` (`IdProducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_produccion` FOREIGN KEY (`IdPorcion`) REFERENCES `porciones` (`IdPorcion`) ON UPDATE CASCADE,
  CONSTRAINT `FK3_usuario` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.lista_producto_porcion: ~0 rows (aproximadamente)
DELETE FROM `lista_producto_porcion`;
/*!40000 ALTER TABLE `lista_producto_porcion` DISABLE KEYS */;
INSERT INTO `lista_producto_porcion` (`IdListaPP`, `IdProducto`, `IdPorcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`) VALUES
	(1, 1, 1, 0, '2019-07-12 11:52:35', 1);
/*!40000 ALTER TABLE `lista_producto_porcion` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.materia_prima
CREATE TABLE IF NOT EXISTS `materia_prima` (
  `IdMateriaPrima` int(11) NOT NULL AUTO_INCREMENT,
  `IdProducto` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `IdPorcion` int(11) DEFAULT NULL,
  `IdSucursal` int(11) DEFAULT NULL,
  `IdEmpresa` int(11) DEFAULT NULL,
  `FechaVencimiento` datetime DEFAULT NULL,
  `IdProduccion` int(11) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdMateriaPrima`),
  KEY `IdProducto` (`IdProducto`),
  KEY `IdSucursal` (`IdSucursal`),
  KEY `IdPorcion` (`IdPorcion`),
  KEY `IdEmpresa` (`IdEmpresa`),
  CONSTRAINT `materia_prima_ibfk_1` FOREIGN KEY (`IdProducto`) REFERENCES `productos` (`IdProducto`),
  CONSTRAINT `materia_prima_ibfk_3` FOREIGN KEY (`IdPorcion`) REFERENCES `porciones` (`IdPorcion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.materia_prima: ~0 rows (aproximadamente)
DELETE FROM `materia_prima`;
/*!40000 ALTER TABLE `materia_prima` DISABLE KEYS */;
/*!40000 ALTER TABLE `materia_prima` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.pedido
CREATE TABLE IF NOT EXISTS `pedido` (
  `IdPedido` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpresa` varchar(20) NOT NULL,
  `IdSucursal` int(11) DEFAULT NULL,
  `FechaPedido` datetime DEFAULT NULL,
  `IdEstado` int(11) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPedido`,`IdEmpresa`),
  KEY `IdEmpresa` (`IdEmpresa`),
  KEY `IdSucursal` (`IdSucursal`),
  KEY `IdEstado` (`IdEstado`),
  CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`IdEstado`) REFERENCES `estados` (`IdEstado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.pedido: ~0 rows (aproximadamente)
DELETE FROM `pedido`;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.pedido_detalle
CREATE TABLE IF NOT EXISTS `pedido_detalle` (
  `IdPedidoDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `IdPedido` int(11) DEFAULT NULL,
  `IdProducto` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `IdPorcion` int(11) DEFAULT NULL,
  `IdEmpresa` varchar(20) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPedidoDetalle`),
  KEY `IdPedido` (`IdPedido`,`IdEmpresa`),
  CONSTRAINT `pedido_detalle_ibfk_1` FOREIGN KEY (`IdPedido`, `IdEmpresa`) REFERENCES `pedido` (`IdPedido`, `IdEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.pedido_detalle: ~0 rows (aproximadamente)
DELETE FROM `pedido_detalle`;
/*!40000 ALTER TABLE `pedido_detalle` DISABLE KEYS */;
INSERT INTO `pedido_detalle` (`IdPedidoDetalle`, `IdPedido`, `IdProducto`, `Cantidad`, `IdPorcion`, `IdEmpresa`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 1, NULL, NULL, NULL, NULL, '2019-07-14 20:35:48', NULL, '2019-07-14 20:35:48', NULL);
/*!40000 ALTER TABLE `pedido_detalle` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.permisos
CREATE TABLE IF NOT EXISTS `permisos` (
  `IdPermiso` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text NOT NULL,
  `Estado` tinyint(1) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPermiso`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.permisos: ~0 rows (aproximadamente)
DELETE FROM `permisos`;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.permisos_usuarios
CREATE TABLE IF NOT EXISTS `permisos_usuarios` (
  `IdPermisosusuario` int(11) NOT NULL AUTO_INCREMENT,
  `IdPermiso` int(11) NOT NULL,
  `Idusuario` int(11) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPermisosusuario`,`IdPermiso`,`Idusuario`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  CONSTRAINT `permisos_usuarios_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `permisos_usuarios_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.permisos_usuarios: ~0 rows (aproximadamente)
DELETE FROM `permisos_usuarios`;
/*!40000 ALTER TABLE `permisos_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `permisos_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.porciones
CREATE TABLE IF NOT EXISTS `porciones` (
  `IdPorcion` int(11) NOT NULL AUTO_INCREMENT,
  `Cantidad` decimal(10,2) NOT NULL,
  `IdUnidadMedida` int(11) NOT NULL,
  `Estado` tinyint(1) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPorcion`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  KEY `IdUnidadMedida` (`IdUnidadMedida`),
  CONSTRAINT `porciones_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `porciones_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `porciones_ibfk_3` FOREIGN KEY (`IdUnidadMedida`) REFERENCES `unidad_medida` (`IdUnidadMedida`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.porciones: ~5 rows (aproximadamente)
DELETE FROM `porciones`;
/*!40000 ALTER TABLE `porciones` DISABLE KEYS */;
INSERT INTO `porciones` (`IdPorcion`, `Cantidad`, `IdUnidadMedida`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 5.00, 1, 0, '2019-07-12 11:36:47', 1, '2019-07-12 11:36:49', NULL),
	(2, 4.00, 1, 0, '2019-07-12 11:37:27', 1, '2019-07-12 11:37:29', NULL),
	(3, 2.00, 1, 0, '2019-07-12 11:37:38', 1, '2019-07-12 11:37:39', NULL),
	(4, 1.50, 1, 0, '2019-07-12 11:37:51', 1, '2019-07-12 11:37:53', NULL),
	(5, 1.00, 1, 0, '2019-07-12 11:38:02', 1, '2019-07-12 11:38:04', NULL),
	(6, 0.50, 1, 0, '2019-07-12 11:38:11', 1, '2019-07-12 11:38:13', NULL);
/*!40000 ALTER TABLE `porciones` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.produccion
CREATE TABLE IF NOT EXISTS `produccion` (
  `IdProduccion` int(11) NOT NULL AUTO_INCREMENT,
  `IdProducto` int(11) DEFAULT NULL,
  `Lote` varchar(15) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `IdPorcion` int(11) DEFAULT NULL,
  `FechaVencimiento` datetime DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdProduccion`),
  KEY `IdProducto` (`IdProducto`),
  CONSTRAINT `produccion_ibfk_1` FOREIGN KEY (`IdProducto`) REFERENCES `productos` (`IdProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.produccion: ~0 rows (aproximadamente)
DELETE FROM `produccion`;
/*!40000 ALTER TABLE `produccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `produccion` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `IdProducto` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) DEFAULT NULL,
  `Descripcion` text,
  `IdTipoProducto` int(11) DEFAULT NULL,
  `IdUnidadMedida` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  `Estado` int(11) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdProducto`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  KEY `IdTipoProducto` (`IdTipoProducto`),
  KEY `IdUnidadMedida` (`IdUnidadMedida`),
  KEY `IdProveedor` (`IdProveedor`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`IdTipoProducto`) REFERENCES `tipo_producto` (`IdTipoProducto`),
  CONSTRAINT `productos_ibfk_4` FOREIGN KEY (`IdUnidadMedida`) REFERENCES `unidad_medida` (`IdUnidadMedida`),
  CONSTRAINT `productos_ibfk_5` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedores` (`IdProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.productos: ~2 rows (aproximadamente)
DELETE FROM `productos`;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`IdProducto`, `Nombre`, `Descripcion`, `IdTipoProducto`, `IdUnidadMedida`, `IdProveedor`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Queso Mozarella', 'queso pizzas', 1, 3, 1, 0, '2019-07-12 11:34:40', 1, '2019-07-22 18:39:37', NULL),
	(2, 'Queso Cheddars', 'queso pizzas', 1, 3, 1, 0, '2019-07-12 11:35:32', 1, '2019-07-22 18:39:39', NULL);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.proveedores
CREATE TABLE IF NOT EXISTS `proveedores` (
  `IdProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(500) NOT NULL,
  `Direccion` text NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Razo_Social` varchar(500) NOT NULL,
  `Tipo` char(5) NOT NULL,
  `Nombre_Contacto` varchar(250) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `DUI` varchar(10) DEFAULT NULL,
  `NIT` varchar(17) NOT NULL,
  `NRC` varchar(20) DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdProveedor`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  CONSTRAINT `proveedores_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `proveedores_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.proveedores: ~0 rows (aproximadamente)
DELETE FROM `proveedores`;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` (`IdProveedor`, `Nombre`, `Direccion`, `Telefono`, `Razo_Social`, `Tipo`, `Nombre_Contacto`, `Email`, `DUI`, `NIT`, `NRC`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Lactolac', 'plan de la laguna', '22589634', 'Lactolac S.A de C.V', '0', 'Edwin Ramirez', 'eramirez@lactolac.com', '789556335', '4859636', '896357412', 0, '2019-05-31 16:26:27', 1, '2019-05-31 16:26:31', NULL),
	(2, 'Salud', 'plaz de la laguna', '22589634', 'Salud S.A de C.V', '0', 'Marvin Rivas', 'marvinrivas@salud.com', '785964336', '2856596', '284562636', 0, '2019-07-12 11:34:05', 1, '2019-07-12 11:34:09', NULL);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.sucursales
CREATE TABLE IF NOT EXISTS `sucursales` (
  `IdSucursal` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpresa` int(11) NOT NULL,
  `Nombre` varchar(250) NOT NULL,
  `Direccion` text,
  `Telefono` varchar(20) DEFAULT NULL,
  `IdEncargado` int(11) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdSucursal`,`IdEmpresa`),
  KEY `IdEncargado` (`IdEncargado`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  CONSTRAINT `sucursales_ibfk_1` FOREIGN KEY (`IdEncargado`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `sucursales_ibfk_2` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `sucursales_ibfk_3` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.sucursales: ~4 rows (aproximadamente)
DELETE FROM `sucursales`;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;
INSERT INTO `sucursales` (`IdSucursal`, `IdEmpresa`, `Nombre`, `Direccion`, `Telefono`, `IdEncargado`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 0, 'LP Volcan', 'calle al boqueron', '22436017', 1, 0, '2019-05-31 15:52:56', 1, '2019-05-31 15:53:00', NULL),
	(2, 0, 'Lp Castanos', 'plaza castanos', '22436017', 3, 0, '2019-07-10 20:33:07', NULL, '2019-07-10 20:33:09', NULL),
	(3, 0, 'seeesss', 'sxczxc', 's', NULL, 0, '2019-07-22 17:33:20', NULL, '2019-07-22 18:05:18', NULL),
	(4, 0, 'Vamos', 'Pa', '789623', NULL, 1, '2019-07-22 18:04:58', NULL, '2019-07-22 18:05:14', NULL);
/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.tipos_usuario
CREATE TABLE IF NOT EXISTS `tipos_usuario` (
  `IdTipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` text,
  `Estado` tinyint(1) DEFAULT NULL,
  `FechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.tipos_usuario: ~13 rows (aproximadamente)
DELETE FROM `tipos_usuario`;
/*!40000 ALTER TABLE `tipos_usuario` DISABLE KEYS */;
INSERT INTO `tipos_usuario` (`IdTipoUsuario`, `Nombre`, `Descripcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(4, '44', '4', 0, '2019-07-12 18:52:41', NULL, '2019-07-17 17:47:02', NULL),
	(12, 'Edua', 'EEEED', 0, '2019-07-13 22:57:07', NULL, '2019-07-17 17:47:04', NULL),
	(13, '111', 'qqqqq', 0, '2019-07-13 23:02:07', NULL, '2019-07-16 22:41:45', NULL),
	(15, 'Test 2', 'Test Des', 0, '2019-07-14 19:06:27', NULL, '2019-07-22 19:03:48', NULL),
	(16, 'Heyeh', 'Jajfbdkd', 1, '2019-07-13 23:05:27', NULL, '2019-07-17 18:10:21', NULL),
	(17, 'admin', 'admin', 1, '2019-07-16 21:59:46', NULL, '2019-07-17 18:10:17', NULL),
	(18, 'test', 'test', 1, '2019-07-16 22:01:54', NULL, '2019-07-17 18:10:05', NULL),
	(19, 'test 2', 'test 2', 1, '2019-07-16 22:02:44', NULL, '2019-07-17 17:48:29', NULL),
	(20, 'test', 'test', 1, '2019-07-17 17:29:45', NULL, '2019-07-17 17:48:20', NULL),
	(21, 'test2', 'test2', 1, '2019-07-17 17:29:55', NULL, '2019-07-17 17:32:40', NULL),
	(22, 'test222', 'test2222', 1, '2019-07-17 17:30:04', NULL, '2019-07-17 17:30:08', NULL),
	(23, 'test', 'test', 1, '2019-07-19 17:16:04', NULL, '2019-07-19 17:16:09', NULL),
	(24, '7868768', 'ygubin', 0, '2019-07-22 19:29:46', NULL, '2019-07-22 19:29:46', NULL);
/*!40000 ALTER TABLE `tipos_usuario` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.tipo_producto
CREATE TABLE IF NOT EXISTS `tipo_producto` (
  `IdTipoProducto` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` text,
  `Estado` tinyint(1) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdTipoProducto`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  CONSTRAINT `tipo_producto_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `tipo_producto_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.tipo_producto: ~0 rows (aproximadamente)
DELETE FROM `tipo_producto`;
/*!40000 ALTER TABLE `tipo_producto` DISABLE KEYS */;
INSERT INTO `tipo_producto` (`IdTipoProducto`, `Nombre`, `Descripcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Lacteos', 'comida lacteos', 0, '2019-05-31 16:39:06', 1, '2019-05-31 16:39:10', NULL),
	(2, 'Carnes', 'tipo de carnes', 0, '2019-07-12 11:32:37', 1, '2019-07-12 11:32:39', NULL);
/*!40000 ALTER TABLE `tipo_producto` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.unidad_medida
CREATE TABLE IF NOT EXISTS `unidad_medida` (
  `IdUnidadMedida` int(11) NOT NULL AUTO_INCREMENT,
  `Siglas` varchar(5) DEFAULT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUnidadMedida`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  CONSTRAINT `unidad_medida_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `unidad_medida_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.unidad_medida: ~8 rows (aproximadamente)
DELETE FROM `unidad_medida`;
/*!40000 ALTER TABLE `unidad_medida` DISABLE KEYS */;
INSERT INTO `unidad_medida` (`IdUnidadMedida`, `Siglas`, `Nombre`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'ONZ', 'Onzas', 0, '2019-05-31 16:15:58', 1, '2019-05-31 16:16:03', NULL),
	(2, 'Unr', 'Unidad', 0, '2019-07-12 11:33:07', 1, '2019-07-22 17:15:03', NULL),
	(3, 'Kg', 'Kilogramo', 0, '2019-07-12 11:35:03', 1, '2019-07-12 11:35:04', NULL),
	(4, 'Kgs', 'Kilogramod', 0, '0000-00-00 00:00:00', NULL, '2019-07-19 18:34:34', NULL),
	(5, 'LB', 'libras', 0, '0000-00-00 00:00:00', NULL, '2019-07-19 18:31:32', NULL),
	(6, 'asdd', 'as', 1, '2019-07-19 18:33:04', NULL, '2019-07-19 18:37:47', NULL),
	(7, 'qq', 'qqrr', 0, '0000-00-00 00:00:00', NULL, '2019-07-19 18:33:56', NULL),
	(8, 'qqwep', 'qwer', 0, '2019-07-19 18:42:03', NULL, '2019-07-19 18:44:10', NULL);
/*!40000 ALTER TABLE `unidad_medida` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(500) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Passwd` varchar(256) NOT NULL,
  `PasswdTmp` varchar(256) DEFAULT NULL,
  `Alias` varchar(15) NOT NULL,
  `IdTipoUsuario` int(11) NOT NULL,
  `Estado` tinyint(1) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`),
  KEY `IdTipoUsuario` (`IdTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.usuarios: ~5 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`IdUsuario`, `Nombre`, `Email`, `Passwd`, `PasswdTmp`, `Alias`, `IdTipoUsuario`, `Estado`, `FechaCreacion`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Irvin', 'irvin@demo.com', '1234', NULL, 'irvin', 0, 0, '2019-05-24 16:27:50', '2019-05-24 16:28:00', 1),
	(3, 'Alejandro', 'ale@ale.com', '$2y$10$zl/3cr3ekslKNB1yyUrD4.BWdQyeizWPVezv2Tt9sUoyB.Z9CXlTW', NULL, 'toyo', 0, 0, '2019-06-06 11:05:54', '2019-06-06 11:06:06', NULL),
	(5, 'Raul', 'raul@ale.com', '$2y$10$Dox.nha0m7PjXRbb9.1ws.ANa4QhUR5erBmKjSOYCoeIN1aKXDJ9.', NULL, 'raus', 0, NULL, '2019-06-06 16:35:50', '2019-06-06 16:35:50', NULL),
	(12, 'irvin', 'i@i.com', '$2y$10$FGgErlcWjpbnKiU0AymnFuoljuq3wc180zv1hC7D.Fdgi13qPfdSG', NULL, 'marmota', 0, NULL, '2019-07-05 18:10:33', '2019-07-05 18:10:33', NULL),
	(13, 'Raul', 'raul.sosa@outlook.com', '$2y$10$LSzm1adEaQfGKljIk9X/auVGprIb23FaKkrKG3HiZa6Krb6Q9zGLe', NULL, 'raul', 0, NULL, '2019-07-06 16:04:48', '2019-07-06 16:04:48', NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
