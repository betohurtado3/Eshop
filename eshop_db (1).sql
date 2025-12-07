-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-12-2025 a las 05:07:20
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
-- Base de datos: `eshop_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colecciones`
--

CREATE TABLE `colecciones` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(150) NOT NULL,
  `Slug` varchar(150) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `FechaCreacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colecciones`
--

INSERT INTO `colecciones` (`Id`, `Nombre`, `Slug`, `Descripcion`, `Estado`, `FechaCreacion`) VALUES
(1, 'Urban Drop 2025', '', 'Colección inspirada en la cultura urbana moderna.', 'Activo', '2025-11-25 19:42:35'),
(2, 'Night Vision', '', 'Colección con acabados reflectantes y estéticos nocturnos.', 'Activo', '2025-11-25 19:42:35'),
(3, 'Rappers Light', '', 'Rapeando, sumbando...', 'Activo', '2025-11-28 16:15:47'),
(4, 'Coleccion de Prueba', '', 'Coleccion que viene a ser una prueba', 'Activo', '2025-12-02 11:20:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Tipo` enum('Producto','Coleccion','Hero','Banner','General') NOT NULL,
  `Id_Relacionado` int(11) DEFAULT NULL,
  `EsPrincipal` tinyint(1) DEFAULT 0,
  `Orden` int(11) DEFAULT 0,
  `FechaCreacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`Id`, `Nombre`, `Tipo`, `Id_Relacionado`, `EsPrincipal`, `Orden`, `FechaCreacion`) VALUES
(1, 'hero_principal.jpg', 'Hero', NULL, 0, 0, '2025-11-25 19:44:54'),
(2, 'urban_drop_banner.jpg', 'Coleccion', 1, 0, 0, '2025-11-25 19:44:54'),
(3, 'night_vision_banner.jpg', 'Coleccion', 2, 0, 0, '2025-11-25 19:44:54'),
(4, 'hoodie_lym_1.jpg', 'Producto', 1, 0, 0, '2025-11-25 19:44:54'),
(5, 'hoodie_lym_2.jpg', 'Producto', 1, 0, 0, '2025-11-25 19:44:54'),
(6, 'techwear_reflective_1.jpg', 'Producto', 2, 0, 0, '2025-11-25 19:44:54'),
(7, 'sudadera_blackline_1.jpg', 'Producto', 3, 0, 0, '2025-11-25 19:44:54'),
(8, 'sudadera_blackline_2.jpg', 'Producto', 3, 0, 0, '2025-11-25 19:44:54'),
(9, 'joggers_phantom_1.jpg', 'Producto', 4, 0, 0, '2025-11-25 19:44:54'),
(10, 'techwear_reflective_2.jpg', 'Producto', 2, 0, 0, '2025-11-25 19:44:54'),
(11, 'techwear_reflective_3.jpg', 'Producto', 2, 0, 0, '2025-11-25 19:44:54'),
(12, 'sudadera_blackline_3.jpg', 'Producto', 3, 0, 0, '2025-11-25 19:44:54'),
(13, 'joggers_phantom_2.jpg', 'Producto', 4, 0, 0, '2025-11-25 19:44:54'),
(14, 'prod_692e1aef42eda.webp', 'Producto', 6, 1, 1, '2025-12-01 16:47:11'),
(15, 'prod_692e1aef436e0.webp', 'Producto', 6, 0, 2, '2025-12-01 16:47:11'),
(16, 'prod_692e1aef4417b.webp', 'Producto', 6, 0, 3, '2025-12-01 16:47:11'),
(17, 'prod_692e1aef44b2c.webp', 'Producto', 6, 0, 4, '2025-12-01 16:47:11'),
(18, 'coleccion_692f1fe407924.png', 'Coleccion', 4, 1, 1, '2025-12-02 11:20:36'),
(19, '1764697115_psyduck-removebg-preview.png', 'Coleccion', 3, 1, 1, '2025-12-02 11:38:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(150) NOT NULL,
  `Slug` varchar(150) NOT NULL,
  `Coleccion` text NOT NULL,
  `Id_Coleccion` int(11) DEFAULT NULL,
  `DescripcionCorta` varchar(255) DEFAULT NULL,
  `DescripcionLarga` text DEFAULT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int(11) DEFAULT 0,
  `Estado` enum('Activo','Inactivo','Borrador') DEFAULT 'Activo',
  `FechaCreacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Id`, `Nombre`, `Slug`, `Coleccion`, `Id_Coleccion`, `DescripcionCorta`, `DescripcionLarga`, `Precio`, `Stock`, `Estado`, `FechaCreacion`) VALUES
(1, 'Hoodie Oversize LYM', '', 'Urban Drop 2025', 1, 'Hoodie oversize premium.', 'Hoodie inspirado en la estética minimalista urbana. Tela pesada 450g, ideal para invierno.', 1099.00, 30, 'Activo', '2025-11-25 19:44:30'),
(2, 'Camisa Techwear Reflective', '', 'Urban Drop 2025', 1, 'Camisa reflectiva estilo techwear.', 'Camisa ligera con material reflectante bajo luz directa. Ideal para fotos y streetwear nocturno.', 899.00, 18, 'Activo', '2025-11-25 19:44:30'),
(3, 'Sudadera Blackline Night', '', 'Night Vision', 2, 'Sudadera oscura con detalles brillantes.', 'Sudadera estilo tactical premium con impresión reflectante y costuras reforzadas.', 1199.00, 30, 'Activo', '2025-11-25 19:44:30'),
(4, 'Joggers Phantom', '', 'Night Vision', 2, 'Joggers negros estilo minimal.', 'Joggers ultra cómodos con cortes limpios y estilo stealth. Perfectos para outfits urbanos.', 799.00, 40, 'Activo', '2025-11-25 19:44:30'),
(5, 'Nombre de prueba', 'Slug prueba', 'Coleccion prueba', NULL, 'corta ', 'larga', 10.00, 10, 'Activo', '2025-11-28 15:50:14'),
(6, 'Back Home La Liga Men\'s home jersey 25/26 FC', 'Barcelona', 'Jerseys', NULL, 'Jersey Barcelona 2025', 'Diseñada con las icónicas franjas blaugrana, esta camiseta incorpora un efecto degradado en tonos azul y rojo que le aporta un estilo moderno y dinámico. El escudo del FC Barcelona se sitúa en el pecho, en el lado izquierdo, mientras que el logotipo de Nike aparece en el lado derecho.\r\n\r\nInspirada en los profesionales, nuestra colección Stadium tiene tecnología absorbente de sudor para ofrecerte un look listo para el partido inspirado en tu equipo favorito. Mantente seco.', 2500.00, 5, 'Activo', '2025-12-01 16:47:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(150) NOT NULL,
  `Descuento` int(11) NOT NULL,
  `Fecha_Inicio` datetime DEFAULT NULL,
  `Fecha_Fin` datetime DEFAULT NULL,
  `Estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`Id`, `Nombre`, `Descuento`, `Fecha_Inicio`, `Fecha_Fin`, `Estado`) VALUES
(1, 'Descuento Año Nuevo', 20, '2025-01-01 00:00:00', '2025-01-10 00:00:00', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `Usuario` varchar(150) NOT NULL,
  `Correo` text NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Nombre` varchar(150) DEFAULT NULL,
  `Rol` varchar(50) NOT NULL DEFAULT 'cliente',
  `Estado` tinyint(1) NOT NULL DEFAULT 1,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `FechaActualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `Usuario`, `Correo`, `Contrasena`, `Nombre`, `Rol`, `Estado`, `FechaCreacion`, `FechaActualizacion`) VALUES
(1, 'Admin', 'betohurtado3@hotmail.com', '$2y$10$98Bs9Rg4qrbBnjB3f36zfeHYcLBK5UXUbCHzyckRqnigfP1YUKYFG', 'Administrador Principal', 'Admin', 1, '2025-11-24 22:03:37', '2025-11-26 23:13:13'),
(2, 'User', 'user@mail.com', '$2y$10$98Bs9Rg4qrbBnjB3f36zfeHYcLBK5UXUbCHzyckRqnigfP1YUKYFG', 'Usuario Perron', 'User', 1, '2025-11-24 22:03:37', '2025-11-28 21:23:34'),
(3, 'Prueba', 'prueba@mail.com', '$2y$10$QNQYBOiakVB1VzL8I9MsUurtooRGv0N3/uQ7KnIP1skU08LMUkDP.', 'Usuario Prueba', 'User', 1, '2025-11-28 00:53:11', '2025-11-28 21:35:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colecciones`
--
ALTER TABLE `colecciones`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Coleccion` (`Id_Coleccion`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Usuario` (`Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `colecciones`
--
ALTER TABLE `colecciones`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Id_Coleccion`) REFERENCES `colecciones` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
