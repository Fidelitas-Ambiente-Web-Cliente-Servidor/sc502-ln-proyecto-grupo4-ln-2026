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

ALTER TABLE usuarioProyecto 
ADD COLUMN token_recuperacion VARCHAR(64) NULL,
ADD COLUMN token_expira DATETIME NULL;

-- Roles
INSERT INTO rolProyecto (id_rol, nombre) VALUES
(1, 'admin'),
(2, 'restaurante'),
(3, 'beneficiario');

-- (password: 12345)
INSERT INTO usuarioProyecto (id_usuario, id_rol, correo, contrasena) VALUES
(1, 1, 'admin@alimentico.com', '$2y$10$0wkl2VjqQFNw2X5e.f3Lj.fliI7Etwk8r7bNW.OkqtGi31E8M6nRC'),
(2, 2, 'restaurante@alimentico.com', '$2y$10$0wkl2VjqQFNw2X5e.f3Lj.fliI7Etwk8r7bNW.OkqtGi31E8M6nRC'),
(3, 3, 'beneficiario@alimentico.com', '$2y$10$0wkl2VjqQFNw2X5e.f3Lj.fliI7Etwk8r7bNW.OkqtGi31E8M6nRC');
(4, 2, 'sabortico@alimentico.com',     '$2y$10$0wkl2VjqQFNw2X5e.f3Lj.fliI7Etwk8r7bNW.OkqtGi31E8M6nRC'),
(5, 2, 'casitaheredia@alimentico.com', '$2y$10$0wkl2VjqQFNw2X5e.f3Lj.fliI7Etwk8r7bNW.OkqtGi31E8M6nRC'),
(6, 3, 'maria.gonzalez@alimentico.com','$2y$10$0wkl2VjqQFNw2X5e.f3Lj.fliI7Etwk8r7bNW.OkqtGi31E8M6nRC'),
(7, 3, 'carlos.vargas@alimentico.com', '$2y$10$0wkl2VjqQFNw2X5e.f3Lj.fliI7Etwk8r7bNW.OkqtGi31E8M6nRC');

-- Perfil restaurante de prueba
INSERT INTO restauranteProyecto (id_usuario, nombre_negocio, tipo_establecimiento, cedula_juridica, telefono, provincia, canton, distrito, direccion_exacta)
VALUES (2, 'La Esquina', 'Restaurante', '3-101-123456', '22221111', 'San José', 'San José', 'Carmen', 'Frente al parque central');
(4, 'Sabor Tico', 'Soda', '3-101-654321', '22334455', 'Alajuela', 'Alajuela', 'Central', '100m norte del Mercado Central de Alajuela', 'https://maps.google.com/?q=Mercado+Central+Alajuela'),
(5, 'La Casita de Heredia', 'Restaurante', '3-102-789456', '22876543', 'Heredia', 'Heredia', 'Mercedes', 'Frente al COOP de Mercedes Norte, Heredia', 'https://maps.google.com/?q=Mercedes+Norte+Heredia');


-- Perfil beneficiario de prueba 
INSERT INTO beneficiarioProyecto (id_usuario, nombre_completo, cedula_identidad, telefono, provincia, canton)
VALUES (3, 'Juan Pérez', '1-1234-5678', '88881111', 'San José', 'Desamparados');
(6, 'María González Rojas',  '1-0987-6543', '87654321', 'San José',  'Curridabat',   'Residencial Los Pinos, casa 12, Curridabat',      '1978-03-15'),
(7, 'Carlos Vargas Méndez',  '2-1122-3344', '86543210', 'Alajuela',  'San Carlos',   'Barrio El Carmen, 200m sur de la iglesia católica', '1965-07-22');


-- HORARIOS (restaurante 1 = La Esquina, id_restaurante=1)
INSERT INTO horarioProyecto (id_restaurante, dia, activo, hora_apertura, hora_cierre) VALUES
(1, 'lunes',     TRUE,  '08:00:00', '20:00:00'),
(1, 'martes',    TRUE,  '08:00:00', '20:00:00'),
(1, 'miercoles', TRUE,  '08:00:00', '20:00:00'),
(1, 'jueves',    TRUE,  '08:00:00', '20:00:00'),
(1, 'viernes',   TRUE,  '08:00:00', '21:00:00'),
(1, 'sabado',    TRUE,  '09:00:00', '21:00:00'),
(1, 'domingo',   FALSE, NULL,        NULL),

-- HORARIOS (restaurante 2 = Sabor Tico, id_restaurante=2)
(2, 'lunes',     TRUE,  '07:00:00', '18:00:00'),
(2, 'martes',    TRUE,  '07:00:00', '18:00:00'),
(2, 'miercoles', TRUE,  '07:00:00', '18:00:00'),
(2, 'jueves',    TRUE,  '07:00:00', '18:00:00'),
(2, 'viernes',   TRUE,  '07:00:00', '19:00:00'),
(2, 'sabado',    FALSE, NULL,        NULL),
(2, 'domingo',   FALSE, NULL,        NULL),

-- HORARIOS (restaurante 3 = La Casita de Heredia, id_restaurante=3)
(3, 'lunes',     TRUE,  '10:00:00', '22:00:00'),
(3, 'martes',    TRUE,  '10:00:00', '22:00:00'),
(3, 'miercoles', TRUE,  '10:00:00', '22:00:00'),
(3, 'jueves',    TRUE,  '10:00:00', '22:00:00'),
(3, 'viernes',   TRUE,  '10:00:00', '23:00:00'),
(3, 'sabado',    TRUE,  '11:00:00', '23:00:00'),
(3, 'domingo',   TRUE,  '11:00:00', '20:00:00');

INSERT INTO donacionProyecto (id_restaurante, tipo_alimento, nombre_descripcion, cantidad, descripcion_adicional, informacion_importante, fecha_disponible, hora_limite, estado) VALUES
-- La Esquina (id=1)
(1, 'Comida Preparada', 'Casado con pollo','10 porciones','Casado completo: arroz, frijoles, ensalada y pollo asado', 'Retirar antes de las 8pm, sin refrigeración disponible', CURDATE(), '20:00:00', 'disponible'),
(1, 'Panaderia','Pan dulce surtido','20 unidades','Panes de queso, natilla y jaleas variadas','Mismos del día, mejor consumir hoy',CURDATE(), '19:30:00', 'disponible'),
(1, 'Lacteos','Yogurt natural','15 unidades','Yogurt natural sin azúcar, 200ml cada uno','Cadena de frío necesaria, retirar con bolsa fría',CURDATE(), '18:00:00', 'reservado'),

-- Sabor Tico (id=2)
(2, 'Frutas','Bananos maduros','2 racimos',    'Bananos listos para consumo inmediato','Muy maduros, ideales para batidos o cocinar',CURDATE(), '17:00:00', 'disponible'),
(2, 'Verduras', 'Repollo y zanahoria', '3 kg aprox',   'Repollo en mitades y zanahorias enteras','Lavar bien antes de consumir', CURDATE(), '17:30:00', 'disponible'),
(2, 'Comida Preparada', 'Sopa de res', '8 porciones',  'Sopa completa con papa, yuca, chile dulce y res','Servir caliente, disponible en recipiente sellado',CURDATE(), '18:00:00', 'agotado'),

-- La Casita de Heredia (id=3)
(3, 'Comida Preparada', 'Arroz con pollo','12 porciones', 'Arroz con pollo estilo casero, con vegetales','Disponible en bandejas, traer recipiente propio',CURDATE(), '21:00:00', 'disponible'),
(3, 'Panaderia', 'Torta de zanahoria entera','2 tortas','Tortas enteras de zanahoria con cobertura de queso crema', 'Sin cortar, retirar en caja',CURDATE(), '20:30:00', 'disponible'),
(3, 'Otro','Refrescos naturales','10 litros','Refresco de cas y tamarindo en envases de 1 litro','Mantener refrigerado',CURDATE(), '22:00:00', 'disponible');

-- RESERVAS
INSERT INTO reservaProyecto (id_donacion, id_beneficiario, codigo_reserva, estado, fecha_reserva) VALUES
(3, 1, 'RES-001-2025', 'activa',     NOW()),
(1, 2, 'RES-002-2025', 'confirmada', NOW()),
(7, 1, 'RES-003-2025', 'activa',     NOW()),
(4, 2, 'RES-004-2025', 'cancelada',  NOW());

-- NOTIFICACIONES
INSERT INTO notificacionProyecto (id_usuario, mensaje, fecha) VALUES
(3, 'Tu reserva RES-001-2025 ha sido registrada exitosamente. Recuerda retirar antes de las 18:00.',NOW()),
(3, 'Recordatorio: tienes una reserva activa para hoy. ¡No olvides retirar tu donación!',NOW()),
(2, 'Nueva reserva recibida para tu donación "Casado con pollo". Código: RES-002-2025.',NOW()),
(4, 'Nueva reserva recibida para tu donación "Bananos maduros". Código: RES-004-2025.', NOW()),
(6, 'Tu reserva RES-003-2025 está activa. Retira en La Casita de Heredia antes de las 21:00.', NOW()),
(7, 'Tu reserva RES-002-2025 fue confirmada por el restaurante. ¡Ya puedes pasar a retirar!', NOW()),
(1, 'Resumen del día: 3 donaciones activas, 4 reservas generadas, 0 incidencias reportadas.', NOW());