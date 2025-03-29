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

-- Tabla Pacientes
CREATE TABLE Pacientes (
    idPacientes INT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido1 VARCHAR(50),
    apellido2 VARCHAR(50),
    email VARCHAR(100),
    telefono VARCHAR(15),
    fechaNacim DATE,
    sexo CHAR(1),
    dni VARCHAR(20)
);

-- Tabla Admin
CREATE TABLE Admin (
    idAdmin INT PRIMARY KEY,
    nombre VARCHAR(50),
    email VARCHAR(100),
    telefono VARCHAR(15)
);

-- Tabla Promociones
CREATE TABLE Promociones (
    idPromocion INT PRIMARY KEY,
    descripcion TEXT,
    fechaInicio DATE,
    fechaFin DATE,
    descuento DECIMAL(5, 2)
);

-- Tabla Tratamientos
CREATE TABLE Tratamientos (
    idTratamiento INT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(10, 2),
    duracion INT
);

-- Tabla Historial
CREATE TABLE Historial (
    idHistorial INT PRIMARY KEY,
    idPacientes INT,
    fecha DATE,
    descripcion TEXT,
    FOREIGN KEY (idPacientes) REFERENCES Pacientes(idPacientes)
);