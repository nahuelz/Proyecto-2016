-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-02-2017 a las 16:44:37
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grupo41`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bot`
--

CREATE TABLE `bot` (
  `id` int(11) NOT NULL,
  `chat_id` int(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bot`
--

INSERT INTO `bot` (`id`, `chat_id`) VALUES
(1, 1111),
(2, 222);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `categoria_padre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `categoria_padre_id`) VALUES
(1, 'Bebida', 0),
(5, 'Golosinas', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `proveedor` varchar(100) NOT NULL,
  `preveedor_cuit` varchar(15) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `proveedor`, `preveedor_cuit`, `fecha`) VALUES
(36, 'ProveedorBebidas', '123456', '2016-10-23 02:26:15'),
(37, 'Coca cola', '123123', '2016-10-23 18:53:18'),
(38, 'Coca cola', '123123', '2016-10-23 18:56:17'),
(39, 'adasd', 'asdasd', '2016-10-23 18:59:54'),
(40, 'adasd', 'asdasd', '2016-10-23 19:01:49'),
(41, 'adasd', 'asdasd', '2016-10-23 19:02:40'),
(42, 'adasd', 'asdasd', '2016-10-23 19:03:23'),
(43, 'asdasd', '123123', '2016-10-23 19:04:39'),
(44, 'asdasd', '123123', '2016-10-23 19:10:07'),
(45, 'asdasd', '123123', '2016-10-23 19:10:37'),
(46, 'asdasd', '123123', '2016-10-23 19:12:10'),
(47, 'Coca cola', '123123', '2016-10-23 19:23:29'),
(48, 'Coca cola', '123455', '2016-10-27 16:27:41'),
(49, 'Coca cola', '123455', '2016-10-27 16:27:57'),
(50, 'Coca cola', '123455', '2016-10-27 16:28:16'),
(51, 'aasd', '123444', '2016-10-29 20:40:11'),
(52, 'asdsadasd', '123123', '2016-10-30 03:21:17'),
(53, 'asdasd', 'asdasd', '2016-11-13 22:28:49'),
(54, 'asdasd', 'asdasd', '2016-11-13 22:29:43'),
(55, 'proveedor1', '123', '2016-11-13 22:30:34'),
(56, 'proveedorcoca', 'cuitproveedor', '2016-11-13 22:31:28'),
(57, 'asdasd', '123123', '2016-11-14 12:12:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `clave` varchar(50) NOT NULL,
  `valor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`clave`, `valor`) VALUES
('cant_elementos', '10'),
('descripcion', 'Contenido relacionado con la pagina principal de la aplicacion del buffet'),
('email', 'buffet@info.unlp.edu.ar'),
('mensaje', 'En estos momentos el sitio se encuentra deshabilitado'),
('sitio', 'Habilitado'),
('tiempoCancelacion', '10'),
('titulo', 'BUFFET DE LA FACULTAD DE INFORMATICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_detalle`
--

CREATE TABLE `egreso_detalle` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `egreso_tipo_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `egreso_detalle`
--

INSERT INTO `egreso_detalle` (`id`, `compra_id`, `producto_id`, `cantidad`, `precio_unitario`, `egreso_tipo_id`, `fecha`) VALUES
(1, 48, 14, 100, 10, 1, '2016-10-27 16:27:41'),
(2, 49, 14, 100, 10, 1, '2016-10-27 16:27:57'),
(3, 50, 14, 100, 10, 1, '2016-10-27 16:28:16'),
(4, 51, 14, 10, 10, 1, '2016-10-29 20:40:11'),
(5, 51, 13, 11, 11, 1, '2016-10-29 20:40:11'),
(6, 52, 13, 100, 12, 1, '2016-10-30 03:21:17'),
(7, 36, 15, 1, 10, 1, '2016-11-12 00:00:00'),
(8, 53, 13, 1, 11, 1, '2016-11-13 22:28:49'),
(9, 54, 13, 1, 11, 1, '2016-11-13 22:29:43'),
(10, 55, 13, 1, 1, 1, '2016-11-13 22:30:34'),
(11, 56, 13, 1, 1, 1, '2016-11-13 22:31:28'),
(12, 56, 14, 2, 2, 1, '2016-11-13 22:31:28'),
(13, 57, 14, 1, 10, 1, '2016-11-14 12:12:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_tipo`
--

CREATE TABLE `egreso_tipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_detalle`
--

CREATE TABLE `ingreso_detalle` (
  `id` int(11) NOT NULL,
  `ingreso_tipo_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ingreso_detalle`
--

INSERT INTO `ingreso_detalle` (`id`, `ingreso_tipo_id`, `producto_id`, `cantidad`, `precio_unitario`, `descripcion`, `fecha`) VALUES
(10, 1, 13, 10, 20, '', '2016-10-27 01:59:02'),
(11, 1, 13, 100, 20, '', '2016-10-30 02:50:48'),
(12, 1, 14, 310, 25, '', '2016-10-31 16:26:19'),
(13, 1, 13, 1, 20, '', '2016-11-06 20:37:49'),
(14, 1, 13, 1, 20, '', '2016-11-06 20:45:40'),
(15, 1, 14, 11, 1, 'asd', '2016-11-12 00:00:00'),
(16, 1, 13, 9, 20, '', '2016-11-13 21:50:42'),
(17, 1, 13, 4, 20, '', '2016-11-14 12:12:18'),
(18, 1, 15, 10, 17, '', '2016-11-14 12:18:15'),
(19, 1, 15, 2, 17.2, '', '2016-11-14 12:36:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_tipo`
--

CREATE TABLE `ingreso_tipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_del_dia`
--

CREATE TABLE `menu_del_dia` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `habilitado` enum('S','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu_del_dia`
--

INSERT INTO `menu_del_dia` (`id`, `producto_id`, `fecha`, `habilitado`) VALUES
(88, 14, '2016-11-15 00:00:00', 'S'),
(92, 13, '2016-10-30 00:00:00', 'S'),
(93, 13, '2016-10-31 00:00:00', 'S'),
(94, 14, '2016-10-31 00:00:00', 'S'),
(95, 13, '2016-11-01 00:00:00', 'S'),
(96, 15, '2016-11-01 00:00:00', 'S'),
(97, 13, '2016-11-06 00:00:00', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `motivo_cancelacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `estado_id`, `fecha_alta`, `usuario_id`, `observacion`, `motivo_cancelacion`) VALUES
(1, 2, '2016-11-06 19:42:01', 14, '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE `pedido_detalle` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido_detalle`
--

INSERT INTO `pedido_detalle` (`id`, `producto_id`, `cantidad`, `pedido_id`) VALUES
(1, 13, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `codigo_barra` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_minimo` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `proveedor` varchar(45) NOT NULL,
  `precio_venta_unitario` float NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_alta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `marca`, `codigo_barra`, `stock`, `stock_minimo`, `categoria_id`, `proveedor`, `precio_venta_unitario`, `descripcion`, `fecha_alta`) VALUES
(13, 'Coca Cola', 'Coca Cola', '123456', 90, 10, 1, 'Bebidas', 20, 'Gaseosa', '2016-10-27 01:58:47'),
(14, 'Fanta', 'Coca Cola', '123111', 3, 10, 1, 'ProveedorBebidas', 25, 'Gaseosa', '2016-10-27 16:26:31'),
(15, 'Sprite', 'Coca Cola', '111444', 88, 10, 1, 'Bebidas', 17.2, 'Gaseosa', '2016-11-01 17:30:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'Administracion'),
(2, 'Gestion'),
(3, 'Usuario Online');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id`, `nombre`, `descripcion`) VALUES
(1, '', ''),
(2, '1234', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `documento` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `rol_id` int(11) NOT NULL,
  `ubicacion_id` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `trabajo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `nombre`, `apellido`, `documento`, `email`, `telefono`, `rol_id`, `ubicacion_id`, `habilitado`, `trabajo`) VALUES
(2, 'root', 'root', 'root', 'root', '30000000', 'root@root.root', '4790000', 1, 0, 1, NULL),
(13, 'gestion', 'gestion', 'gestion', 'gestion', '12345678', 'gestion@gestion', '1234567', 2, 1, 1, NULL),
(14, 'online', 'online', 'online', 'online', '12345678', 'online@online', '1234567', 3, 1, 1, 'LINTI'),
(15, 'deshabilitado', 'deshabilitado', 'deshabilitado', 'deshabilitado', '12345678', 'deshabilitado@deshabilitado', '1234567', 2, 1, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bot`
--
ALTER TABLE `bot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`clave`);

--
-- Indices de la tabla `egreso_detalle`
--
ALTER TABLE `egreso_detalle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ingreso_tipo_id` (`id`),
  ADD KEY `producto_id` (`id`);

--
-- Indices de la tabla `egreso_tipo`
--
ALTER TABLE `egreso_tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingreso_detalle`
--
ALTER TABLE `ingreso_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingreso_tipo`
--
ALTER TABLE `ingreso_tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_del_dia`
--
ALTER TABLE `menu_del_dia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bot`
--
ALTER TABLE `bot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT de la tabla `egreso_detalle`
--
ALTER TABLE `egreso_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `egreso_tipo`
--
ALTER TABLE `egreso_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ingreso_detalle`
--
ALTER TABLE `ingreso_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `ingreso_tipo`
--
ALTER TABLE `ingreso_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `menu_del_dia`
--
ALTER TABLE `menu_del_dia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
