-- Estimacion de la Base de datos para la clínica de podología

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
    fichaComentarioInicial TEXT,
    antec_podologicos TEXT,
    antec_quirurgicos TEXT,
    patologias TEXT,
    antecedentes VARCHAR(255),
    alergias VARCHAR(255),
    farmacologia VARCHAR(255),
    desarrolloPSi VARCHAR(255),
    fecha DATE NOT NULL DEFAULT CURRENT_DATE
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
    INSERT INTO Historial (fecha, fichaComentarioInicial)
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

-- Tabla Citas_Promociones
CREATE TABLE Citas_Promociones (
    idCita INT,
    idPromocion INT,
    PRIMARY KEY (idCita, idPromocion),
    FOREIGN KEY (idCita) REFERENCES Citas(idCita),
    FOREIGN KEY (idPromocion) REFERENCES Promociones(idPromocion)
);

CREATE TABLE Informe (
    idInforme INT PRIMARY KEY AUTO_INCREMENT,
    idHistorial INT NOT NULL,
    fecha DATE NOT NULL,
    motivo TEXT,
    descripcion TEXT,
    observaciones TEXT,
    onicopatias TINYINT(1) DEFAULT 0,
    queratopatias TINYINT(1) DEFAULT 0,
    dermatopatias TINYINT(1) DEFAULT 0,
    prominenciasOseas TINYINT(1) DEFAULT 0,
    altDigitales TINYINT(1) DEFAULT 0,
    dx TEXT,
    tratamiento TEXT,
    receta TEXT,
    archivo VARCHAR(255),
    FOREIGN KEY (idHistorial) REFERENCES Historial(idHistorial)
);

-- Insertar ADMIN 
INSERT INTO Admin (idAdmin, nombre, apellido1, apellido2, email, telefono, pass)
VALUES (1, 'Carmen', 'Godoy', 'Medina', 'carmengodoypodologia@gmail.com', '+34 643645579', '$2y$10$kFSxdLZGwlL9CwjvZ.dLce/LwI6WLxVHLuyBNlTV/0vc550Y7InFe');

-- Insertar paciente (automáticamente se le crea un historial)
INSERT INTO Pacientes (nombre, apellido1, apellido2, email, telefono, fechaNacim, sexo, dni, pass)
VALUES ('Carmen', 'Godoy', 'Medina', 'carmengodoypodologia@gmail.com', '+34 643645579', '1999-04-06', 'M', '53896466Z', '$2y$10$kFSxdLZGwlL9CwjvZ.dLce/LwI6WLxVHLuyBNlTV/0vc550Y7InFe');

-- Insertar otro paciente
INSERT INTO Pacientes (nombre, apellido1, apellido2, email, telefono, fechaNacim, sexo, dni, pass)
VALUES ('Daniel', 'Godoy', 'Medina', 'danielgodoymedina@gmail.com','+34 628738526', '1989-07-22', 'H', '53368486E', '$2y$10$Ytv6cH.5Hp4PfdeXxgvFfucJ3s3BwPtmkt1EFSWFnB3evsreg6sQu');

ALTER TABLE Citas ADD COLUMN payment_intent_id VARCHAR(255) NULL;

ALTER TABLE Pacientes ADD COLUMN es_temporal TINYINT(1) DEFAULT 0;

ALTER TABLE Pacientes ADD COLUMN dni_original VARCHAR(20) DEFAULT NULL;
