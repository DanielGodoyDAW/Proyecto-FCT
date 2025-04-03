-- Estimacion de la Base de datos para la clínica de podología

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
    pass VARCHAR(255)
);

-- Tabla Tratamientos
CREATE TABLE Tratamientos (
    idTratamiento INT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(10, 2),
    fechaInicio DATE,
    fechaFin DATE,
    estado VARCHAR(50)
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

-- Tabla Promociones
CREATE TABLE Promociones (
    idPromocion INT PRIMARY KEY,
    descripcion TEXT,
    fechaInicio DATE,
    fechaFin DATE,
    descuento DECIMAL(5, 2),
    titulo VARCHAR(100),
    imagen VARCHAR(255)
);

-- Tabla Citas
CREATE TABLE Citas (
    idCita INT PRIMARY KEY,
    fecha DATE,
    hora TIME,
    idPacientes INT,
    estado VARCHAR(50),
    idTratamiento INT,
    anotaciones TEXT,
    FOREIGN KEY (idPacientes) REFERENCES Pacientes(idPacientes),
    FOREIGN KEY (idTratamiento) REFERENCES Tratamientos(idTratamiento)
);

-- Tabla Historial
CREATE TABLE Historial (
    idHistorial INT PRIMARY KEY,
    idPacientes INT,
    fecha DATE,
    descripcion TEXT,
    FOREIGN KEY (idPacientes) REFERENCES Pacientes(idPacientes)
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

-- INSERTAR ADMIN Carmen Godoy

INSERT INTO Admin (idAdmin, nombre, apellido1, apellido2, email, telefono, pass)
VALUES (1, 'Carmen', 'Godoy', 'Medina', 'carmen.godoy@example.com', '643645579', '12345678A');

-- INSERTAR PACIENTE
INSERT INTO Pacientes ( nombre, apellido1, apellido2, email, telefono, fechaNacim, sexo, dni, pass)
VALUES ('Daniel', 'Godoy', 'Medina', 'danielgodoymedina@gmail.com','628738526', '1989-07-22', 'M', '53368486E', '12345678A');