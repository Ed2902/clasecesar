-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-08-2024 a las 15:32:28
-- Versión del servidor: 10.6.18-MariaDB-cll-lve
-- Versión de PHP: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fastways_appfastway`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `representantelegal` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `fecha_registro` date NOT NULL,
  `camara_comercio` varchar(50) NOT NULL,
  `rut` varchar(50) NOT NULL,
  `cc_representante` varchar(50) NOT NULL,
  `certificacion_comercial` varchar(50) NOT NULL,
  `certificacion_bancaria` varchar(50) NOT NULL,
  `circular_170` varchar(50) NOT NULL,
  `acuerdos_seguridad` varchar(50) NOT NULL,
  `estados_financieros` varchar(50) NOT NULL,
  `autorizacion_tratamiento_datos` varchar(50) NOT NULL,
  `visita` varchar(50) NOT NULL,
  `antecedentes_judiciales` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `representantelegal`, `correo`, `telefono`, `direccion`, `fecha_registro`, `camara_comercio`, `rut`, `cc_representante`, `certificacion_comercial`, `certificacion_bancaria`, `circular_170`, `acuerdos_seguridad`, `estados_financieros`, `autorizacion_tratamiento_datos`, `visita`, `antecedentes_judiciales`) VALUES
('262.896.146', 'GREYSTONEALLOYS', 'GREYSTONEALLOYS', 'israel@greystonealloys.com', '+1 (713)-538-2731 FAX - +1(281)-516-2195', 'LLC 10545 FISHER ROAD  HOUSTON, TX. 77041', '2024-07-23', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/', './guardar_cliente/GREYSTONEALLOYS/'),
('270.469.348-1', 'TUNGCO POWDER PROCUREMENT', 'TUNGCO', 'TUNGCO.COM', '2708250000 - cell  +1.740.818.5525', '4035 Anton Rd, Madisonville, KY 42431', '2024-07-23', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/', './guardar_cliente/TUNGCO POWDER PROCUREMENT/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consolidado_inventario`
--

CREATE TABLE `consolidado_inventario` (
  `id_productoFK` varchar(50) NOT NULL,
  `existencia` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consolidado_inventario`
--

INSERT INTO `consolidado_inventario` (`id_productoFK`, `existencia`) VALUES
('Co-1', 5),
('Co-2', 71),
('NI-1', 6374),
('NI-2', 957),
('Ti-1', 22.5),
('W-1', 240),
('W-2', 81.4),
('W-3', 0),
('W-4', 0),
('W-5', 43000),
('W-6', 57.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `id` int(11) NOT NULL,
  `ingreso_id` int(11) NOT NULL,
  `id_inventarioFK` int(11) NOT NULL,
  `cantidad` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`id`, `ingreso_id`, `id_inventarioFK`, `cantidad`) VALUES
(1, 1, 1, 1.5),
(2, 2, 2, 34),
(3, 3, 3, 287.5),
(4, 4, 4, 56),
(5, 5, 5, 13),
(6, 6, 6, 56),
(7, 7, 7, 131.5),
(8, 8, 8, 127),
(9, 9, 9, 3.4),
(10, 10, 10, 30),
(11, 11, 11, 79.5),
(12, 12, 12, 161.5),
(13, 13, 13, 196.5),
(14, 14, 14, 625.5),
(15, 15, 15, 327.5),
(16, 16, 16, 684),
(17, 17, 17, 1780),
(18, 18, 18, 279),
(19, 19, 19, 295),
(20, 20, 20, 186),
(21, 21, 21, 124),
(22, 22, 22, 473.5),
(23, 23, 23, 432),
(24, 24, 24, 512),
(25, 25, 25, 5),
(26, 26, 26, 14),
(27, 27, 27, 473.5),
(28, 28, 28, 22.5),
(29, 29, 29, 5),
(30, 30, 30, 88.5),
(31, 31, 31, 206),
(32, 32, 32, 66),
(33, 33, 33, 784),
(34, 34, 34, 708),
(35, 35, 35, 105),
(36, 36, 36, 430),
(37, 37, 37, 302),
(38, 38, 38, 7.5),
(39, 39, 39, 225.5),
(40, 40, 40, 83),
(41, 41, 41, 67.5),
(42, 42, 42, 12),
(43, 43, 43, 3.5),
(44, 44, 44, 42500),
(45, 45, 45, 13),
(46, 46, 46, 423),
(47, 47, 47, 371.5),
(48, 48, 48, 147),
(49, 49, 49, 424),
(50, 50, 50, 616.5),
(51, 51, 51, 77),
(52, 52, 52, 179),
(53, 53, 53, 58),
(54, 54, 54, 459.5),
(55, 55, 55, 64),
(56, 56, 56, 64.5),
(57, 57, 57, 8),
(58, 58, 58, 71),
(61, 60, 61, 43000),
(62, 61, 62, 2632.5),
(63, 62, 63, 57.5),
(64, 63, 64, 115.5),
(65, 64, 65, 55);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_salida`
--

CREATE TABLE `detalle_salida` (
  `id_detalle` int(11) NOT NULL,
  `id_salida` int(11) NOT NULL,
  `id_productoFK` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_salida`
--

INSERT INTO `detalle_salida` (`id_detalle`, `id_salida`, `id_productoFK`) VALUES
(5, 5, ''),
(6, 6, ''),
(7, 7, ''),
(8, 8, ''),
(9, 9, ''),
(10, 10, ''),
(13, 13, ''),
(14, 14, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `id` int(11) NOT NULL,
  `suma_total_kilos` double NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`id`, `suma_total_kilos`, `fecha_hora`) VALUES
(1, 1.5, '2024-06-26 15:51:49'),
(2, 34, '2024-06-26 15:52:35'),
(3, 287.5, '2024-06-26 15:55:03'),
(4, 56, '2024-06-26 15:56:09'),
(5, 13, '2024-06-28 12:27:31'),
(6, 56, '2024-06-28 12:28:20'),
(7, 131.5, '2024-06-28 12:29:02'),
(8, 127, '2024-06-28 12:29:37'),
(9, 3.4, '2024-06-28 12:34:22'),
(10, 30, '2024-06-28 12:34:47'),
(11, 79.5, '2024-06-28 12:35:28'),
(12, 161.5, '2024-06-28 12:35:55'),
(13, 196.5, '2024-06-28 12:36:41'),
(14, 625.5, '2024-06-28 12:43:01'),
(15, 327.5, '2024-06-28 12:43:37'),
(16, 684, '2024-06-28 12:45:04'),
(17, 1780, '2024-06-28 12:45:27'),
(18, 279, '2024-06-28 12:46:05'),
(19, 295, '2024-06-28 12:46:26'),
(20, 186, '2024-06-28 12:46:51'),
(21, 124, '2024-06-28 12:47:25'),
(22, 473.5, '2024-06-28 12:47:54'),
(23, 432, '2024-06-28 12:52:50'),
(24, 512, '2024-06-28 12:53:14'),
(25, 5, '2024-06-28 12:54:05'),
(26, 14, '2024-06-28 12:54:29'),
(27, 473.5, '2024-06-28 12:54:51'),
(28, 22.5, '2024-06-28 12:58:36'),
(29, 5, '2024-06-28 14:42:58'),
(30, 88.5, '2024-06-28 14:43:24'),
(31, 206, '2024-06-28 14:53:51'),
(32, 66, '2024-06-28 14:54:29'),
(33, 784, '2024-07-02 14:37:17'),
(34, 708, '2024-07-02 14:38:34'),
(35, 105, '2024-07-02 14:39:59'),
(36, 430, '2024-07-08 08:27:36'),
(37, 302, '2024-07-08 08:34:20'),
(38, 7.5, '2024-07-09 08:09:52'),
(39, 225.5, '2024-07-09 08:17:02'),
(40, 83, '2024-07-09 08:18:33'),
(41, 67.5, '2024-07-09 08:20:26'),
(42, 12, '2024-07-12 15:38:34'),
(43, 3.5, '2024-07-12 15:40:30'),
(44, 42500, '2024-07-17 14:29:15'),
(45, 13, '2024-07-17 14:32:35'),
(46, 423, '2024-07-17 14:33:51'),
(47, 371.5, '2024-07-23 08:41:38'),
(48, 147, '2024-07-23 08:43:27'),
(49, 424, '2024-07-30 08:20:05'),
(50, 616.5, '2024-07-30 08:23:06'),
(51, 77, '2024-07-30 08:24:07'),
(52, 179, '2024-08-01 08:10:40'),
(53, 58, '2024-08-01 08:11:33'),
(54, 459.5, '2024-08-02 16:43:41'),
(55, 64, '2024-08-02 16:45:25'),
(56, 64.5, '2024-08-02 16:48:59'),
(57, 8, '2024-08-13 08:14:43'),
(58, 71, '2024-08-13 08:16:58'),
(60, 43000, '2024-08-20 09:41:30'),
(61, 2632.5, '2024-08-21 10:20:18'),
(62, 57.5, '2024-08-21 10:25:30'),
(63, 115.5, '2024-08-21 10:28:08'),
(64, 55, '2024-08-22 07:53:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `id_productoFK` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `peso` double NOT NULL,
  `id_proveedor` varchar(50) NOT NULL,
  `valorPorKilo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `id_productoFK`, `id_usuario`, `peso`, `id_proveedor`, `valorPorKilo`) VALUES
(1, 'W-1', 1022414392, 1.5, '901114904', 43000),
(2, 'W-1', 1022414392, 34, '10700087357', 44000),
(3, 'W-1', 1022414392, 287.5, '901114904', 45000),
(4, 'W-1', 1022414392, 56, '901114904', 43000),
(5, 'W-2', 1022414392, 13, '10305257674', 39000),
(6, 'W-2', 1022414392, 56, '901114904', 43000),
(7, 'W-1', 1022414392, 131.5, '10700087357', 44000),
(8, 'W-1', 1022414392, 127, '901060185', 42500),
(9, 'W-2', 1022414392, 3.4, '8320022430', 38000),
(10, 'W-2', 1022414392, 30, '8000427253', 39000),
(11, 'W-1', 1022414392, 79.5, '10700087357', 44000),
(12, 'W-1', 1022414392, 161.5, '901060185', 42500),
(13, 'W-1', 1022414392, 196.5, '10700087357', 44000),
(14, 'NI-1', 1022414392, 625.5, '10700087357', 33000),
(15, 'NI-1', 1022414392, 327.5, '10700087357', 33000),
(16, 'NI-1', 1022414392, 684, '901060185', 33000),
(17, 'NI-1', 1022414392, 1780, '80229069', 33500),
(18, 'NI-1', 1022414392, 279, '10700087357', 33500),
(19, 'NI-1', 1022414392, 295, '901060185', 33000),
(20, 'NI-1', 1022414392, 186, '10700087357', 34000),
(21, 'NI-1', 1022414392, 124, '10700087357', 33000),
(22, 'NI-1', 1022414392, 473.5, '901060185', 33000),
(23, 'NI-1', 1022414392, 432, '79426908', 34000),
(24, 'NI-1', 1022414392, 512, '79426908', 34000),
(25, 'Co-1', 1022414392, 5, '79426908', 21000),
(26, 'Co-1', 1022414392, 14, '79426908', 21000),
(27, 'Co-1', 1022414392, 473.5, '901060185', 21000),
(28, 'Ti-1', 1022414392, 22.5, '80229069', 5200),
(29, 'W-2', 1022414392, 5, '80229069', 43000),
(30, 'W-1', 1022414392, 88.5, '80229069', 43000),
(31, 'W-1', 1022414392, 206, '901060185', 42500),
(32, 'W-1', 1022414392, 66, '79426908', 41000),
(33, 'NI-2', 1022414392, 784, '79426908', 33000),
(34, 'NI-1', 1022414392, 708, '80229069', 33000),
(35, 'NI-1', 1022414392, 105, '79426908', 34000),
(36, 'W-1', 80000697, 430, '80229069', 43000),
(37, 'NI-1', 80000697, 302, '80229069', 33000),
(38, 'Co-1', 80000697, 7.5, '10700087357', 21000),
(39, 'NI-1', 80000697, 225.5, '10700087357', 34000),
(40, 'NI-2', 80000697, 83, '10700087357', 34000),
(41, 'W-1', 80000697, 67.5, '10700087357', 44000),
(42, 'W-2', 80000697, 12, '8600691821', 38000),
(43, 'W-2', 80000697, 3.5, '9010595731', 38000),
(44, 'W-1', 80000697, 214, '901060185', 42500),
(45, 'NI-2', 80000697, 13, '901060185', 33000),
(46, 'NI-1', 80000697, 423, '901060185', 33000),
(47, 'NI-1', 80000697, 371.5, '79426908', 35000),
(48, 'W-1', 80000697, 147, '79426908', 45000),
(49, 'W-1', 80000697, 424, '80229069', 43000),
(50, 'NI-1', 80000697, 616.5, '80229069', 33000),
(51, 'NI-2', 80000697, 77, '80229069', 33000),
(52, 'W-1', 80000697, 179, '901060185', 42500),
(53, 'W-1', 80000697, 58, '8516644', 41000),
(54, 'W-1', 80000697, 395, '1016002068', 42000),
(55, 'W-3', 80000697, 64, '1016002068', 37000),
(56, 'W-4', 80000697, 64.5, '1016002068', 42000),
(57, 'W-1', 80000697, 8, '901114904', 32),
(58, 'Co-2', 80000697, 71, '901114904', 21000),
(61, 'W-1', 80000697, 520, '80229069', 43000),
(62, 'NI-1', 80000697, 2632.5, '80229069', 33000),
(63, 'W-1', 80000697, 57.5, '10700087357', 44000),
(64, 'NI-1', 80000697, 115.5, '10700087357', 33000),
(65, 'W-2', 80000697, 55, '9016721783', 38000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_old`
--

CREATE TABLE `inventario_old` (
  `id_inventario_old` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL,
  `id_productoFK` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `peso` double NOT NULL,
  `id_proveedor` varchar(50) NOT NULL,
  `valorPorKilo` double NOT NULL,
  `id_salida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `referencia` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuarioFK` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `referencia`, `tipo`, `fecha`, `id_usuarioFK`) VALUES
('Co-1', 'Cobalto HS- 6  //  HS-6 Fabrication Vac', 'HS-6 (Co >62%  Cr < 30%  W >4%)', 'COBALTO', '2024-06-19 16:47:50', '5'),
('Co-2', 'cobalro HS-12 //  HS-12 Fabrication Air Melt', 'HS-12 (Co >58%  Cr < 30%  W >8%)', 'COBALTO', '2024-06-19 16:48:39', '5'),
('NI-1', 'varilla de niquel 718  //  Inco 718 Solids Vac', 'inco 718 - (NI >52 %  Cr <18%  Fe <19%)', 'NIQUEL', '2024-06-19 16:43:28', '5'),
('NI-2', 'varilla de niquel Monel alloy 400  // Monel K (500', 'Monel K (NI >70 %  Cu< 28%  Fe < 2%)', 'NIQUEL', '2024-06-19 16:45:22', '5'),
('NI-3', 'Nitronic  //  NITRONIC 50 Solids Air Melt', ' NITRONIC (NI <13%  Cr< 25%  Fe > 58%)', 'NIQUEL', '2024-06-19 16:46:45', '5'),
('Ti-1', 'Titiano  // TI-90-6AL-4V Solids Ferro', 'TI-90-6AL-4V Solids Ferro (Ti > 90 %)', 'TITANIO ', '2024-06-19 16:54:31', '5'),
('W-1', 'Bujes de Carburo de tungsteno  -// WC rings - Wear', 'Carburo de tugsteno (W > 90 %)', 'TUNGSTENO ', '2024-06-19 16:21:39', '5'),
('W-2', 'insertos - piezas de corte TORNOS // WC trangles  ', 'Carburo de tugsteno (W > 85 %)', 'TUNGSTENO ', '2024-06-19 16:22:20', '5'),
('W-3', 'Puntas de broca con soldadura  // Bushings w/ braz', 'Tungsteno con soldadura (W > 85 % - Fe < 1 %)', 'TUNGSTENO ', '2024-06-19 16:23:03', '5'),
('W-4', 'puntas de broca limpias  // Drill (mining compacts', 'Carburo de tugsteno W > 85 %', 'TUNGSTENO ', '2024-06-19 16:38:11', '5'),
('W-5', 'brocas o escareadores de taladro  // Drills', 'Carburo de tugsteno W > 85 %', 'TUNGSTENO ', '2024-06-19 16:38:50', '5'),
('W-6', 'Anillos grandes con Niquel - Large rings with Ni', 'Densalloy  (W > 90 % - NI < 7 %)', 'TUNGSTENO ', '2024-06-19 16:40:41', '5'),
('W-7', 'Royos de morgan  // Morgan Rolls', 'Densalloy  (W > 90 % - NI < 7 %)', 'TUNGSTENO ', '2024-06-19 16:41:14', '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `representantelegal` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` bigint(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `camara_comercio` varchar(50) NOT NULL,
  `rut` varchar(50) NOT NULL,
  `cc_representante` varchar(50) NOT NULL,
  `certificacion_comercial` varchar(50) NOT NULL,
  `certificacion_bancaria` varchar(50) NOT NULL,
  `circular_170` varchar(50) NOT NULL,
  `acuerdos_seguridad` varchar(50) NOT NULL,
  `estados_financieros` varchar(50) NOT NULL,
  `autorizacion_tratamiento_datos` varchar(50) NOT NULL,
  `visita` varchar(50) NOT NULL,
  `antecedentes_judiciales` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `representantelegal`, `correo`, `telefono`, `direccion`, `fecha_registro`, `camara_comercio`, `rut`, `cc_representante`, `certificacion_comercial`, `certificacion_bancaria`, `circular_170`, `acuerdos_seguridad`, `estados_financieros`, `autorizacion_tratamiento_datos`, `visita`, `antecedentes_judiciales`) VALUES
('1016002068', 'robinson fredy cortes castiblanco  ', 'robinson fredy cortes castiblanco ', 'robinsoncortes12@hotmail.com', 3172706747, 'carrera 80i#56-25 sur ', '2024-08-02 00:00:00', './guardar/robinson fredy cortes castiblanco  /', './guardar/robinson fredy cortes castiblanco  /', './guardar/robinson fredy cortes castiblanco  /Imag', './guardar/robinson fredy cortes castiblanco  /', './guardar/robinson fredy cortes castiblanco  /Cert', './guardar/robinson fredy cortes castiblanco  /', './guardar/robinson fredy cortes castiblanco  /', './guardar/robinson fredy cortes castiblanco  /', './guardar/robinson fredy cortes castiblanco  /', './guardar/robinson fredy cortes castiblanco  /', './guardar/robinson fredy cortes castiblanco  /'),
('10305257674', 'YONANY DARIO LEGUIZAMON GONZALES ', 'YONANY DARIO LEGUIZAMON GONZALES ', 'yoan222008@hotmail.com', 3125525743, 'CRA 69 C 22 93- SUR ', '2024-06-28 00:00:00', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /rut yo', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE ', './guardar/YONANY DARIO LEGUIZAMON GONZALES /NO SE '),
('10700087357', 'GONZALEZ MANJARREZ ANDRES ALFONSO', 'GONZALEZ MANJARREZ ANDRES ALFONSO', 'mantwo89@hotmail.com', 3166225119, 'CR 129 A 137 B 34', '2024-06-21 00:00:00', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/RUT_AN', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/', './guardar/GONZALEZ MANJARREZ ANDRES ALFONSO/'),
('10969597598', 'JOHANNA  R ORTIZ ESTUPIÑAN', 'JOPHANNA OSRTIZ ', 'JOHANNAEST79@GMAIL.COM', 3133424179, 'CALLE 32 SUR #51D-71', '2024-08-16 00:00:00', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/Imagen de Wha', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/Imagen de Wha', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/', './guardar/JOHANNA  R ORTIZ ESTUPIÑAN/'),
('262896146', 'GREYSTONEALLOYS', 'GREYSTONEALLOYS', 'GRE.COM', 0, 'XX', '2024-07-15 00:00:00', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/', './guardar/GREYSTONEALLOYS/'),
('2704693481', 'TUNGCO POWDER PROCUREMENT', 'TUNGCO', 'TUNGCO.COM', 2708250000, '4035 Anton Rd, Madisonville, KY 42431', '2024-07-15 00:00:00', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/', './guardar/TUNGCO POWDER PROCUREMENT/'),
('79426908', 'CHEO ', 'JOSE FERNANDO SANCHEZ ', 'NO APLICA ', 3124319900, 'NO APLICA ', '2024-06-28 00:00:00', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf', './guardar/CHEO /NO SE CUENTA CON DOCUMENTO.pdf'),
('8000427253', 'INDUSTRIAS MONTES S.A.S', 'DIEGO MONTES ', 'INDUSTRIASMONTES@UNE.NET.CO', 2147483647, 'VIA PANAMERICANA 71 A 110', '2024-06-21 00:00:00', './guardar/INDUSTRIAS MONTES S.A.S/CCIOAGOSTO2022.p', './guardar/INDUSTRIAS MONTES S.A.S/RUTIMT202309.pdf', './guardar/INDUSTRIAS MONTES S.A.S/', './guardar/INDUSTRIAS MONTES S.A.S/', './guardar/INDUSTRIAS MONTES S.A.S/CERT_BBIA_SEP22.', './guardar/INDUSTRIAS MONTES S.A.S/', './guardar/INDUSTRIAS MONTES S.A.S/', './guardar/INDUSTRIAS MONTES S.A.S/', './guardar/INDUSTRIAS MONTES S.A.S/', './guardar/INDUSTRIAS MONTES S.A.S/', './guardar/INDUSTRIAS MONTES S.A.S/'),
('80229069', 'WILLIAM PUENTES ', 'WILLIAM PUENTES ', 'ELIANA.PUENTESP@UNIAGUSTINIANA.EDU.CO', 2147483647, 'CRA 31A#7-32', '2024-06-21 00:00:00', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /', './guardar/WILLIAM PUENTES /'),
('8320022430', 'MTI MONTAJES Y MANTENIMIENTOS TECNICOS INDUSTRIALE', 'PATRICIO PIMINETO LOPEZ ', 'proyectos@mtisas.com', 3002114604, 'CRA 5 E 10 VIA PURINA ', '2024-06-28 00:00:00', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I', './guardar/MTI MONTAJES Y MANTENIMIENTOS TECNICOS I'),
('8516644', 'ENDER ESTRADA ', 'ENDER ESTRADA ', 'ISABELITA_1102@HOTMAIL.COM', 3015277075, 'CALLE 6#12A04', '2024-07-12 00:00:00', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /', './guardar/ENDER ESTRADA /'),
('8600691821', 'COMPAÑIA GENERAL DE ACEROS S A - EN REORGANIZACION', 'omar d quijano reyes ', 'aceros@cga.com.co', 3124570889, 'AV 68 37 B 51 SUR', '2024-07-11 00:00:00', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR', './guardar/COMPAÑIA GENERAL DE ACEROS S A - EN REOR'),
('900451379', 'BORETS SERVICES LTD. SUCURSAL COLOMBIA', 'ANDRES GUERRA', 'ANDRES.GUERRA@LEVARE.COM', 3108561855, 'Km 3,5 Via Funza – Siberia, Parque Industrial San ', '2024-07-15 00:00:00', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/', './guardar/BORETS SERVICES LTD. SUCURSAL COLOMBIA/'),
('900967552', 'DRILLING OPERATION PETROLEUM SAS', 'CESAR BERNAL ', 'admondropsas@gmail.com', 3164903862, 'Cra 2 - 4 - 267', '2024-07-12 00:00:00', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/', './guardar/DRILLING OPERATION PETROLEUM SAS/'),
('9010595731', 'SUMIPARTS SAS', 'javier andres ruiz rodriguez', ' facturaelectronica@sumiparts.com', 3188864826, 'calle 9#34-94', '2024-07-12 00:00:00', './guardar/SUMIPARTS SAS/CAMARA DE COMERCIO JULIO.p', './guardar/SUMIPARTS SAS/RUT SUMIPARTS SAS 07 03 20', './guardar/SUMIPARTS SAS/', './guardar/SUMIPARTS SAS/', './guardar/SUMIPARTS SAS/certificado bancario sumip', './guardar/SUMIPARTS SAS/', './guardar/SUMIPARTS SAS/', './guardar/SUMIPARTS SAS/', './guardar/SUMIPARTS SAS/', './guardar/SUMIPARTS SAS/', './guardar/SUMIPARTS SAS/'),
('901060185', 'TAC DE COLOMBIA SAS', 'BUSTAMANTE SERPA IVAN ALEJANDRO', 'contabilidad.tacdecolombia@gmail.com', 2147483647, 'CL 20 29 59 OF 305', '2023-08-06 00:00:00', './guardar/TAC DE COLOMBIA SAS/', './guardar/TAC DE COLOMBIA SAS/RUT 2023.pdf', './guardar/TAC DE COLOMBIA SAS/cedula Ivan Bustaman', './guardar/TAC DE COLOMBIA SAS/', './guardar/TAC DE COLOMBIA SAS/Certificacio_n Banca', './guardar/TAC DE COLOMBIA SAS/', './guardar/TAC DE COLOMBIA SAS/', './guardar/TAC DE COLOMBIA SAS/', './guardar/TAC DE COLOMBIA SAS/', './guardar/TAC DE COLOMBIA SAS/', './guardar/TAC DE COLOMBIA SAS/image (4).png'),
('901114904', 'DEPOSITO GAITAN S A S', 'YEISON LECTEO', 'depositogaitan@hotmail.com', 2147483647, 'CALLE 24 120 03', '2024-06-21 00:00:00', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/', './guardar/DEPOSITO GAITAN S A S/'),
('9016721783', 'TECNIFILOS SAS', 'TECNIFILOS SAS', 'ventastecnifilos@gmail.com', 3, 'CR 68 L NO. 38 D 09 SUR LC 2', '2024-08-20 00:00:00', './guardar/TECNIFILOS SAS/Camara de comercio marzo ', './guardar/TECNIFILOS SAS/RUT TECNIFILOS 2024.pdf', './guardar/TECNIFILOS SAS/', './guardar/TECNIFILOS SAS/', './guardar/TECNIFILOS SAS/CERTIFICACION BANCARIA DI', './guardar/TECNIFILOS SAS/', './guardar/TECNIFILOS SAS/', './guardar/TECNIFILOS SAS/', './guardar/TECNIFILOS SAS/', './guardar/TECNIFILOS SAS/', './guardar/TECNIFILOS SAS/'),
('9016772333', 'COOPERATIVA MULTIACTIVA DE CUNDINAMARCA', 'EDUARDO CASTELLANOS', 'COOPERATIVA MULTIACTIVA DE CUNDINAMARCA', 2147483647, 'CR 97 A 58 S 39', '2024-06-21 00:00:00', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/', './guardar/COOPERATIVA MULTIACTIVA DE CUNDINAMARCA/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE `salida` (
  `id` int(11) NOT NULL,
  `suma_total_kilos` decimal(10,2) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `clienteFK` varchar(50) NOT NULL,
  `id_usuarioFK` int(11) NOT NULL,
  `id_productoFK` varchar(50) NOT NULL,
  `evidencia` varchar(50) NOT NULL,
  `documentacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `salida`
--

INSERT INTO `salida` (`id`, `suma_total_kilos`, `fecha_hora`, `valor_total`, `clienteFK`, `id_usuarioFK`, `id_productoFK`, `evidencia`, `documentacion`) VALUES
(5, 1718.00, '2024-08-21 10:36:33', 0.00, '270.469.348-1', 1022414392, 'W-1', '../Salida/evidencia/FORMATO -PACKING LIST - FW1856', '../Salida/documentacion/FORMATO -PACKING LIST - FW'),
(6, 50.00, '2024-08-21 10:36:33', 0.00, '270.469.348-1', 1022414392, 'W-2', '../Salida/evidencia/FORMATO -PACKING LIST - FW1856', '../Salida/documentacion/FORMATO -PACKING LIST - FW'),
(7, 64.00, '2024-08-21 10:36:33', 0.00, '270.469.348-1', 1022414392, 'W-3', '../Salida/evidencia/FORMATO -PACKING LIST - FW1856', '../Salida/documentacion/FORMATO -PACKING LIST - FW'),
(8, 65.00, '2024-08-21 10:36:33', 0.00, '270.469.348-1', 1022414392, 'W-4', '../Salida/evidencia/FORMATO -PACKING LIST - FW1856', '../Salida/documentacion/FORMATO -PACKING LIST - FW'),
(9, 1400.00, '2024-08-21 10:42:01', 0.00, '270.469.348-1', 1022414392, 'W-1', '../Salida/evidencia/FORMATO -PACKING LIST - FW1848', '../Salida/documentacion/FORMATO -PACKING LIST - FW'),
(10, 46.50, '2024-08-21 10:42:01', 0.00, '270.469.348-1', 1022414392, 'W-2', '../Salida/evidencia/FORMATO -PACKING LIST - FW1848', '../Salida/documentacion/FORMATO -PACKING LIST - FW'),
(13, 495.00, '2024-08-21 16:35:21', 0.00, '262.896.146', 1022414392, 'Co-1', '', '../Salida/documentacion/FORMATO -PACKING LIST - FW'),
(14, 4844.00, '2024-08-21 16:35:21', 0.00, '262.896.146', 1022414392, 'NI-1', '../Salida/evidencia/FORMATO -PACKING LIST - FW1839', '../Salida/documentacion/FORMATO -PACKING LIST - FW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `permiso` int(11) NOT NULL,
  `contraseña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `cargo`, `permiso`, `contraseña`) VALUES
(1, 'gsanchez', 'Gerente', 1, 'gsanchez'),
(2, 'gcavendano', 'innovacion', 1, 'gcavendano'),
(3, 'Almacenamiento', 'almacenamiento', 1, 'Almacenamiento'),
(80000697, 'coordinador1', 'coordinador1', 1, 'coordinador1'),
(1022414392, 'proyectos', 'Bodega', 1, 'proyectos'),
(1032485205, 'tech', 'Programador', 1, '123456');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `consolidado_inventario`
--
ALTER TABLE `consolidado_inventario`
  ADD PRIMARY KEY (`id_productoFK`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingreso_id` (`ingreso_id`),
  ADD KEY `id_inventarioFK` (`id_inventarioFK`);

--
-- Indices de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_salida` (`id_salida`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_productoFK` (`id_productoFK`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `inventario_old`
--
ALTER TABLE `inventario_old`
  ADD PRIMARY KEY (`id_inventario_old`),
  ADD KEY `id_salida` (`id_salida`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clienteFK` (`clienteFK`),
  ADD KEY `id_usuarioFK` (`id_usuarioFK`),
  ADD KEY `id_productoFK` (`id_productoFK`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `inventario_old`
--
ALTER TABLE `inventario_old`
  MODIFY `id_inventario_old` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `salida`
--
ALTER TABLE `salida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consolidado_inventario`
--
ALTER TABLE `consolidado_inventario`
  ADD CONSTRAINT `consolidado_inventario_ibfk_1` FOREIGN KEY (`id_productoFK`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD CONSTRAINT `detalle_ingreso_ibfk_1` FOREIGN KEY (`ingreso_id`) REFERENCES `ingreso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_ingreso_ibfk_2` FOREIGN KEY (`id_inventarioFK`) REFERENCES `inventario` (`id_inventario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  ADD CONSTRAINT `detalle_salida_ibfk_1` FOREIGN KEY (`id_salida`) REFERENCES `salida` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_4` FOREIGN KEY (`id_productoFK`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `salida`
--
ALTER TABLE `salida`
  ADD CONSTRAINT `salida_ibfk_1` FOREIGN KEY (`clienteFK`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salida_ibfk_2` FOREIGN KEY (`id_usuarioFK`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salida_ibfk_3` FOREIGN KEY (`id_productoFK`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
