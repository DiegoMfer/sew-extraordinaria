CREATE TABLE Recursoturistico (
  id INT PRIMARY KEY,
  nombreRecurso VARCHAR(255),
  tipo VARCHAR(100),
  precio DECIMAL(10, 2),
  limiteOcupacion INT,
  descripcion TEXT
);

INSERT INTO Recursoturistico (id, nombreRecurso, tipo, precio, limiteOcupacion, descripcion)
VALUES
  (1, 'Playa de Arena Blanca', 'Playa', 10.50, 500, 'Hermosa playa con aguas cristalinas y arena fina.'),
  (2, 'Cascada del Bosque Verde', 'Aventura', 25.00, 100, 'Excursión a una cascada en medio de un frondoso bosque.'),
  (3, 'Museo Histórico', 'Cultural', 8.00, 50, 'Museo que exhibe artefactos históricos de la región.'),
  (4, 'Recorrido en Bicicleta', 'Deporte', 5.00, 20, 'Ruta guiada en bicicleta por los paisajes naturales.'),
  (5, 'Hotel Playa Dorada', 'Alojamiento', 120.00, 200, 'Hotel de lujo frente al mar con todas las comodidades.'),
  (6, 'Tour Gastronómico', 'Culinary', 15.00, 30, 'Visita a los mejores restaurantes de la zona para probar platos típicos.'),
  (7, 'Parque Nacional Sierra Azul', 'Naturaleza', 2.00, 1000, 'Reserva natural con senderos para hacer senderismo y observar la flora y fauna.'),
  (8, 'Excursión en Velero', 'Aventura', 50.00, 10, 'Navegación en un velero por la costa, avistando delfines y ballenas.'),
  (9, 'Spa Relax Total', 'Bienestar', 80.00, 50, 'Spa de lujo con tratamientos relajantes y terapias de bienestar.'),
  (10, 'Ruta del Vino', 'Enoturismo', 12.00, 100, 'Visita a viñedos y bodegas para degustar vinos de la región.');


CREATE TABLE usuarios (
  nombre VARCHAR(255) PRIMARY KEY,
  contrasena VARCHAR(255)
);

INSERT INTO usuarios (nombre, contrasena)
VALUES
  ('usuario', 'contraseña'),
  ('usuario2', 'contraseña2');