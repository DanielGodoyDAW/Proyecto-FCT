-- Archivo de ejemplo: clinica_podologia.sql
-- TODOS LOS DATOS SON FICTICIOS Y DE EJEMPLO

-- Tabla admin
CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) DEFAULT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin` (`nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `pass`) VALUES
('Ana',   'Martinez',  'Lopez',    'ana.martinez@ejemplo.com',   '600000001', '$2y$10$fakeadminhash1');


-- Tabla historial
CREATE TABLE `historial` (
  `idHistorial` int(11) NOT NULL AUTO_INCREMENT,
  `fichaComentarioInicial` text DEFAULT NULL,
  `antec_podologicos` text DEFAULT NULL,
  `antec_quirurgicos` text DEFAULT NULL,
  `patologias` text DEFAULT NULL,
  `antecedentes` varchar(255) DEFAULT NULL,
  `alergias` varchar(255) DEFAULT NULL,
  `farmacologia` varchar(255) DEFAULT NULL,
  `desarrolloPSi` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`idHistorial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `historial` (`fichaComentarioInicial`, `fecha`)
VALUES
('Historial inicial', '2025-05-12'),
('Historial inicial', '2025-06-01');

-- Tabla pacientes
CREATE TABLE `pacientes` (
  `idPacientes` int(11) NOT NULL AUTO_INCREMENT,
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
  `dni_original` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idPacientes`),
  UNIQUE KEY `dni` (`dni`),
  KEY `idHistorial` (`idHistorial`),
  FOREIGN KEY (`idHistorial`) REFERENCES `historial` (`idHistorial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pacientes` (`nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fechaNacim`, `sexo`, `dni`, `pass`, `idHistorial`)
VALUES
('Juan',     'Perez',      'Santos',   'juan.perez@ejemplo.com',   '700000001', '1990-01-15', 'H', 'X0000000A', '$2y$10$fakepachash1', 1),
('Maria',    'Ruiz',       'Diaz',     'maria.ruiz@ejemplo.com',   '700000002', '1986-07-04', 'M', 'X0000000B', '$2y$10$fakepachash2', 2);

-- Tabla citas
CREATE TABLE `citas` (
  `idCita` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `anotaciones` text DEFAULT NULL,
  `bloqueada` tinyint(1) NOT NULL DEFAULT 0,
  `confirmada` tinyint(1) NOT NULL DEFAULT 0,
  `google_event_id` varchar(255) DEFAULT NULL,
  `idPacientes` int(11) DEFAULT NULL,
  `idAdmin` int(11) DEFAULT NULL,
  `payment_intent_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idCita`),
  KEY `idPacientes` (`idPacientes`),
  KEY `idAdmin` (`idAdmin`),
  FOREIGN KEY (`idPacientes`) REFERENCES `pacientes` (`idPacientes`),
  FOREIGN KEY (`idAdmin`) REFERENCES `admin` (`idAdmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `citas` (`fecha`, `hora`, `estado`, `anotaciones`, `bloqueada`, `confirmada`, `google_event_id`, `idPacientes`, `idAdmin`)
VALUES
('2025-06-10', '10:00:00', 'Pendiente', 'Primera consulta', 0, 1, 'fakeeventid1', 1, 1),
('2025-06-15', '11:00:00', 'Confirmada', '', 0, 1, 'fakeeventid2', 2, 2);

-- Tabla informe
CREATE TABLE `informe` (
  `idInforme` int(11) NOT NULL AUTO_INCREMENT,
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
  `archivo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idInforme`),
  KEY `idHistorial` (`idHistorial`),
  FOREIGN KEY (`idHistorial`) REFERENCES `historial` (`idHistorial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `informe` (`idHistorial`, `fecha`, `motivo`)
VALUES
(1, '2025-06-10', 'Consulta general'),
(2, '2025-06-15', 'Dolor leve en paciente');

-- Tabla promociones
CREATE TABLE `promociones` (
  `idPromocion` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `idAdmin` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPromocion`),
  KEY `idAdmin` (`idAdmin`),
  FOREIGN KEY (`idAdmin`) REFERENCES `admin` (`idAdmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `promociones` (`titulo`, `descripcion`, `duracion`, `imagen`, `idAdmin`)
VALUES
('Chequeo dermatológico', 'Chequeo completo de la piel del pie', 25, '/imagenes/promociones/dermato.jpg', 1),
('Higiene podal', 'Limpieza básica y recomendaciones', 20, '/imagenes/promociones/higiene.jpg', 2);

-- Tabla citas_promociones
CREATE TABLE `citas_promociones` (
  `idCita` int(11) NOT NULL,
  `idPromocion` int(11) NOT NULL,
  PRIMARY KEY (`idCita`,`idPromocion`),
  KEY `idPromocion` (`idPromocion`),
  FOREIGN KEY (`idCita`) REFERENCES `citas` (`idCita`),
  FOREIGN KEY (`idPromocion`) REFERENCES `promociones` (`idPromocion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `citas_promociones` (`idCita`, `idPromocion`) VALUES
(1, 1),
(2, 2);

-- TRIGGER de ejemplo: crea historial automáticamente (opcional, puede variar según motor)
DELIMITER $$
CREATE TRIGGER `asignar_historial` BEFORE INSERT ON `pacientes`
FOR EACH ROW
BEGIN
  DECLARE nuevoId INT;
  INSERT INTO `historial` (`fecha`, `fichaComentarioInicial`)
  VALUES (NOW(), 'Historial inicial');
  SET nuevoId = LAST_INSERT_ID();
  SET NEW.idHistorial = nuevoId;
END $$
DELIMITER ;
