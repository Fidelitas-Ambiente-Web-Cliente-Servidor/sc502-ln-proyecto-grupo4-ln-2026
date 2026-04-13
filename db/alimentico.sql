USE appdb;

CREATE TABLE rolProyecto (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL
);

CREATE TABLE usuarioProyecto (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol) REFERENCES rolProyecto(id_rol)
);

CREATE TABLE restauranteProyecto (
    id_restaurante INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    nombre_negocio VARCHAR(100) NOT NULL,
    tipo_establecimiento VARCHAR(50),
    cedula_juridica VARCHAR(20),
    telefono VARCHAR(15),
    provincia VARCHAR(50),
    canton VARCHAR(50),
    distrito VARCHAR(50),
    direccion_exacta TEXT,
    link_maps VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES usuarioProyecto(id_usuario)
);

CREATE TABLE horarioProyecto (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_restaurante INT NOT NULL,
    dia ENUM('lunes','martes','miercoles','jueves','viernes','sabado','domingo') NOT NULL,
    activo BOOLEAN DEFAULT FALSE,
    hora_apertura TIME,
    hora_cierre TIME,
    FOREIGN KEY (id_restaurante) REFERENCES restauranteProyecto(id_restaurante)
);

CREATE TABLE beneficiarioProyecto (
    id_beneficiario INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    nombre_completo VARCHAR(100) NOT NULL,
    cedula_identidad VARCHAR(20),
    telefono VARCHAR(15),
    provincia VARCHAR(50),
    canton VARCHAR(50),
    direccion TEXT,
    fecha_nacimiento DATE,
    FOREIGN KEY (id_usuario) REFERENCES usuarioProyecto(id_usuario)
);

CREATE TABLE donacionProyecto (
    id_donacion INT AUTO_INCREMENT PRIMARY KEY,
    id_restaurante INT NOT NULL,
    tipo_alimento ENUM('Comida Preparada','Panaderia','Frutas','Verduras','Lacteos','Otro') NOT NULL,
    nombre_descripcion VARCHAR(150) NOT NULL,
    cantidad VARCHAR(50),
    descripcion_adicional TEXT,
    informacion_importante TEXT,
    fecha_disponible DATE NOT NULL,
    hora_limite TIME NOT NULL,
    estado ENUM('disponible','reservado','agotado') DEFAULT 'disponible',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_restaurante) REFERENCES restauranteProyecto(id_restaurante)
);

CREATE TABLE reservaProyecto (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_donacion INT NOT NULL,
    id_beneficiario INT NOT NULL,
    codigo_reserva VARCHAR(20) NOT NULL UNIQUE,
    estado ENUM('activa','confirmada','cancelada') DEFAULT 'activa',
    fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_donacion) REFERENCES donacionProyecto(id_donacion),
    FOREIGN KEY (id_beneficiario) REFERENCES beneficiarioProyecto(id_beneficiario)
);

CREATE TABLE notificacionProyecto (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarioProyecto(id_usuario)
);