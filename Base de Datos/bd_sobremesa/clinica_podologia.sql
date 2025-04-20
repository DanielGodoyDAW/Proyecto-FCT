-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2025 a las 20:50:26
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
-- Base de datos: `clinica_podologia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) DEFAULT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`idAdmin`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `pass`) VALUES
(1, 'Carmen', 'Godoy', 'Medina', 'carmengodoypodologia@gmail.com', '643645579', '$2y$10$kFSxdLZGwlL9CwjvZ.dLce/LwI6WLxVHLuyBNlTV/0vc550Y7InFe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `idCita` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `anotaciones` text DEFAULT NULL,
  `bloqueada` tinyint(1) NOT NULL DEFAULT 0,
  `confirmada` tinyint(1) NOT NULL DEFAULT 0,
  `idPacientes` int(11) DEFAULT NULL,
  `idAdmin` int(11) DEFAULT NULL,
  `google_event_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idCita`, `fecha`, `hora`, `estado`, `anotaciones`, `bloqueada`, `confirmada`, `idPacientes`, `idAdmin`, `google_event_id`) VALUES
(53, '2025-04-28', '09:00:00', 'Pendiente', NULL, 0, 0, 3, NULL, 'ffojlvnlht2v3l8rdptdrv3780'),
(54, '2025-04-18', '12:30:00', 'Pendiente', NULL, 0, 0, 2, NULL, 'akqrjg7dfkf4nmj7k6gs9r1sno'),
(134, '2025-04-28', '16:00:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(135, '2025-04-28', '16:30:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(136, '2025-04-28', '17:00:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(137, '2025-04-28', '17:30:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(138, '2025-04-28', '18:00:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(139, '2025-04-28', '18:30:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(148, '2025-04-30', '16:00:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(149, '2025-04-30', '16:30:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(150, '2025-04-30', '17:00:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(151, '2025-04-30', '17:30:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(152, '2025-04-30', '18:00:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL),
(153, '2025-04-30', '18:30:00', 'Bloqueada', NULL, 1, 0, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_promociones`
--

CREATE TABLE `citas_promociones` (
  `idCita` int(11) NOT NULL,
  `idPromocion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `idHistorial` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`idHistorial`, `fecha`, `descripcion`) VALUES
(1, '2025-04-16', 'Historial inicial'),
(2, '2025-04-16', 'Historial inicial'),
(3, '2025-04-16', 'Historial inicial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `idPacientes` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) DEFAULT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `fechaNacim` date DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `dni` varchar(20) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `token_recuperacion` varchar(64) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL,
  `idHistorial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`idPacientes`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fechaNacim`, `sexo`, `dni`, `pass`, `token_recuperacion`, `token_expira`, `idHistorial`) VALUES
(1, 'Carmen', 'Godoy', 'Medina', 'carmengodoypodologia@gmail.com', '+34 643645579', '1999-04-06', 'M', '00000000A', '$2y$10$kFSxdLZGwlL9CwjvZ.dLce/LwI6WLxVHLuyBNlTV/0vc550Y7InFe', NULL, NULL, 1),
(2, 'Daniel', 'Godoy', 'Medina', 'danielgodoymedina@gmail.com', '+34 628738526', '1989-07-22', 'H', '53368486E', '$2y$10$uXM4Q6vPl0VgfNw4c1QXAuNCXPFrAr93btbyYiml6C7v8qU/GddUW', '0c6174d44e4abc1fd13912e72ee1d7b54efb4238c1f3f2a27503b7b6c1546193', '2025-04-19 19:48:29', 2),
(3, 'Mariana', 'Alvarez', '', 'hola@hola.com', '+45 645645645', '1998-05-25', 'M', '11111111J', '$2y$10$JfOImQ4UPkzanRmoSX9AF.EPPTAhu16E67uBMSFF1xi0RmASLPZf.', NULL, NULL, 3);

--
-- Disparadores `pacientes`
--
DELIMITER $$
CREATE TRIGGER `asignar_historial` BEFORE INSERT ON `pacientes` FOR EACH ROW BEGIN
    DECLARE nuevoId INT;
    INSERT INTO Historial (fecha, descripcion)
    VALUES (NOW(), 'Historial inicial');
    SET nuevoId = LAST_INSERT_ID();
    SET NEW.idHistorial = nuevoId;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `idPromocion` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `idAdmin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`idPromocion`, `titulo`, `descripcion`, `duracion`, `imagen`, `idAdmin`) VALUES
(1, 'Quiropodia', 'Para tratar problemas en los pies, como callosidades, durezas, uñas encarnadas, y otras alteraciones', 30, '/imagenes/promociones/ervicio1.jpg', 1),
(2, 'Reconstrucciones ungueales', '', 15, '/imagenes/promociones/newsection3-640w.jpg', 1),
(3, 'Papilomas', '', 30, '/imagenes/promociones/servicio 3.jpg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idCita`),
  ADD KEY `idPacientes` (`idPacientes`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- Indices de la tabla `citas_promociones`
--
ALTER TABLE `citas_promociones`
  ADD PRIMARY KEY (`idCita`,`idPromocion`),
  ADD KEY `idPromocion` (`idPromocion`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`idHistorial`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`idPacientes`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD KEY `idHistorial` (`idHistorial`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`idPromocion`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idCita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `idHistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `idPacientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `idPromocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`idPacientes`) REFERENCES `pacientes` (`idPacientes`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`idAdmin`) REFERENCES `admin` (`idAdmin`);

--
-- Filtros para la tabla `citas_promociones`
--
ALTER TABLE `citas_promociones`
  ADD CONSTRAINT `citas_promociones_ibfk_1` FOREIGN KEY (`idCita`) REFERENCES `citas` (`idCita`),
  ADD CONSTRAINT `citas_promociones_ibfk_2` FOREIGN KEY (`idPromocion`) REFERENCES `promociones` (`idPromocion`);

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`idHistorial`) REFERENCES `historial` (`idHistorial`);

--
-- Filtros para la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD CONSTRAINT `promociones_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `admin` (`idAdmin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
