-- Estimacion de la Base de datos para la clínica de podología

-- Tabla Tratamientos
CREATE TABLE Tratamientos (
    idTratamiento INT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(10, 2),
    fechaInicio DATE,
    fechaFin DATE,
    estado VARCHAR(50) -- Puede ser "Pendiente", "Confirmada", "Cancelada"
);

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
    telefono VARCHAR(15),
    fechaNacim DATE,
    sexo CHAR(1),
    dni VARCHAR(20) UNIQUE NOT NULL,
    pass VARCHAR(255),
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
    idPacientes INT,
    idAdmin INT,
    FOREIGN KEY (idPacientes) REFERENCES Pacientes(idPacientes),
    FOREIGN KEY (idAdmin) REFERENCES Admin(idAdmin)
);

-- Tabla Promociones
CREATE TABLE Promociones (
    idPromocion INT PRIMARY KEY AUTO_INCREMENT,
    descripcion TEXT,
    fechaInicio DATE,
    fechaFin DATE,
    descuento DECIMAL(5, 2),
    titulo VARCHAR(100),
    imagen VARCHAR(255),
    idAdmin INT,
    FOREIGN KEY (idAdmin) REFERENCES Admin(idAdmin)
);

-- Tabla Citas_Tratamientos
CREATE TABLE Citas_Tratamientos (
    idCita INT,
    idTratamiento INT,
    PRIMARY KEY (idCita, idTratamiento),
    FOREIGN KEY (idCita) REFERENCES Citas(idCita),
    FOREIGN KEY (idTratamiento) REFERENCES Tratamientos(idTratamiento)
);

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