-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2026 a las 07:53:01
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecnolost`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_administrador` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_administrador`, `nombre`, `apellido`, `usuario`, `contrasena`, `email`, `fecha_registro`) VALUES
(1, 'Nicolas', 'Noriega', 'Nico', '1234', 'Nico@gmail.com', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Vestimenta', 'Categoria registrada desde el panel admin.'),
(2, 'Tecnologia', 'Categoria registrada desde el panel admin.'),
(3, 'Estuche', 'Categoria registrada desde el panel admin.'),
(4, 'Botellas', 'Categoria registrada desde el panel admin.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_objeto`
--

CREATE TABLE `estado_objeto` (
  `id_estado_objeto` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_objeto`
--

INSERT INTO `estado_objeto` (`id_estado_objeto`, `nombre`, `descripcion`) VALUES
(1, 'Encontrado', 'Estado registrado desde el panel admin.'),
(2, 'Entregado', 'El objeto ya fue devuelto a su dueño.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_solicitud`
--

CREATE TABLE `estado_solicitud` (
  `id_estado_solicitud` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_solicitud`
--

INSERT INTO `estado_solicitud` (`id_estado_solicitud`, `nombre`, `descripcion`) VALUES
(1, 'Pendiente', 'Solicitud recibida y pendiente de revision.'),
(2, 'Aprobada', 'La solicitud ha sido verificada y aprobada.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objeto`
--

CREATE TABLE `objeto` (
  `id_objeto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_ubicacion` int(11) NOT NULL,
  `id_estado_objeto` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `fecha_encontrado` date NOT NULL,
  `fecha_registro` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `objeto`
--

INSERT INTO `objeto` (`id_objeto`, `id_categoria`, `id_ubicacion`, `id_estado_objeto`, `id_administrador`, `nombre`, `descripcion`, `color`, `marca`, `fecha_encontrado`, `fecha_registro`, `foto`, `observaciones`) VALUES
(1, 1, 1, 1, 1, 'Mochila', 'Mochila adidas con cierre blanco', 'Azul', 'Adidas', '2026-07-01', '2026-07-01', 'objeto_20260701_054523_f37cb1c4.webp', NULL),
(2, 1, 2, 1, 1, 'Campera', 'Campera con capucha', 'Negra', 'Nike', '2026-06-01', '2026-07-01', 'objeto_20260701_054936_7539d6d6.webp', NULL),
(3, 2, 3, 2, 1, 'Celular', 'Celular Samsung A13 con caja', 'Negro', 'Samsung', '2026-07-01', '2026-07-01', 'objeto_20260701_055200_d4c72674.webp', NULL),
(4, 3, 4, 1, 1, 'Cartucheras', 'Dos cartucheras con logo de la AFA', 'Celeste', 'AFA', '2026-06-06', '2026-07-01', 'objeto_20260701_055532_343d8aa5.webp', NULL),
(5, 4, 5, 1, 1, 'Termo', 'Termo marca Stanley con tapa plateada', 'Verde', 'Stanley', '2026-07-01', '2026-07-01', 'objeto_20260701_055855_5f250873.webp', NULL),
(6, 1, 6, 1, 1, 'Gorra', 'Gorro negro New Era con letras negras y contorno blanco', 'Negro', 'New Era', '2026-06-03', '2026-07-01', 'objeto_20260701_060248_6983d82d.webp', NULL),
(7, 2, 7, 1, 1, 'Computadora', 'Computadora de marca DELL negra', 'Negro', 'Dell', '2026-05-12', '2026-07-01', 'objeto_20260701_060536_41b9c18a.webp', 'Se encuentra un poco sucia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitante`
--

CREATE TABLE `solicitante` (
  `id_solicitante` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `curso` varchar(20) NOT NULL,
  `division` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitante`
--

INSERT INTO `solicitante` (`id_solicitante`, `nombre`, `apellido`, `curso`, `division`, `email`, `telefono`) VALUES
(1, 'Nicolas', 'Noriega', '6', '3', 'Nicolas31@gmail.com', NULL),
(2, 'Dante', 'Bassus', '6', '3', 'Dantebassuss@gmail.com', '1122223333');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL,
  `id_solicitante` int(11) NOT NULL,
  `id_objeto` int(11) NOT NULL,
  `id_estado_solicitud` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `descripcion_propiedad` text NOT NULL,
  `fecha_resolucion` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`id_solicitud`, `id_solicitante`, `id_objeto`, `id_estado_solicitud`, `id_administrador`, `fecha_solicitud`, `descripcion_propiedad`, `fecha_resolucion`, `observaciones`) VALUES
(1, 1, 5, 1, 1, '2026-07-01', 'Lo llevo todos los días al salón cuando tengo clases con Robello', NULL, NULL),
(2, 2, 3, 2, 1, '2026-07-01', 'Es el único celular que llevo y contiene mi email dentro, para poder comprobar que es mio', '2026-07-01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id_ubicacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id_ubicacion`, `nombre`, `sector`, `descripcion`) VALUES
(1, 'Salon 5°1', 'General', 'Ubicacion registrada desde el panel admin.'),
(2, 'Patio', 'General', 'Ubicacion registrada desde el panel admin.'),
(3, 'Salon T2', 'General', 'Ubicacion registrada desde el panel admin.'),
(4, 'Salon 1', 'General', 'Ubicacion registrada desde el panel admin.'),
(5, 'Laboratorio 1', 'General', 'Ubicacion registrada desde el panel admin.'),
(6, 'Salon 2', 'General', 'Ubicacion registrada desde el panel admin.'),
(7, 'Salon 14', 'General', 'Ubicacion registrada desde el panel admin.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_administrador`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `estado_objeto`
--
ALTER TABLE `estado_objeto`
  ADD PRIMARY KEY (`id_estado_objeto`);

--
-- Indices de la tabla `estado_solicitud`
--
ALTER TABLE `estado_solicitud`
  ADD PRIMARY KEY (`id_estado_solicitud`);

--
-- Indices de la tabla `objeto`
--
ALTER TABLE `objeto`
  ADD PRIMARY KEY (`id_objeto`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_ubicacion` (`id_ubicacion`),
  ADD KEY `id_estado_objeto` (`id_estado_objeto`),
  ADD KEY `id_administrador` (`id_administrador`);

--
-- Indices de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  ADD PRIMARY KEY (`id_solicitante`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_solicitante` (`id_solicitante`),
  ADD KEY `id_objeto` (`id_objeto`),
  ADD KEY `id_estado_solicitud` (`id_estado_solicitud`),
  ADD KEY `id_administrador` (`id_administrador`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id_ubicacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_objeto`
--
ALTER TABLE `estado_objeto`
  MODIFY `id_estado_objeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_solicitud`
--
ALTER TABLE `estado_solicitud`
  MODIFY `id_estado_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `objeto`
--
ALTER TABLE `objeto`
  MODIFY `id_objeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  MODIFY `id_solicitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `objeto`
--
ALTER TABLE `objeto`
  ADD CONSTRAINT `objeto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `objeto_ibfk_2` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id_ubicacion`),
  ADD CONSTRAINT `objeto_ibfk_3` FOREIGN KEY (`id_estado_objeto`) REFERENCES `estado_objeto` (`id_estado_objeto`),
  ADD CONSTRAINT `objeto_ibfk_4` FOREIGN KEY (`id_administrador`) REFERENCES `administrador` (`id_administrador`);

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `solicitante` (`id_solicitante`),
  ADD CONSTRAINT `solicitud_ibfk_2` FOREIGN KEY (`id_objeto`) REFERENCES `objeto` (`id_objeto`),
  ADD CONSTRAINT `solicitud_ibfk_3` FOREIGN KEY (`id_estado_solicitud`) REFERENCES `estado_solicitud` (`id_estado_solicitud`),
  ADD CONSTRAINT `solicitud_ibfk_4` FOREIGN KEY (`id_administrador`) REFERENCES `administrador` (`id_administrador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
