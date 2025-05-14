-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2025 a las 11:27:26
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
(1, 'Carmen', 'Godoy', 'Medina', 'carmengodoypodologia@gmail.com', '+34 643645579', '$2y$10$kFSxdLZGwlL9CwjvZ.dLce/LwI6WLxVHLuyBNlTV/0vc550Y7InFe');

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
  `google_event_id` varchar(255) DEFAULT NULL,
  `idPacientes` int(11) DEFAULT NULL,
  `idAdmin` int(11) DEFAULT NULL,
  `payment_intent_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idCita`, `fecha`, `hora`, `estado`, `anotaciones`, `bloqueada`, `confirmada`, `google_event_id`, `idPacientes`, `idAdmin`, `payment_intent_id`) VALUES
(1, '2025-05-15', '09:00:00', 'pendiente', NULL, 0, 1, 'bmf4eg35p23r2ulj77fpl321vk', 4, 1, NULL),
(4, '2025-05-14', '12:30:00', 'Pendiente', NULL, 0, 0, '1ks4v06mvb8kbe4oj661q3ssvg', 2, NULL, NULL),
(5, '2025-05-15', '16:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(6, '2025-05-15', '16:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(7, '2025-05-15', '17:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(8, '2025-05-15', '17:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(9, '2025-05-15', '18:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(10, '2025-05-15', '18:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL);

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
  `fichaComentarioInicial` text DEFAULT NULL,
  `antec_podologicos` text DEFAULT NULL,
  `antec_quirurgicos` text DEFAULT NULL,
  `patologias` text DEFAULT NULL,
  `antecedentes` varchar(255) DEFAULT NULL,
  `alergias` varchar(255) DEFAULT NULL,
  `farmacologia` varchar(255) DEFAULT NULL,
  `desarrolloPSi` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`idHistorial`, `fichaComentarioInicial`, `antec_podologicos`, `antec_quirurgicos`, `patologias`, `antecedentes`, `alergias`, `farmacologia`, `desarrolloPSi`, `fecha`) VALUES
(1, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12'),
(2, 'Historial inicial', NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-05-12'),
(3, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12'),
(4, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

CREATE TABLE `informe` (
  `idInforme` int(11) NOT NULL,
  `idHistorial` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `motivo` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `onicopatias` tinyint(1) DEFAULT 0,
  `queratopatias` tinyint(1) DEFAULT 0,
  `dermatopatias` tinyint(1) DEFAULT 0,
  `prominenciasOseas` tinyint(1) DEFAULT 0,
  `altDigitales` tinyint(1) DEFAULT 0,
  `dx` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `receta` text DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informe`
--

INSERT INTO `informe` (`idInforme`, `idHistorial`, `fecha`, `motivo`, `descripcion`, `observaciones`, `onicopatias`, `queratopatias`, `dermatopatias`, `prominenciasOseas`, `altDigitales`, `dx`, `tratamiento`, `receta`, `archivo`) VALUES
(1, 2, '2025-05-12', 'prueba', '', '', 0, 0, 0, 0, 0, '0', '0', '', '/Codigo/validaciones/historialClinico/archivos/servicio 3.jpg'),
(2, 2, '2025-05-13', 'uña del pie', '', '', 0, 0, 0, 0, 0, '0', '0', '', '/Codigo/validaciones/historialClinico/archivos/ervicio1.jpg');

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
  `idHistorial` int(11) NOT NULL,
  `es_temporal` tinyint(1) DEFAULT 0,
  `dni_original` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`idPacientes`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fechaNacim`, `sexo`, `dni`, `pass`, `token_recuperacion`, `token_expira`, `idHistorial`, `es_temporal`, `dni_original`) VALUES
(1, 'Carmen', 'Godoy', 'Medina', 'carmengodoypodologia@gmail.com', '+34 643645579', '1999-04-06', 'M', '53896466Z', '$2y$10$kFSxdLZGwlL9CwjvZ.dLce/LwI6WLxVHLuyBNlTV/0vc550Y7InFe', NULL, NULL, 1, 0, '53896466Z'),
(2, 'Daniel', 'Godoy', 'Medina', 'danielgodoymedina@gmail.com', '+34 628738526', '1989-07-22', 'H', '53368486E', '$2y$10$Ytv6cH.5Hp4PfdeXxgvFfucJ3s3BwPtmkt1EFSWFnB3evsreg6sQu', NULL, NULL, 2, 0, '53368486E'),
(3, 'Carlos', 'Castillo', NULL, 'carlos@calos.com', '+34 654676656', NULL, 'O', '23145634J', '$2y$10$GaUrWfmP.8zP/8/tuAu.suSUPAvFbckNaVT5b0yLnP5MWfM3hY5Oq', NULL, NULL, 3, 0, '23145634J'),
(4, 'Alberto', 'Castro', '', 'temporal_6822092e34d66@carmen.godoy', '+34 678546678', '1900-01-01', 'O', 'TEMP4b254176', '$2y$10$qbA/kOH7VWZhFCYcaO.w1ulQxdkftuHdI/4SRJzzoO5l88ZaxnjMG', NULL, NULL, 4, 1, NULL);

--
-- Disparadores `pacientes`
--
DELIMITER $$
CREATE TRIGGER `asignar_historial` BEFORE INSERT ON `pacientes` FOR EACH ROW BEGIN
    DECLARE nuevoId INT;
    INSERT INTO Historial (fecha, fichaComentarioInicial)
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
(1, 'Papiloma', '', 30, '/imagenes/promociones/servicio 3.jpg', 1);

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
-- Indices de la tabla `informe`
--
ALTER TABLE `informe`
  ADD PRIMARY KEY (`idInforme`),
  ADD KEY `idHistorial` (`idHistorial`);

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
  MODIFY `idCita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `idHistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `idInforme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `idPacientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `idPromocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Filtros para la tabla `informe`
--
ALTER TABLE `informe`
  ADD CONSTRAINT `informe_ibfk_1` FOREIGN KEY (`idHistorial`) REFERENCES `historial` (`idHistorial`);

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
