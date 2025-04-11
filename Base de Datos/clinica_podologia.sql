-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-04-2025 a las 11:53:37
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
  `idPacientes` int(11) DEFAULT NULL,
  `idAdmin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idCita`, `fecha`, `hora`, `estado`, `anotaciones`, `idPacientes`, `idAdmin`) VALUES
(2, '2025-04-09', '09:00:00', 'Pendiente', NULL, 8, 1),
(3, '2025-04-01', '09:00:00', 'Pendiente', NULL, 8, 1),
(4, '2025-04-17', '10:00:00', 'Pendiente', NULL, 8, 1);

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
-- Estructura de tabla para la tabla `citas_tratamientos`
--

CREATE TABLE `citas_tratamientos` (
  `idCita` int(11) NOT NULL,
  `idTratamiento` int(11) NOT NULL
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
  `telefono` varchar(15) DEFAULT NULL,
  `fechaNacim` date DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `dni` varchar(20) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `idHistorial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`idPacientes`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fechaNacim`, `sexo`, `dni`, `pass`, `idHistorial`) VALUES
(7, 'Daniel', 'Godoy', 'Medina', 'danielgodoymedina@gmail.com', '+34 628 738 526', '1989-07-22', 'H', '53368486E', '$2y$10$Ytv6cH.5Hp4PfdeXxgvFfucJ3s3BwPtmkt1EFSWFnB3evsreg6sQu', NULL),
(8, 'Alberto', 'Garcia', '', 'hoja@hola.com', '+66 666 666 666', '2025-04-01', 'H', '1111111A', '$2y$10$M.r7zxuvkx0ABDTT32PESOPVpEu28AohEt.55SgOOOErThIyd/QZa', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `idPromocion` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `idAdmin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `idTratamiento` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indices de la tabla `citas_tratamientos`
--
ALTER TABLE `citas_tratamientos`
  ADD PRIMARY KEY (`idCita`,`idTratamiento`),
  ADD KEY `idTratamiento` (`idTratamiento`);

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
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`idTratamiento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idCita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `idHistorial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `idPacientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `idPromocion` int(11) NOT NULL AUTO_INCREMENT;

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
-- Filtros para la tabla `citas_tratamientos`
--
ALTER TABLE `citas_tratamientos`
  ADD CONSTRAINT `citas_tratamientos_ibfk_1` FOREIGN KEY (`idCita`) REFERENCES `citas` (`idCita`),
  ADD CONSTRAINT `citas_tratamientos_ibfk_2` FOREIGN KEY (`idTratamiento`) REFERENCES `tratamientos` (`idTratamiento`);

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
