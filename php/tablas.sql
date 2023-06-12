-- La base de datos está hecha con xampp mysql, su nombre es sew y para conectarse el usuario y contraseña es test test

CREATE TABLE Usuario (
  nombre VARCHAR(255) PRIMARY KEY,
  contrasena VARCHAR(255)
);

CREATE TABLE Login (
  id INT PRIMARY KEY AUTO_INCREMENT,
  usuario_nombre VARCHAR(255),
  descripcion VARCHAR(255),
  FOREIGN KEY (usuario_nombre) REFERENCES Usuario(nombre)
);


CREATE TABLE Recursoturistico (
  nombreRecurso VARCHAR(255) PRIMARY KEY,
  tipo VARCHAR(100),
  precio DECIMAL(10, 2),
  limiteOcupacion INT,
  descripcion TEXT
);

CREATE TABLE Reserva (
  id_reserva INT PRIMARY KEY,
  nombre_recurso VARCHAR(255),
  nombre_usuario VARCHAR(255),
  fecha_reserva DATE,
  plazas_reservadas INT,
  duracion INT,
  FOREIGN KEY (nombre_recurso) REFERENCES Recursoturistico(nombreRecurso),
  FOREIGN KEY (nombre_usuario) REFERENCES Usuario(nombre)
);

CREATE TABLE Presupuesto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50),
    precio DECIMAL(10, 2),
    FOREIGN KEY (nombre_usuario) REFERENCES Usuario(nombre)
);













-- Insertamos los datos
INSERT INTO Usuario (nombre, contrasena)
VALUES
  ('usuario', 'contraseña'),
  ('usuario2', 'contraseña2');

INSERT INTO Recursoturistico (nombreRecurso, tipo, precio, limiteOcupacion, descripcion)
VALUES
  ('Playa de Arena Blanca', 'Playa', 10.50, 500, 'Hermosa playa con aguas cristalinas y arena fina.'),
  ('Cascada del Bosque Verde', 'Aventura', 25.00, 100, 'Excursión a una cascada en medio de un frondoso bosque.'),
  ('Museo Histórico', 'Cultural', 8.00, 50, 'Museo que exhibe artefactos históricos de la región.'),
  ('Recorrido en Bicicleta', 'Deporte', 5.00, 20, 'Ruta guiada en bicicleta por los paisajes naturales.'),
  ('Hotel Playa Dorada', 'Alojamiento', 120.00, 200, 'Hotel de lujo frente al mar con todas las comodidades.'),
  ('Tour Gastronómico', 'Culinary', 15.00, 30, 'Visita a los mejores restaurantes de la zona para probar platos típicos.'),
  ('Parque Nacional Sierra Azul', 'Naturaleza', 2.00, 1000, 'Reserva natural con senderos para hacer senderismo y observar la flora y fauna.'),
  ('Excursión en Velero', 'Aventura', 50.00, 10, 'Navegación en un velero por la costa, avistando delfines y ballenas.'),
  ('Spa Relax Total', 'Bienestar', 80.00, 50, 'Spa de lujo con tratamientos relajantes y terapias de bienestar.'),
  ('Ruta del Vino', 'Enoturismo', 12.00, 100, 'Visita a viñedos y bodegas para degustar vinos de la región.');


  INSERT INTO Reserva (id_reserva, nombre_recurso, nombre_usuario, fecha_reserva,plazas_reservadas, duracion)
VALUES
  (1, 'Playa de Arena Blanca', 'usuario', '2023-06-01',1,1),
  (2, 'Cascada del Bosque Verde', 'usuario', '2023-06-02',1,1),
  (3, 'Museo Histórico', 'usuario', '2023-06-03',1,1),
  (4, 'Recorrido en Bicicleta', 'usuario', '2023-06-04',1,1),
  (5, 'Hotel Playa Dorada', 'usuario', '2023-06-05',1,1);
