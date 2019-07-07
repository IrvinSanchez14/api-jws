-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.38-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.1.0.5464
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
  `IdEmpresa` varchar(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.empresas: ~2 rows (aproximadamente)
DELETE FROM `empresas`;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`IdEmpresa`, `Nombre`, `Razon_Social`, `Direccion`, `Telefono`, `Correo`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	('1', 'La Pizzeria', 'Siete Grados S.A de C.V', 'santa elena', '22436017', 'a.molina@mupi.com.sv', 0, '2019-05-31 14:58:35', 1, '2019-05-31 14:58:56', NULL),
	('2', 'Picnic', 'Picnic S.A de C.V', 'Boqueron', '22436017', 'a.molna@mupi.com.sv', 0, '2019-07-05 18:42:27', 1, '2019-07-05 18:43:13', NULL);
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.estados: ~0 rows (aproximadamente)
DELETE FROM `estados`;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.materia_prima
CREATE TABLE IF NOT EXISTS `materia_prima` (
  `IdMateriaPrima` int(11) NOT NULL AUTO_INCREMENT,
  `IdProducto` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `IdPorcion` int(11) DEFAULT NULL,
  `IdSucursal` varchar(15) DEFAULT NULL,
  `IdEmpresa` varchar(20) DEFAULT NULL,
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
  CONSTRAINT `materia_prima_ibfk_2` FOREIGN KEY (`IdSucursal`) REFERENCES `sucursales` (`IdSucursal`),
  CONSTRAINT `materia_prima_ibfk_3` FOREIGN KEY (`IdPorcion`) REFERENCES `porciones` (`IdPorcion`),
  CONSTRAINT `materia_prima_ibfk_4` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresas` (`IdEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.materia_prima: ~0 rows (aproximadamente)
DELETE FROM `materia_prima`;
/*!40000 ALTER TABLE `materia_prima` DISABLE KEYS */;
/*!40000 ALTER TABLE `materia_prima` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.pedido
CREATE TABLE IF NOT EXISTS `pedido` (
  `IdPedido` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpresa` varchar(20) NOT NULL,
  `IdSucursal` varchar(15) DEFAULT NULL,
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
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresas` (`IdEmpresa`),
  CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`IdSucursal`) REFERENCES `sucursales` (`IdSucursal`),
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.pedido_detalle: ~0 rows (aproximadamente)
DELETE FROM `pedido_detalle`;
/*!40000 ALTER TABLE `pedido_detalle` DISABLE KEYS */;
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
  `Cantidad` decimal(14,7) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.porciones: ~0 rows (aproximadamente)
DELETE FROM `porciones`;
/*!40000 ALTER TABLE `porciones` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.productos: ~0 rows (aproximadamente)
DELETE FROM `productos`;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.proveedores: ~0 rows (aproximadamente)
DELETE FROM `proveedores`;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` (`IdProveedor`, `Nombre`, `Direccion`, `Telefono`, `Razo_Social`, `Tipo`, `Nombre_Contacto`, `Email`, `DUI`, `NIT`, `NRC`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Lactolac', 'plan de la laguna', '22589634', 'Lactolac S.A de C.V', '0', 'Edwin Ramirez', 'eramirez@lactolac.com', '789556335', '4859636', '896357412', 0, '2019-05-31 16:26:27', 1, '2019-05-31 16:26:31', NULL);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.sucursales
CREATE TABLE IF NOT EXISTS `sucursales` (
  `IdSucursal` varchar(15) NOT NULL,
  `IdEmpresa` varchar(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.sucursales: ~0 rows (aproximadamente)
DELETE FROM `sucursales`;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;
INSERT INTO `sucursales` (`IdSucursal`, `IdEmpresa`, `Nombre`, `Direccion`, `Telefono`, `IdEncargado`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	('1', 'q', 'LP Volcan', 'calle al boqueron', '22436017', 1, 0, '2019-05-31 15:52:56', 1, '2019-05-31 15:53:00', NULL);
/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.tipos_usuario
CREATE TABLE IF NOT EXISTS `tipos_usuario` (
  `IdTipoUsuario` varchar(10) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` text,
  `Estado` tinyint(1) DEFAULT NULL,
  `FechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdTipoUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.tipos_usuario: ~9 rows (aproximadamente)
DELETE FROM `tipos_usuario`;
/*!40000 ALTER TABLE `tipos_usuario` DISABLE KEYS */;
INSERT INTO `tipos_usuario` (`IdTipoUsuario`, `Nombre`, `Descripcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	('a', 'a', 'a', 1, '2019-07-06 16:18:07', NULL, '2019-07-06 16:20:52', NULL),
	('ADM002', 'ADMIN', 'administrador de la aplicacion', 0, '2019-05-24 16:32:38', 1, '2019-05-24 16:33:04', 0),
	('ADM003', 'a', 'a', 0, '2019-07-06 16:09:20', NULL, '2019-07-06 16:09:26', NULL),
	('b', 'b', 'b', 1, '2019-07-06 16:19:01', NULL, '2019-07-06 16:20:57', NULL),
	('c', 'c', 'c', 1, '2019-07-06 16:19:59', NULL, '2019-07-06 16:20:47', NULL),
	('iii3', 'ii333', 'ii3', 0, '2019-06-05 11:36:03', NULL, '2019-06-24 17:14:35', NULL),
	('prueba', 'prueba 111', 'es una prueba', 0, '2019-05-24 16:33:38', 1, '2019-06-24 17:14:37', 0),
	('r', 'r', 'r', 1, '2019-07-06 16:21:07', NULL, '2019-07-06 16:21:12', NULL),
	('SU01', 'Supervisor', 'Encargado de cada sucursal', 0, '2019-06-24 18:11:22', NULL, '2019-06-24 19:03:59', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.tipo_producto: ~0 rows (aproximadamente)
DELETE FROM `tipo_producto`;
/*!40000 ALTER TABLE `tipo_producto` DISABLE KEYS */;
INSERT INTO `tipo_producto` (`IdTipoProducto`, `Nombre`, `Descripcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Lacteos', 'comida lacteos', 0, '2019-05-31 16:39:06', 1, '2019-05-31 16:39:10', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.unidad_medida: ~0 rows (aproximadamente)
DELETE FROM `unidad_medida`;
/*!40000 ALTER TABLE `unidad_medida` DISABLE KEYS */;
INSERT INTO `unidad_medida` (`IdUnidadMedida`, `Siglas`, `Nombre`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'ONZ', 'Onzas', 0, '2019-05-31 16:15:58', 1, '2019-05-31 16:16:03', NULL);
/*!40000 ALTER TABLE `unidad_medida` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(500) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Passwd` varchar(256) NOT NULL,
  `PasswdTmp` varchar(256) DEFAULT NULL,
  `Alias` varchar(15) NOT NULL,
  `IdTipoUsuario` varchar(10) NOT NULL,
  `Estado` tinyint(1) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`),
  KEY `IdTipoUsuario` (`IdTipoUsuario`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`IdTipoUsuario`) REFERENCES `tipos_usuario` (`IdTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.usuarios: ~3 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`IdUsuario`, `Nombre`, `Email`, `Passwd`, `PasswdTmp`, `Alias`, `IdTipoUsuario`, `Estado`, `FechaCreacion`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Irvin', 'irvin@demo.com', '1234', NULL, 'irvin', 'ADM002', 0, '2019-05-24 16:27:50', '2019-05-24 16:28:00', 1),
	(3, 'Alejandro', 'ale@ale.com', '$2y$10$zl/3cr3ekslKNB1yyUrD4.BWdQyeizWPVezv2Tt9sUoyB.Z9CXlTW', NULL, 'toyo', 'ADM002', 0, '2019-06-06 11:05:54', '2019-06-06 11:06:06', NULL),
	(5, 'Raul', 'raul@ale.com', '$2y$10$Dox.nha0m7PjXRbb9.1ws.ANa4QhUR5erBmKjSOYCoeIN1aKXDJ9.', NULL, 'raus', 'ADM002', NULL, '2019-06-06 16:35:50', '2019-06-06 16:35:50', NULL),
	(12, 'irvin', 'i@i.com', '$2y$10$FGgErlcWjpbnKiU0AymnFuoljuq3wc180zv1hC7D.Fdgi13qPfdSG', NULL, 'marmota', 'ADM002', NULL, '2019-07-05 18:10:33', '2019-07-05 18:10:33', NULL),
	(13, 'Raul', 'raul.sosa@outlook.com', '$2y$10$LSzm1adEaQfGKljIk9X/auVGprIb23FaKkrKG3HiZa6Krb6Q9zGLe', NULL, 'raul', 'ADM002', NULL, '2019-07-06 16:04:48', '2019-07-06 16:04:48', NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
