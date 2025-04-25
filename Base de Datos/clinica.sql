-- Estimacion de la Base de datos para la clínica de podología

-- Tabla Tratamientos esta tabla no hara falta
-- CREATE TABLE Tratamientos (
--     idTratamiento INT PRIMARY KEY,
--     nombre VARCHAR(100),
--     descripcion TEXT,
--     precio DECIMAL(10, 2),
--     fechaInicio DATE,
--     fechaFin DATE,
--     estado VARCHAR(50) -- Puede ser "Pendiente", "Confirmada", "Cancelada"
-- );

-- Tabla Admin
CREATE TABLE Admin (
    idAdmin INT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido1 VARCHAR(50),
    apellido2 VARCHAR(50),
    email VARCHAR(100),
    telefono VARCHAR(15),
    pass VARCHAR(255)
);

-- Tabla Historial
CREATE TABLE Historial (
    idHistorial INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    descripcion TEXT
);

-- Tabla Pacientes
CREATE TABLE Pacientes (
    idPacientes INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    apellido1 VARCHAR(50),
    apellido2 VARCHAR(50),
    email VARCHAR(100),
    telefono VARCHAR(30),
    fechaNacim DATE,
    sexo CHAR(1),
    dni VARCHAR(20) UNIQUE NOT NULL,
    pass VARCHAR(255),
    token_recuperacion VARCHAR(64) DEFAULT NULL,
    token_expira DATETIME DEFAULT NULL,
    idHistorial INT NOT NULL,
    FOREIGN KEY (idHistorial) REFERENCES Historial(idHistorial)
);

-- Crear Trigger para generar historial automáticamente al insertar paciente
DELIMITER $$

CREATE TRIGGER asignar_historial
BEFORE INSERT ON Pacientes
FOR EACH ROW
BEGIN
    DECLARE nuevoId INT;
    INSERT INTO Historial (fecha, descripcion)
    VALUES (NOW(), 'Historial inicial');
    SET nuevoId = LAST_INSERT_ID();
    SET NEW.idHistorial = nuevoId;
END$$

DELIMITER ;

-- Tabla Citas
CREATE TABLE Citas (
    idCita INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    hora TIME,
    estado VARCHAR(50),
    anotaciones TEXT,
    bloqueada TINYINT(1) NOT NULL DEFAULT 0,
    confirmada TINYINT(1) NOT NULL DEFAULT 0,
    google_event_id VARCHAR(255) NULL,
    idPacientes INT,
    idAdmin INT,
    FOREIGN KEY (idPacientes) REFERENCES Pacientes(idPacientes),
    FOREIGN KEY (idAdmin) REFERENCES Admin(idAdmin)
);

CREATE TABLE Promociones (
    idPromocion INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100),
    descripcion TEXT,
    duracion INT, -- Duración en minutos
    imagen VARCHAR(255),
    idAdmin INT,
    FOREIGN KEY (idAdmin) REFERENCES Admin(idAdmin)
);
-- Tabla Promociones
-- CREATE TABLE Promociones (
--     idPromocion INT PRIMARY KEY AUTO_INCREMENT,
--     descripcion TEXT,
--     fechaInicio DATE,
--     fechaFin DATE,
--     descuento DECIMAL(5, 2),
--     titulo VARCHAR(100),
--     imagen VARCHAR(255),
--     idAdmin INT,
--     FOREIGN KEY (idAdmin) REFERENCES Admin(idAdmin)
-- );

-- Tabla Citas_Tratamientos
-- CREATE TABLE Citas_Tratamientos (
--     idCita INT,
--     idTratamiento INT,
--     PRIMARY KEY (idCita, idTratamiento),
--     FOREIGN KEY (idCita) REFERENCES Citas(idCita),
--     FOREIGN KEY (idTratamiento) REFERENCES Tratamientos(idTratamiento)
-- );

-- Tabla Citas_Promociones
CREATE TABLE Citas_Promociones (
    idCita INT,
    idPromocion INT,
    PRIMARY KEY (idCita, idPromocion),
    FOREIGN KEY (idCita) REFERENCES Citas(idCita),
    FOREIGN KEY (idPromocion) REFERENCES Promociones(idPromocion)
);

-- Insertar ADMIN 
INSERT INTO Admin (idAdmin, nombre, apellido1, apellido2, email, telefono, pass)
VALUES (1, 'Carmen', 'Godoy', 'Medina', 'carmengodoypodologia@gmail.com', '643645579', '$2y$10$kFSxdLZGwlL9CwjvZ.dLce/LwI6WLxVHLuyBNlTV/0vc550Y7InFe');

-- Insertar paciente (automáticamente se le crea un historial)
INSERT INTO Pacientes (nombre, apellido1, apellido2, email, telefono, fechaNacim, sexo, dni, pass)
VALUES ('Carmen', 'Godoy', 'Medina', 'carmengodoypodologia@gmail.com', '643645579', '1999-04-06', 'M', '00000000A', '$2y$10$kFSxdLZGwlL9CwjvZ.dLce/LwI6WLxVHLuyBNlTV/0vc550Y7InFe');

-- Insertar otro paciente
INSERT INTO Pacientes (nombre, apellido1, apellido2, email, telefono, fechaNacim, sexo, dni, pass)
VALUES ('Daniel', 'Godoy', 'Medina', 'danielgodoymedina@gmail.com','628738526', '1989-07-22', 'H', '53368486E', '$2y$10$Ytv6cH.5Hp4PfdeXxgvFfucJ3s3BwPtmkt1EFSWFnB3evsreg6sQu');

--pensamiento de implementar estos cambios
-- CREATE TABLE Plantillas(
--     idPlantilla INT PRIMARY KEY AUTO_INCREMENT,
--     titulo VARCHAR(100) NOT NULL,
--     contenido TEXT NOT NULL,
--     idAdmin INT,
--     FOREIGN KEY (idAdmin) REFERENCES Admin(idAdmin)
-- );

-- ALTER TABLE `Historial`
-- ADD COLUMN `idPlantilla` INT DEFAULT NULL,
-- ADD CONSTRAINT `historial_ibfk_plantilla` FOREIGN KEY (`idPlantilla`) REFERENCES `Plantillas` (`idPlantilla`) ON DELETE SET NULL;

-- Tabla Historial
-- CREATE TABLE Historial (
--     idHistorial INT PRIMARY KEY AUTO_INCREMENT,
--     fecha DATE,
--     descripcion TEXT,
--     idPlantilla INT DEFAULT NULL,
--     FOREIGN KEY (idPlantilla) REFERENCES Plantillas_historial(idPlantilla)
-- );

-- Tabla patologias
CREATE TABLE Patologias(
    idPatologias INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    idHistorial INT
    FOREIGN KEY (idHistorial) REFERENCES Historial(idHistorial)
);

-- Tabla seguimiento
CREATE TABLE Seguimiento(
    idSeguimiento INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    descripcion TEXT,
    idHistorial INT,
    FOREIGN KEY (idHistorial) REFERENCES Historial(idHistorial)
);

-- Alter Tabla historial 
ALTER TABLE
    `Historial`
ADD
    COLUMN motivo TEXT,
ADD
    COLUMN antec_podologicos TEXT,
ADD
    COLUMN antec_quirurgicos TEXT,
ADD
    COLUMN antecedentes VARCHAR(255),
ADD
    COLUMN alergias VARCHAR(255),
ADD
    COLUMN farmacologia VARCHAR(255),
ADD
    COLUMN desarrolloPSi VARCHAR(255),
ADD
    COLUMN observaciones TEXT,
ADD
    COLUMN archivo VARCHAR(255),
ADD
    COLUMN onicopatias TINYINT(1) DEFAULT 0,
ADD
    COLUMN queratopatias TINYINT(1) DEFAULT 0,
ADD
    COLUMN dermatopatias TINYINT(1) DEFAULT 0,
ADD
    COLUMN prominenciasOseas TINYINT(1) DEFAULT 0,
ADD
    COLUMN altDigitales TINYINT(1) DEFAULT 0,
ADD
    COLUMN receta TEXT,
ADD
    COLUMN seguimiento TEXT;


ALTER TABLE Citas ADD COLUMN payment_intent_id VARCHAR(255) NULL;