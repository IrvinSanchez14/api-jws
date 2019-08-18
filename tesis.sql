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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.empresas: ~11 rows (aproximadamente)
DELETE FROM `empresas`;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`IdEmpresa`, `Nombre`, `Razon_Social`, `Direccion`, `Telefono`, `Correo`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'La Pizzeria', 'Siete Grados S.A de C.V', 'santa elena', '22436017', 'a.molina@mupi.com.sv', 0, '2019-05-31 14:58:35', 1, '2019-05-31 14:58:56', NULL),
	(2, 'Picnic', 'Picnic S.A de C.V', 'Boqueron', '22436017', 'a.molna@mupi.com.sv', 0, '2019-07-05 18:42:27', 1, '2019-07-05 18:43:13', NULL),
	(3, 'La Isla', 'La Isla S.A de C.V', 'Palmarcito', '22436017', 'a.molina@mupi.com.sv', 0, '2019-07-14 20:42:33', NULL, '2019-07-14 20:42:33', NULL),
	(4, 'a', 'a', 'atest', '2222222', 'aaaa@aaa.com', 0, '2019-07-15 18:24:51', NULL, '2019-07-16 22:18:13', NULL),
	(5, 'b', 'basura', 'b', '4444444', 'bbbb@bb.com', 0, '2019-07-15 18:26:11', NULL, '2019-07-16 22:18:08', NULL),
	(6, 'testdd', 'testssss', 'testss', '222222211', '22212@2222.com', 0, '2019-07-16 22:04:19', NULL, '2019-07-19 17:23:28', NULL),
	(7, 'test', '', '', '', '', 0, '2019-07-24 17:43:24', NULL, '2019-07-24 17:43:24', NULL),
	(8, 'test', '', '', '', '', 0, '2019-07-24 17:44:52', NULL, '2019-07-24 17:44:52', NULL),
	(9, 'test', 'test', 'test', 'dd', 'dd', 0, '2019-07-26 18:09:51', NULL, '2019-07-26 18:09:51', NULL),
	(10, 'test33', 'test', 'test', 'ddqq33', 'dd', 0, '2019-07-26 18:10:03', NULL, '2019-07-26 18:10:03', NULL),
	(11, 'test335', 'test', 'test', 'ddqq33', 'dd', 0, '2019-07-26 18:10:09', NULL, '2019-07-26 18:10:09', NULL),
	(12, 'test', 'test', 'test', '1111', 'test', 0, '2019-07-28 17:18:56', NULL, '2019-07-28 17:18:56', NULL),
	(13, 'test2', 'test2', 'test2', '222', 'test2', 0, '2019-07-28 17:23:51', NULL, '2019-07-28 17:23:51', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.estados: ~0 rows (aproximadamente)
DELETE FROM `estados`;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` (`IdEstado`, `Nombre`, `Descripcion`, `IdEstadoAnterior`, `IdEstadoSiguiente`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Enviados', 'eviado', 1, 2, '2019-07-14 20:35:24', 1, '2019-07-24 17:45:50', NULL),
	(2, 'test', 'test', 1, 2, '2019-07-24 17:45:35', NULL, '2019-07-24 17:45:35', NULL);
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.lista_existente
CREATE TABLE IF NOT EXISTS `lista_existente` (
  `IdListaExistene` int(11) NOT NULL AUTO_INCREMENT,
  `IdSucursal` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.lista_existente: ~2 rows (aproximadamente)
DELETE FROM `lista_existente`;
/*!40000 ALTER TABLE `lista_existente` DISABLE KEYS */;
INSERT INTO `lista_existente` (`IdListaExistene`, `IdSucursal`, `IdEstado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 1, 1, '2019-08-15 15:15:07', 1, '0000-00-00 00:00:00', 0),
	(2, 1, 1, '2019-08-15 15:41:53', 18, '0000-00-00 00:00:00', 0);
/*!40000 ALTER TABLE `lista_existente` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.lista_existente_detalle
CREATE TABLE IF NOT EXISTS `lista_existente_detalle` (
  `IdLista` int(11) NOT NULL AUTO_INCREMENT,
  `IdListaExistene` int(11) NOT NULL DEFAULT '0',
  `IdProducto` int(11) DEFAULT NULL,
  `IdPorcion` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdLista`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.lista_existente_detalle: ~6 rows (aproximadamente)
DELETE FROM `lista_existente_detalle`;
/*!40000 ALTER TABLE `lista_existente_detalle` DISABLE KEYS */;
INSERT INTO `lista_existente_detalle` (`IdLista`, `IdListaExistene`, `IdProducto`, `IdPorcion`, `Cantidad`) VALUES
	(1, 1, 32, 4, 13),
	(2, 1, 8, 11, 45),
	(3, 1, 12, 10, 12),
	(4, 1, 22, 7, 36),
	(5, 2, 32, 4, 12),
	(6, 2, 28, 13, 1);
/*!40000 ALTER TABLE `lista_existente_detalle` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.lista_producto_porcion
CREATE TABLE IF NOT EXISTS `lista_producto_porcion` (
  `IdListaPP` int(11) NOT NULL AUTO_INCREMENT,
  `IdProducto` int(11) NOT NULL,
  `IdPorcion` int(11) NOT NULL,
  `Estado` int(11) NOT NULL,
  `FechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdListaPP`),
  KEY `FK1_producto` (`IdProducto`),
  KEY `FK2_produccion` (`IdPorcion`),
  KEY `FK3_usuario` (`UsuarioCreador`),
  KEY `FK4_userff` (`UsuarioActualiza`),
  CONSTRAINT `FK1_producto` FOREIGN KEY (`IdProducto`) REFERENCES `productos` (`IdProducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_produccion` FOREIGN KEY (`IdPorcion`) REFERENCES `porciones` (`IdPorcion`) ON UPDATE CASCADE,
  CONSTRAINT `FK3_usuario` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK4_userff` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.lista_producto_porcion: ~37 rows (aproximadamente)
DELETE FROM `lista_producto_porcion`;
/*!40000 ALTER TABLE `lista_producto_porcion` DISABLE KEYS */;
INSERT INTO `lista_producto_porcion` (`IdListaPP`, `IdProducto`, `IdPorcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 26, 3, 0, '2019-08-05 11:05:16', 1, '2019-08-05 11:05:16', 1),
	(2, 24, 12, 0, '2019-08-05 10:46:14', 1, NULL, NULL),
	(3, 1, 1, 0, '2019-08-05 11:13:26', 1, '2019-08-05 11:13:26', NULL),
	(4, 1, 7, 0, '2019-08-05 11:13:38', 1, '2019-08-05 11:13:38', NULL),
	(5, 1, 4, 0, '2019-08-05 11:13:50', 1, '2019-08-05 11:13:50', NULL),
	(6, 1, 5, 0, '2019-08-05 11:14:00', 1, '2019-08-05 11:14:00', NULL),
	(7, 1, 6, 0, '2019-08-05 11:14:13', 1, '2019-08-05 11:14:13', NULL),
	(8, 2, 7, 0, '2019-08-05 11:14:28', 1, '2019-08-05 11:14:28', NULL),
	(9, 2, 4, 0, '2019-08-05 11:14:38', 1, '2019-08-05 11:14:38', NULL),
	(10, 3, 7, 0, '2019-08-05 11:14:55', 1, '2019-08-05 11:14:55', NULL),
	(11, 4, 8, 0, '2019-08-05 11:15:07', 1, '2019-08-05 11:15:07', NULL),
	(12, 5, 9, 0, '2019-08-05 11:15:17', 1, '2019-08-05 11:15:17', NULL),
	(13, 6, 7, 0, '2019-08-05 11:15:32', 1, '2019-08-05 11:15:32', NULL),
	(14, 7, 5, 0, '2019-08-05 11:15:45', 1, '2019-08-05 11:15:45', NULL),
	(15, 7, 10, 0, '2019-08-05 11:15:54', 1, '2019-08-05 11:15:54', NULL),
	(16, 8, 11, 0, '2019-08-05 11:16:08', 1, '2019-08-05 11:16:08', NULL),
	(17, 9, 13, 0, '2019-08-05 11:16:53', 1, '2019-08-05 11:16:53', 1),
	(18, 10, 13, 0, '2019-08-05 11:17:08', 1, '2019-08-05 11:17:08', NULL),
	(19, 11, 5, 0, '2019-08-05 11:17:22', 1, '2019-08-05 11:17:22', NULL),
	(20, 12, 5, 0, '2019-08-05 11:17:33', 1, '2019-08-05 11:17:33', NULL),
	(21, 12, 10, 0, '2019-08-05 11:17:44', 1, '2019-08-05 11:17:44', NULL),
	(22, 13, 2, 0, '2019-08-05 11:17:55', 1, '2019-08-05 11:17:55', NULL),
	(23, 13, 3, 0, '2019-08-05 11:18:06', 1, '2019-08-05 11:18:06', NULL),
	(24, 14, 7, 0, '2019-08-05 11:18:20', 1, '2019-08-05 11:18:20', NULL),
	(25, 14, 3, 0, '2019-08-05 11:18:29', 1, '2019-08-05 11:18:29', NULL),
	(26, 15, 3, 0, '2019-08-05 11:18:41', 1, '2019-08-05 11:18:41', NULL),
	(27, 16, 3, 0, '2019-08-05 11:18:55', 1, '2019-08-05 11:18:55', NULL),
	(28, 17, 4, 0, '2019-08-05 11:19:05', 1, '2019-08-05 11:19:05', NULL),
	(29, 17, 5, 0, '2019-08-05 11:19:14', 1, '2019-08-05 11:19:14', NULL),
	(30, 18, 13, 0, '2019-08-05 11:19:23', 1, '2019-08-05 11:19:23', NULL),
	(31, 19, 5, 0, '2019-08-05 11:19:33', 1, '2019-08-05 11:19:33', NULL),
	(32, 20, 13, 0, '2019-08-05 11:19:44', 1, '2019-08-05 11:19:44', NULL),
	(33, 21, 2, 0, '2019-08-05 11:19:56', 1, '2019-08-05 11:19:56', NULL),
	(34, 22, 7, 0, '2019-08-05 11:20:09', 1, '2019-08-05 11:20:09', NULL),
	(35, 23, 7, 0, '2019-08-05 11:20:21', 1, '2019-08-05 11:20:21', NULL),
	(36, 25, 2, 0, '2019-08-05 11:20:53', 1, '2019-08-05 11:20:53', NULL),
	(37, 27, 13, 0, '2019-08-05 11:21:01', 1, '2019-08-05 11:21:01', NULL),
	(38, 28, 13, 0, '2019-08-05 11:21:11', 1, '2019-08-05 11:21:11', NULL),
	(39, 29, 13, 0, '2019-08-05 11:21:20', 1, '2019-08-05 11:21:20', NULL),
	(40, 30, 7, 0, '2019-08-05 11:21:57', 1, '2019-08-05 11:21:57', NULL),
	(41, 30, 6, 0, '2019-08-09 18:25:23', 1, '2019-08-09 18:25:23', NULL),
	(42, 32, 4, 0, '2019-08-09 18:28:04', 1, '2019-08-09 18:28:04', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.permisos: ~13 rows (aproximadamente)
DELETE FROM `permisos`;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` (`IdPermiso`, `Nombre`, `Descripcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'VER_TABLA_PERMISOS', 'ver tabla permisos y todos sus datos', 0, '2019-07-28 18:12:48', 1, '2019-07-28 18:12:50', NULL),
	(2, 'VER_TABLA_TIPOUSUARIO', 'ver tabla tipo de usuario con sus datos', 0, '2019-07-28 18:16:03', 1, '2019-07-28 18:21:52', NULL),
	(3, 'VER_TABLA_EMPRESA', 'ver tabla empresa con y todos sus datos', 0, '2019-07-28 18:16:27', 1, '2019-07-28 18:21:54', NULL),
	(4, 'VER_TABLA_ESTADOS', 'ver tabla estado y todos sus datos', 0, '2019-07-28 18:16:46', 1, '2019-07-28 18:21:55', NULL),
	(5, 'VER_TABLA_PRODUCTOS', 'ver tabla productos con todos sus datos', 0, '2019-07-28 18:17:10', 1, '2019-07-28 18:21:56', NULL),
	(6, 'VER_TABLA_PROVEEDOR', 'ver tabla proveedor con todos sus datos', 0, '2019-07-28 18:17:31', 1, '2019-07-28 18:21:56', NULL),
	(7, 'VER_TABLA_SUCURSALES', 'ver tablas sucursales con todos sus datos', 0, '2019-07-28 18:18:13', 1, '2019-07-28 18:21:57', NULL),
	(8, 'VER_TABLA_TIPOPRODUCTO', 'ver tabla tipo de producto con todos sus datos', 0, '2019-07-28 18:18:37', 1, '2019-07-28 18:21:58', NULL),
	(9, 'VER_TABLA_UNIDADMEDIDA', 'ver tabla unidad de medida con todos sus datos', 0, '2019-07-28 18:19:00', 1, '2019-07-28 18:21:59', NULL),
	(10, 'VER_TABLA_PERMISOUSUARIO', 'ver tabla permisos usuarios', 0, '2019-07-28 18:21:33', 1, '2019-07-28 18:22:00', NULL),
	(11, 'hola', 'hola', 0, '2019-07-29 17:06:47', 1, '2019-07-29 17:06:47', NULL),
	(12, 'adios', 'adios', 0, '2019-07-29 17:07:13', 1, '2019-07-29 17:07:13', NULL),
	(13, 'VER_TABLA_USUARIOS', 'ver tabla usuarios con todos sus datos', 0, '2019-07-30 11:33:54', 1, '2019-07-30 11:33:54', NULL),
	(14, 'PERMISO_VER_COMPONENT_LISTA_EXISTENTE', 'ver lista de existente que es creada en cada sucursal', 0, '2019-08-15 15:27:44', 1, '2019-08-15 15:27:44', NULL);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.permisos_usuarios
CREATE TABLE IF NOT EXISTS `permisos_usuarios` (
  `IdPermisosusuario` int(11) NOT NULL AUTO_INCREMENT,
  `IdPermiso` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPermisosusuario`,`IdPermiso`,`IdUsuario`),
  KEY `UsuarioCreador` (`UsuarioCreador`),
  KEY `UsuarioActualiza` (`UsuarioActualiza`),
  KEY `FK3_idper2` (`IdPermiso`),
  KEY `FK4_user22` (`IdUsuario`),
  CONSTRAINT `FK3_idper2` FOREIGN KEY (`IdPermiso`) REFERENCES `permisos` (`IdPermiso`) ON UPDATE CASCADE,
  CONSTRAINT `FK4_user22` FOREIGN KEY (`Idusuario`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE,
  CONSTRAINT `permisos_usuarios_ibfk_1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `permisos_usuarios_ibfk_2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.permisos_usuarios: ~18 rows (aproximadamente)
DELETE FROM `permisos_usuarios`;
/*!40000 ALTER TABLE `permisos_usuarios` DISABLE KEYS */;
INSERT INTO `permisos_usuarios` (`IdPermisosusuario`, `IdPermiso`, `IdUsuario`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 1, 3, '2019-07-28 18:13:03', 1, '2019-07-28 18:13:06', NULL),
	(16, 1, 1, '2019-07-29 15:04:34', 1, '2019-07-29 15:04:34', NULL),
	(23, 2, 1, '2019-07-29 16:47:22', 1, '2019-07-29 16:47:22', NULL),
	(24, 10, 1, '2019-07-29 16:51:25', 1, '2019-07-29 16:51:25', NULL),
	(25, 2, 3, '2019-07-29 17:05:57', 1, '2019-07-29 17:05:57', NULL),
	(26, 11, 3, '2019-07-29 17:07:26', 1, '2019-07-29 17:07:26', NULL),
	(27, 11, 13, '2019-07-29 17:49:35', 1, '2019-07-29 18:13:19', NULL),
	(29, 11, 1, '2019-07-29 19:14:48', 1, '2019-07-29 19:14:48', NULL),
	(30, 12, 1, '2019-07-30 10:07:33', 1, '2019-07-30 10:07:33', NULL),
	(31, 13, 1, '2019-07-30 11:34:15', 1, '2019-07-30 11:34:15', NULL),
	(32, 13, 15, '2019-07-30 18:32:07', 1, '2019-07-30 18:32:07', NULL),
	(33, 8, 1, '2019-08-03 19:30:18', 1, '2019-08-03 19:30:18', NULL),
	(34, 5, 1, '2019-08-03 19:44:24', 1, '2019-08-03 19:44:24', NULL),
	(35, 9, 1, '2019-08-03 19:45:40', 1, '2019-08-03 19:45:40', NULL),
	(36, 7, 1, '2019-08-03 19:45:42', 1, '2019-08-03 19:45:42', NULL),
	(37, 6, 1, '2019-08-03 19:45:45', 1, '2019-08-03 19:45:45', NULL),
	(38, 4, 1, '2019-08-03 19:45:47', 1, '2019-08-03 19:45:47', NULL),
	(39, 3, 1, '2019-08-03 19:45:49', 1, '2019-08-03 19:45:49', NULL),
	(40, 9, 16, '2019-08-09 18:19:19', 1, '2019-08-09 18:19:19', NULL),
	(41, 14, 18, '2019-08-15 15:28:11', 1, '2019-08-15 15:28:11', NULL),
	(42, 14, 1, '2019-08-15 15:28:22', 1, '2019-08-15 15:28:22', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.porciones: ~11 rows (aproximadamente)
DELETE FROM `porciones`;
/*!40000 ALTER TABLE `porciones` DISABLE KEYS */;
INSERT INTO `porciones` (`IdPorcion`, `Cantidad`, `IdUnidadMedida`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 5.00, 1, 0, '2019-07-12 11:36:47', 1, '2019-07-12 11:36:49', NULL),
	(2, 4.00, 1, 0, '2019-07-12 11:37:27', 1, '2019-07-12 11:37:29', NULL),
	(3, 2.00, 1, 0, '2019-07-12 11:37:38', 1, '2019-07-12 11:37:39', NULL),
	(4, 1.50, 1, 0, '2019-07-12 11:37:51', 1, '2019-07-12 11:37:53', NULL),
	(5, 1.00, 1, 0, '2019-07-12 11:38:02', 1, '2019-07-12 11:38:04', NULL),
	(6, 0.50, 1, 0, '2019-07-12 11:38:11', 1, '2019-07-12 11:38:13', NULL),
	(7, 3.00, 1, 0, '2019-08-04 12:53:28', 1, '2019-08-04 13:02:23', 1),
	(8, 10.00, 9, 0, '2019-08-04 13:13:57', 1, '2019-08-04 13:13:57', NULL),
	(9, 500.00, 4, 0, '2019-08-04 13:14:11', 1, '2019-08-04 13:14:11', NULL),
	(10, 0.70, 1, 0, '2019-08-04 13:14:30', 1, '2019-08-04 13:14:30', NULL),
	(11, 12.00, 1, 0, '2019-08-04 13:14:47', 1, '2019-08-04 13:14:47', NULL),
	(12, 7.00, 1, 0, '2019-08-04 13:16:24', 1, '2019-08-04 13:16:24', NULL),
	(13, 1.00, 2, 0, '2019-08-05 11:16:40', 1, '2019-08-05 11:16:40', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.productos: ~29 rows (aproximadamente)
DELETE FROM `productos`;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`IdProducto`, `Nombre`, `Descripcion`, `IdTipoProducto`, `IdUnidadMedida`, `IdProveedor`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Queso Mozzarella', 'queso pizzas', 1, 3, 1, 0, '2019-07-12 11:34:40', 1, '2019-08-03 21:36:48', 1),
	(2, 'Queso Cheddar', 'queso pizzas', 1, 3, 1, 0, '2019-07-12 11:35:32', 1, '2019-08-03 21:38:22', 1),
	(3, 'Mix de queso', 'mix de queso cheddar y mozzarella', 1, 3, 1, NULL, '2019-08-03 21:43:29', 1, '2019-08-03 21:43:29', NULL),
	(4, 'Bolsas de crema', 'bolsas de crema para restaurante', 1, 9, 1, NULL, '2019-08-03 21:45:11', 1, '2019-08-03 21:45:11', NULL),
	(5, 'Tarros de Requeson', 'requeson ', 1, 4, 1, NULL, '2019-08-03 21:47:20', 1, '2019-08-03 21:47:20', NULL),
	(6, 'Pollo', 'pollo', 4, 5, 1, NULL, '2019-08-03 21:47:59', 1, '2019-08-03 21:47:59', NULL),
	(7, 'Carne', 'mix de carne', 2, 5, 1, NULL, '2019-08-03 21:48:57', 1, '2019-08-03 21:48:57', NULL),
	(8, 'Churrasco', 'corte de carne', 2, 5, 1, NULL, '2019-08-03 21:49:19', 1, '2019-08-03 21:49:19', NULL),
	(9, 'Proscuitto', 'tipo de carne', 2, 5, 2, NULL, '2019-08-03 21:50:34', 1, '2019-08-03 21:50:34', NULL),
	(10, 'Atun', 'producto marino', 5, 2, 3, NULL, '2019-08-03 21:51:04', 1, '2019-08-03 21:51:04', NULL),
	(11, 'Tocino', 'corte de carne', 2, 5, 3, NULL, '2019-08-03 21:55:45', 1, '2019-08-03 21:55:45', NULL),
	(12, 'Chorizo', 'chorizo argentino y salvadoreÃ±o', 2, 5, 2, NULL, '2019-08-03 21:56:14', 1, '2019-08-03 21:56:14', NULL),
	(13, 'Aros de Calamar', 'calamar', 5, 5, 3, NULL, '2019-08-03 21:56:39', 1, '2019-08-03 21:56:39', NULL),
	(14, 'Camaron', 'camarones de mar', 5, 5, 3, NULL, '2019-08-03 21:57:03', 1, '2019-08-03 21:57:03', NULL),
	(15, 'Pulpo', 'El pulpo', 5, 2, 3, NULL, '2019-08-04 10:46:30', 1, '2019-08-04 10:46:30', NULL),
	(16, 'Tentaculos de calamar', 'marisco fino', 5, 5, 2, NULL, '2019-08-04 10:47:00', 1, '2019-08-04 10:47:00', NULL),
	(17, 'Surimi', 'cangrejo', 5, 5, 3, NULL, '2019-08-04 10:47:47', 1, '2019-08-04 10:47:47', NULL),
	(18, 'Tintas de Calamar', 'lo negro del calamar', 5, 2, 2, NULL, '2019-08-04 10:48:10', 1, '2019-08-04 10:48:10', NULL),
	(19, 'Mejillones', 'del mar', 5, 5, 2, NULL, '2019-08-04 10:49:08', 1, '2019-08-04 10:49:08', NULL),
	(20, 'Bandeja de Salmon', 'el salmon', 5, 2, 3, NULL, '2019-08-04 10:49:33', 1, '2019-08-04 10:49:33', NULL),
	(21, 'Fresa', 'la fresa', 3, 5, 3, NULL, '2019-08-04 10:50:12', 1, '2019-08-04 10:50:12', NULL),
	(22, 'Melon', 'el melon', 3, 2, 3, NULL, '2019-08-04 10:51:52', 1, '2019-08-04 10:51:52', NULL),
	(23, 'Sandia', 'la sandia', 6, 2, 3, NULL, '2019-08-04 10:52:09', 1, '2019-08-04 10:52:09', NULL),
	(24, 'Melocoton', 'el melecoton', 3, 2, 3, NULL, '2019-08-04 10:52:41', 1, '2019-08-04 10:52:41', NULL),
	(25, 'Maracuya', 'la fruta maracuya', 6, 5, 3, NULL, '2019-08-04 10:53:27', 1, '2019-08-04 10:53:27', NULL),
	(26, 'Mora', 'para aquellos jugos', 6, 5, 3, NULL, '2019-08-04 10:53:51', 1, '2019-08-04 10:53:51', NULL),
	(27, 'Caja de pizza', 'envio de pedidos', 7, 2, 3, NULL, '2019-08-04 10:54:11', 1, '2019-08-04 10:54:11', NULL),
	(28, 'Dulces', 'los que se dan al momento de llevar la cuenta', 7, 2, 3, NULL, '2019-08-04 10:54:36', 1, '2019-08-04 10:54:36', NULL),
	(29, 'Comandas', 'para anotar el pedido', 7, 2, 3, NULL, '2019-08-04 10:54:54', 1, '2019-08-04 10:54:54', NULL),
	(30, 'Papaya', 'fruta fresca', 6, 2, 3, NULL, '2019-08-05 11:21:44', 1, '2019-08-05 11:21:44', NULL),
	(32, 'producto prueba', 'prueba', 6, 1, 3, NULL, '2019-08-09 18:26:50', 1, '2019-08-09 18:26:50', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.proveedores: ~0 rows (aproximadamente)
DELETE FROM `proveedores`;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` (`IdProveedor`, `Nombre`, `Direccion`, `Telefono`, `Razo_Social`, `Tipo`, `Nombre_Contacto`, `Email`, `DUI`, `NIT`, `NRC`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Lactolac', 'plan de la laguna', '22589634', 'Lactolac S.A de C.V', '0', 'Edwin Ramirez', 'eramirez@lactolac.com', '789556335', '4859636', '896357412', 0, '2019-05-31 16:26:27', 1, '2019-05-31 16:26:31', NULL),
	(2, 'Salud', 'plaz de la laguna', '22589634', 'Salud S.A de C.V', '0', 'Marvin Rivas', 'marvinrivas@salud.com', '785964336', '2856596', '284562636', 0, '2019-07-12 11:34:05', 1, '2019-07-12 11:34:09', NULL),
	(3, 'testsssss', 'test', '11111', 'test', '0', 'test', 'test', '111', '111', '11', 0, '2019-07-24 16:24:16', NULL, '2019-07-24 16:25:24', NULL);
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
	(1, 0, 'LP Volcan', 'calle al boqueron', '22436017', 1, 0, '2019-05-31 15:52:56', 1, '2019-08-15 16:02:38', 1),
	(2, 0, 'Lp Castanos', 'plaza castanos', '22436017', 3, 0, '2019-07-10 20:33:07', NULL, '2019-07-10 20:33:09', NULL),
	(3, 0, 'Centro de Produccion', 'Santa Elena', '22222222', NULL, 0, '2019-07-22 17:33:20', NULL, '2019-08-15 16:03:25', 1),
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
  PRIMARY KEY (`IdTipoUsuario`),
  KEY `FK1_uss1` (`UsuarioCreador`),
  KEY `FK2_uss2` (`UsuarioActualiza`),
  CONSTRAINT `FK1_uss1` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK2_uss2` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.tipos_usuario: ~3 rows (aproximadamente)
DELETE FROM `tipos_usuario`;
/*!40000 ALTER TABLE `tipos_usuario` DISABLE KEYS */;
INSERT INTO `tipos_usuario` (`IdTipoUsuario`, `Nombre`, `Descripcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Administrador', 'yes', 0, '2019-07-25 11:05:42', 1, '2019-08-15 16:05:06', 1),
	(2, 'Gerente', 'gerente de sucursal', 0, '2019-08-15 16:05:24', 1, '2019-08-15 16:50:27', NULL),
	(3, 'Supervisor', 'Supervisor de sucursal', 0, '2019-08-15 16:05:36', 1, '2019-08-15 16:50:29', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.tipo_producto: ~6 rows (aproximadamente)
DELETE FROM `tipo_producto`;
/*!40000 ALTER TABLE `tipo_producto` DISABLE KEYS */;
INSERT INTO `tipo_producto` (`IdTipoProducto`, `Nombre`, `Descripcion`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'Lacteos', 'comida lacteos', 0, '2019-05-31 16:39:06', 1, '2019-07-24 15:28:46', NULL),
	(2, 'Carnes Rojas', 'tipo de carnes (res, cerdo, etc)', 0, '2019-07-12 11:32:37', 1, '2019-08-03 19:37:16', 1),
	(3, 'Frutas', 'variedad de frutas', 0, '2019-07-24 15:25:21', NULL, '2019-07-24 15:25:21', NULL),
	(4, 'Carnes Blancas', 'tpos de carnes blancas (pollo, pescado, etc)', 0, '2019-08-03 19:37:39', 1, '2019-08-03 19:37:39', NULL),
	(5, 'Mariscos', 'Diferentes tipos de mariscos (camaron, pulpo, etc)', 0, '2019-08-03 19:38:57', 1, '2019-08-03 19:38:57', NULL),
	(6, 'Frutas', 'Diferentes tipos de frutas a utilizar', 0, '2019-08-03 19:39:35', 1, '2019-08-03 19:39:35', NULL),
	(7, 'Material de trabajo', 'material utilizado para el trabajo en las sucursales', 0, '2019-08-03 19:40:07', 1, '2019-08-03 19:40:07', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.unidad_medida: ~9 rows (aproximadamente)
DELETE FROM `unidad_medida`;
/*!40000 ALTER TABLE `unidad_medida` DISABLE KEYS */;
INSERT INTO `unidad_medida` (`IdUnidadMedida`, `Siglas`, `Nombre`, `Estado`, `FechaCreacion`, `UsuarioCreador`, `FechaActualizacion`, `UsuarioActualiza`) VALUES
	(1, 'ONZ', 'Onzas', 0, '2019-05-31 16:15:58', 1, '2019-05-31 16:16:03', NULL),
	(2, 'Unida', 'Unidad', 0, '2019-07-12 11:33:07', 1, '2019-08-03 19:48:15', 1),
	(3, 'KG', 'Kilogramo', 0, '2019-07-12 11:35:03', 1, '2019-08-03 19:48:01', 1),
	(4, 'GR', 'GRAMOS', 0, '0000-00-00 00:00:00', NULL, '2019-08-03 19:48:32', 1),
	(5, 'LB', 'libras', 0, '0000-00-00 00:00:00', NULL, '2019-07-19 18:31:32', NULL),
	(6, 'asdd', 'as', 1, '2019-07-19 18:33:04', NULL, '2019-07-19 18:37:47', NULL),
	(7, 'qq', 'qqrr', 0, '0000-00-00 00:00:00', NULL, '2019-07-19 18:33:56', NULL),
	(8, 'qqwep', 'qwer', 0, '2019-07-19 18:42:03', NULL, '2019-07-19 18:44:10', NULL),
	(9, 'BT', 'Botellas', 0, '2019-08-03 21:44:37', 1, '2019-08-03 21:44:37', NULL);
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
  `password_request` int(11) DEFAULT NULL,
  `activacion` int(11) DEFAULT '0',
  PRIMARY KEY (`IdUsuario`),
  KEY `IdTipoUsuario` (`IdTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.usuarios: ~7 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`IdUsuario`, `Nombre`, `Email`, `Passwd`, `PasswdTmp`, `Alias`, `IdTipoUsuario`, `Estado`, `FechaCreacion`, `FechaActualizacion`, `UsuarioActualiza`, `password_request`, `activacion`) VALUES
	(1, 'Irvin', 'irvnsanchez@gmail.com', '$2y$10$GMIK3IomndXBB7DDzyyVMupVW53Mlyq5VPmrR6za2JQ.nAeq4e9ua', '', 'irvin', 1, 0, '2019-05-24 16:27:50', '2019-08-09 19:07:08', 1, 0, 0),
	(3, 'Alejandro', 'ale@ale.com', '$2y$10$zl/3cr3ekslKNB1yyUrD4.BWdQyeizWPVezv2Tt9sUoyB.Z9CXlTW', NULL, 'toyo', 1, 0, '2019-06-06 11:05:54', '2019-07-28 10:37:20', NULL, NULL, 0),
	(5, 'Raul', 'raul@ale.com', '$2y$10$Dox.nha0m7PjXRbb9.1ws.ANa4QhUR5erBmKjSOYCoeIN1aKXDJ9.', NULL, 'raus', 2, 0, '2019-06-06 16:35:50', '2019-07-30 18:31:14', NULL, NULL, 0),
	(12, 'irvin', 'i@i.com', '$2y$10$FGgErlcWjpbnKiU0AymnFuoljuq3wc180zv1hC7D.Fdgi13qPfdSG', NULL, 'marmota', 5, 0, '2019-07-05 18:10:33', '2019-07-30 18:31:17', NULL, NULL, 0),
	(13, 'Raul', 'raul.sosa@outlook.com', '$2y$10$zl/3cr3ekslKNB1yyUrD4.BWdQyeizWPVezv2Tt9sUoyB.Z9CXlTW', NULL, 'raul', 3, 0, '2019-07-06 16:04:48', '2019-07-30 17:39:37', NULL, NULL, 0),
	(15, 'Test 3', 'test@test.com', '$2y$10$N.xQ3XYv4fbaY8RL7VTfquKQZQ1TrMrdR4TUbENG/1boku2FoGy7K', NULL, 'test', 1, 0, '2019-07-30 18:30:48', '2019-07-30 18:51:16', 1, NULL, 0),
	(16, 'Jorge', 'jorgepinedaue', '$2y$10$iKm71KnCZdo4Z0Lic3yvJ.DG/v2dhtD1yQNe9Dvkpi6j.UxpFY91q', '24224e98e4cbd9be6fe78c8dc019babd', 'profe', 1, 0, '2019-08-09 18:15:18', '2019-08-16 18:18:08', NULL, 1, 0),
	(18, 'marmota', 'isanchez@applaudostudios.com', '$2y$10$DpfgP684DpOj/zt//25iH.if1qOg5Qvk5zHbC/yw0tedR/x21lPWy', NULL, 'marmota1', 1, 0, '2019-08-10 22:42:28', '2019-08-13 18:03:22', NULL, NULL, 0),
	(19, 'Profe', 'jorgepinedauees@gmail.com', '$2y$10$N8wEginzICXtDF7e2m.YC.Ty/q4jzmHb/kjqk2kjFA3ovsTnwvWZO', NULL, 'el profe', 1, 0, '2019-08-16 18:19:00', '2019-08-16 18:21:41', NULL, NULL, 0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla tesis.usuario_sucursal
CREATE TABLE IF NOT EXISTS `usuario_sucursal` (
  `IdUserSuc` int(11) NOT NULL AUTO_INCREMENT,
  `IdSucursal` int(11) DEFAULT NULL,
  `IdUsuario` int(11) DEFAULT NULL,
  `FechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UsuarioCreador` int(11) DEFAULT NULL,
  `FechaActualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UsuarioActualiza` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUserSuc`),
  KEY `FK1_sucursal11` (`IdSucursal`),
  KEY `FK2_usuario23` (`IdUsuario`),
  KEY `FK3_usuario24` (`UsuarioCreador`),
  KEY `FK4_usuario25` (`UsuarioActualiza`),
  CONSTRAINT `FK1_sucursal11` FOREIGN KEY (`IdSucursal`) REFERENCES `sucursales` (`IdSucursal`) ON UPDATE CASCADE,
  CONSTRAINT `FK2_usuario23` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK3_usuario24` FOREIGN KEY (`UsuarioCreador`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK4_usuario25` FOREIGN KEY (`UsuarioActualiza`) REFERENCES `usuarios` (`IdUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tesis.usuario_sucursal: ~0 rows (aproximadamente)
DELETE FROM `usuario_sucursal`;
/*!40000 ALTER TABLE `usuario_sucursal` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_sucursal` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
