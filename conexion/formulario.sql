-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-05-2024 a las 00:19:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `formulario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--
-- Creación: 24-05-2024 a las 00:56:57
--

CREATE TABLE `ciudades` (
  `id_ciudades` int(11) NOT NULL,
  `id_departamentos` int(11) NOT NULL,
  `ciudades` varchar(450) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id_ciudades`, `id_departamentos`, `ciudades`) VALUES
(33, 1, 'Leticia'),
(34, 2, 'Medellín'),
(35, 3, 'Arauca'),
(36, 4, 'Barranquilla'),
(37, 5, ' Cartagena de Indias'),
(38, 6, 'Tunja'),
(39, 7, 'Manizales'),
(40, 8, 'Florencia'),
(41, 9, 'Yopal'),
(42, 10, 'Popayán'),
(43, 11, 'Valledupar'),
(44, 12, 'Quibdó'),
(45, 13, 'Montería'),
(46, 14, 'Bogotá'),
(47, 15, 'Inírida'),
(48, 16, 'San José del Guaviare'),
(49, 17, 'Neiva'),
(50, 18, 'Riohacha'),
(51, 19, 'Santa Marta'),
(52, 20, 'Villavicencio'),
(53, 21, 'San Juan de Pasto'),
(54, 22, ' San José de Cúcuta'),
(55, 23, 'Mocoa'),
(56, 24, 'Armenia'),
(57, 25, 'Pereira'),
(58, 26, 'San Andrés'),
(59, 27, 'Bucaramanga'),
(60, 28, 'Sincelejo'),
(61, 29, 'Ibagué'),
(62, 30, 'Cali'),
(63, 31, 'Mitú'),
(64, 32, 'Puerto Carreño');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--
-- Creación: 23-05-2024 a las 01:24:00
--

CREATE TABLE `departamentos` (
  `id_departamentos` int(11) NOT NULL,
  `departamentos` varchar(450) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamentos`, `departamentos`) VALUES
(1, 'Amazonas'),
(2, 'Antioquía'),
(3, 'Arauca'),
(4, 'Atlántico'),
(5, 'Bolívar'),
(6, 'Boyacá'),
(7, 'Caldas'),
(8, 'Caquetá'),
(9, 'Casanare'),
(10, 'Cauca'),
(11, 'Cesar'),
(12, 'Chocó'),
(13, 'Córdoba'),
(14, 'Cundinamarca'),
(15, 'Guainía'),
(16, 'Guaviare'),
(17, 'Huila'),
(18, 'La Guajira'),
(19, 'Magdalena'),
(20, 'Meta'),
(21, 'Nariño'),
(22, 'Norte de Santander'),
(23, 'Putumayo'),
(24, 'Quindío'),
(25, 'Risaralda'),
(26, 'San Andrés y Providencia'),
(27, 'Santander'),
(28, 'Sucre'),
(29, 'Tolima'),
(30, 'Valle del Cauca'),
(31, 'Vaupés'),
(32, 'Vichada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--
-- Creación: 23-05-2024 a las 01:54:28
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `Licencia_de_conducir` varchar(250) NOT NULL,
  `Tarjeta_de_propiedad` varchar(250) NOT NULL,
  `Soat` varchar(250) NOT NULL,
  `Tecno_mecanica` varchar(250) NOT NULL,
  `Placa` varchar(50) NOT NULL,
  `Marca` varchar(50) NOT NULL,
  `Modelo` varchar(50) NOT NULL,
  `Color` varchar(50) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--
-- Creación: 23-05-2024 a las 01:39:16
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `roles` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `roles`) VALUES
(1, 'administrador'),
(2, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
-- Creación: 23-05-2024 a las 01:44:35
-- Última actualización: 25-05-2024 a las 22:01:12
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `Nombres` varchar(50) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `DNI` varchar(50) NOT NULL,
  `fecha_de_nacimiento` date NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `Departamento` varchar(250) NOT NULL,
  `Ciudad` varchar(250) NOT NULL,
  `Direccion` varchar(250) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `Nombres`, `Apellidos`, `DNI`, `fecha_de_nacimiento`, `telefono`, `Departamento`, `Ciudad`, `Direccion`, `Usuario`, `Password`, `Estado`, `rol`) VALUES
(2, 'DANIEL  DE JESUS', 'SALTARIN MERCADO', '1128187840', '2024-05-22', '3106819921', 'dsdasd', 'dasDsad', 'asdaSD', 'andres', '12345', 'activo', 1),
(4, 'Mauricio jose', 'Fernandez chavez', '112324128', '2024-06-18', '3106819932', 'magdalena ', 'DIBULLA', 'MAGUEYAL ', 'mauricio', '12345', 'activo', 1),
(10, 'DANIEL DE JESUS', 'SALTARIN MERCADO', '1123401924', '2024-05-18', '3106819921', 'magdalena ', 'DIBULLA', 'MAGUEYAL KM 59', 'daniel', '12345', 'activo', 1),
(17, 'MAURICIO ', 'FERNANDEZ', '1123401924', '2024-05-25', '36458484', 'Magdalena ', 'DIBULLA', 'MAGUEYAL KM 59', 'MAURICIO', '12345', 'ACTIVO', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id_ciudades`),
  ADD KEY `id_departamentos` (`id_departamentos`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamentos`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuarios` (`id_usuarios`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id_ciudades` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamentos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD CONSTRAINT `ciudades_ibfk_1` FOREIGN KEY (`id_departamentos`) REFERENCES `departamentos` (`id_departamentos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
