-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2025 a las 09:58:34
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
(10, '2025-05-15', '18:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(11, '2025-05-15', '09:30:00', 'Pendiente', NULL, 0, 0, 'kigq46on93dev7ggdeg8tk585k', 2, NULL, NULL),
(12, '2025-05-15', '12:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(13, '2025-05-15', '12:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(17, '2025-05-22', '09:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(18, '2025-05-22', '09:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(19, '2025-05-22', '10:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(20, '2025-05-22', '10:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(21, '2025-05-22', '11:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(22, '2025-05-22', '11:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(23, '2025-05-22', '12:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(24, '2025-05-22', '12:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(25, '2025-05-21', '16:00:00', 'Pendiente', NULL, 0, 0, 'nipfqqf9co9trsjjevcj2qgcak', 2, NULL, NULL),
(26, '2025-05-29', '18:30:00', 'Pendiente', NULL, 0, 0, 'defnivj810vckeed2fnsgtjfrg', 2, NULL, NULL),
(29, '0000-00-00', '09:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(30, '0000-00-00', '09:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(38, '2025-06-27', '09:00:00', 'Pendiente', NULL, 0, 0, 'rgjds5igh3kab9btkmkfmdg058', 2, NULL, NULL),
(39, '2025-06-18', '16:00:00', 'Pendiente', NULL, 0, 0, 'ueehbrg54u68kmnnl6n1mk829s', 11, NULL, NULL),
(40, '2025-06-17', '09:00:00', 'Pendiente', NULL, 0, 0, 'nek7uguu4uu7r42c5lgpougi4k', 11, NULL, NULL),
(41, '2025-06-17', '09:30:00', 'Pendiente', NULL, 0, 0, '916302ghi3ci7smlr0pgrme05c', 12, NULL, NULL),
(42, '2025-06-19', '09:00:00', 'Pendiente', NULL, 0, 0, 'm87p02ul8vh14b3rvbj3cmhqm0', 12, NULL, NULL),
(43, '2025-06-25', '09:00:00', 'Pendiente', NULL, 0, 0, 'r47qgnjsdkgc6glipa98jnsf58', 12, NULL, NULL),
(44, '2025-06-20', '09:00:00', 'Pendiente', NULL, 0, 0, 'ck9ghhi5fpog05m6vtvjpq5n1s', 2, NULL, NULL),
(45, '2025-06-17', '18:30:00', 'Pendiente', NULL, 0, 0, 'qmsiqjnriuvfqdnmpcj3uioukg', 2, NULL, NULL),
(46, '2025-06-18', '09:00:00', 'Pendiente', NULL, 0, 0, '01i5nlp502ilglj2imv6rhl9c0', 2, NULL, NULL),
(47, '2025-06-17', '10:00:00', 'pendiente', NULL, 0, 1, 'pa0cvfldi8uh1ths72kij6gt10', 13, 1, NULL),
(48, '2025-06-18', '17:00:00', 'pendiente', NULL, 0, 1, '9c1773d2up8bg4jklqt7nuhnbc', 14, 1, NULL),
(49, '2025-06-19', '12:30:00', 'pendiente', NULL, 0, 1, 'o80f49ov9spp6c3c9h5oninja8', 15, 1, NULL),
(50, '2025-06-16', '18:30:00', 'Pendiente', NULL, 0, 0, '52e7n394d862oo85vkj3kqqfg0', 2, NULL, NULL),
(51, '2025-06-23', '09:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(52, '2025-06-23', '09:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(53, '2025-06-23', '10:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(54, '2025-06-23', '10:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(55, '2025-06-23', '11:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(56, '2025-06-23', '11:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(57, '2025-06-23', '12:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(58, '2025-06-23', '12:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(59, '2025-06-23', '16:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(60, '2025-06-23', '16:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(61, '2025-06-23', '17:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(62, '2025-06-23', '17:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(63, '2025-06-23', '18:00:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL),
(64, '2025-06-23', '18:30:00', 'Bloqueada', NULL, 1, 0, NULL, NULL, 1, NULL);

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
(2, 'Historial inicial', NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-05-26'),
(3, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12'),
(4, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12'),
(11, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02'),
(12, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02'),
(13, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02'),
(14, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02'),
(15, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02'),
(16, 'Historial inicial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-02');

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
(1, 2, '2025-05-12', 'Uña encarnada', '', '', 0, 0, 0, 0, 0, '0', '0', '', 'validaciones/historialClinico/archivos/servicio 3.jpg'),
(2, 2, '2025-05-13', 'uña del pie', '', '', 0, 0, 0, 0, 0, '0', '0', '', 'validaciones/historialClinico/archivos/ervicio1.jpg'),
(3, 2, '2025-06-03', 'Cura de uña', '', '', 0, 0, 0, 0, 0, '0', '0', '', NULL);

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
(2, 'Daniel', 'Godoy', 'Medina', 'danielgodoymedina@gmail.com', '+34 628738528', '1989-07-22', 'H', '53368486E', '$2y$10$bEjqJvYfkMvq7V6GLI6cp.Qo7vnHmMV086W.0wSSX/i23WAoRXwBO', 'c27f083a08d5932b38640b3967deb386d7f9097ddf09a05e2afdcb174a3594fb', '2025-06-02 13:26:20', 2, 0, '53368486E'),
(3, 'Carlos', 'Castillo', NULL, 'carlos@calos.com', '+34 654676656', NULL, 'O', '23145634J', '$2y$10$GaUrWfmP.8zP/8/tuAu.suSUPAvFbckNaVT5b0yLnP5MWfM3hY5Oq', NULL, NULL, 3, 0, '23145634J'),
(4, 'Alberto', 'Castro', '', 'temporal_6822092e34d66@carmen.godoy', '+34 678546678', '1900-01-01', 'O', 'TEMP4b254176', '$2y$10$qbA/kOH7VWZhFCYcaO.w1ulQxdkftuHdI/4SRJzzoO5l88ZaxnjMG', NULL, NULL, 4, 1, NULL),
(11, 'Manuel', 'Jimenez', NULL, 'manu@manu.com', '+34 678987654', NULL, 'O', '51234567J', '$2y$10$sw58SPZBYZpw9j5mNAnW4uFMlU/u657oaQ9MLoz0CFLTCleix16tm', NULL, NULL, 11, 0, '51234567J'),
(12, 'Carlos', 'Ibañez', 'Garcia', 'ibanez@ibanez.com', '+34 678456345', NULL, 'O', '56712345L', '$2y$10$JkHVKA6ZKBdxCeNin2WlFuVk.z.zHamyQNVRIJ9OXuK3lsuBgarqC', NULL, NULL, 12, 0, '56712345L'),
(13, 'Clara', 'Moya', '', 'temporal_683d88d4f2e68@carmen.godoy', '+34 689325753', '1900-01-01', 'O', 'TEMPc3fa8459', '$2y$10$csCGTL1JEsAYYx3Kcz/H0.eGXcDn4Jj6U6Thn.ms7YxWPTGpKS4jS', NULL, NULL, 13, 1, NULL),
(14, 'Laura', 'Bueno', '', 'temporal_683d88f8dfec5@carmen.godoy', '+34 698547528', '1900-01-01', 'O', 'TEMPd00fa973', '$2y$10$Gh2cPuB1hsZZc87w.IhVROU5viaCBs6a0rsaqsb0YdezLqtyDVnWG', NULL, NULL, 14, 1, NULL),
(15, 'Marta', 'Merida', '', 'temporal_683d8933548b3@carmen.godoy', '+34 695847512', '1900-01-01', 'O', 'TEMP8d1b84aa', '$2y$10$M07iVB7CKAo3q7zfaBbgvuep7W1vFX0kT3cU4UkZPaqVqG6OOo1Aq', NULL, NULL, 15, 1, NULL),
(16, 'Prueba', 'Medina', NULL, 'ejemplo2@ejemplo.es', '+34 654123987', NULL, 'O', '54789632M', '$2y$10$z5/OVqj9phtRrNs1eo6J0.k6SXDmfNNMAzc466.FVfB0v4ksRY5de', NULL, NULL, 16, 0, '54789632M');

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
(1, 'Papiloma', '', 30, '/imagenes/promociones/servicio 3.jpg', 1),
(2, 'Eliminación de durezas', '', 30, '/imagenes/servicios/servicio4.jpg', 1),
(3, 'Uña incarnada', '', 15, '/imagenes/servicios/ervicio1.jpg', 1),
(4, 'Uñas engrosadas', '', 30, '/imagenes/servicios/ervicio1.jpg', 1);

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
  MODIFY `idCita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `idHistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `idInforme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `idPacientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `idPromocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
