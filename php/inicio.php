<?php
session_start();

class Usuario
{
    private $nombre;
    private $reservas;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->reservas = [];
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function addReserva($reserva)
    {
        $this->reservas[] = $reserva;
    }

    public function getPresupuesto()
    {
        $presupuestoTotal = 0;

        foreach ($this->reservas as $reserva) {
            $recurso = $reserva->getRecurso();
            $precio = $recurso->getPrecio();
            $plazasReservadas = $reserva->getPlazasReservadas();

            $presupuesto = $precio * $plazasReservadas;
            $presupuestoTotal += $presupuesto;
        }

        return $presupuestoTotal;
    }
}
class RecursoTuristico
{
    private $nombre;
    private $tipo;
    private $precio;
    private $limiteOcupacion;
    private $descripcion;

    public function __construct($nombre, $tipo, $precio, $limiteOcupacion, $descripcion)
    {
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->limiteOcupacion = $limiteOcupacion;
        $this->descripcion = $descripcion;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getLimiteOcupacion()
    {
        return $this->limiteOcupacion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function plazasRestantes($reservas)
    {
        $plazasReservadas = 0;

        foreach ($reservas as $reserva) {
            if ($reserva->getNombreRecurso() === $this->nombre) {
                $plazasReservadas += $reserva->getPlazasReservadas();
            }
        }

        return $this->limiteOcupacion - $plazasReservadas;
    }
}

class Reserva
{
    private $nombre;
    private $nombreRecurso;
    private $fecha;

    private $plazasReservadas;

    private $duracion;

    public function __construct($nombre, $nombreRecurso, $fecha, $plazasReservadas, $duracion)
    {
        $this->nombre = $nombre;
        $this->nombreRecurso = $nombreRecurso;
        $this->fecha = $fecha;
        $this->plazasReservadas = $plazasReservadas;
        $this->duracion = $duracion;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getNombreRecurso()
    {
        return $this->nombreRecurso;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getPlazasReservadas()
    {
        return $this->plazasReservadas;
    }

    public function getDuracion()
    {
        return $this->duracion;
    }

}

class Lista
{
    // Array de recursos turísticos
    private $recursos;
    private $recursoSeleccionado;
    private $reservas;

    public function __construct()
    {
        // Conexión a la base de datos
        $conexion = new mysqli("localhost", "test", "test", "sew");

        if ($conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $conexion->connect_error);
        }

        // Consulta para obtener los recursos turísticos
        $consulta = $conexion->query("SELECT * FROM Recursoturistico");

        // Consulta para obtener las reservas
        $consultaReservas = $conexion->query("SELECT * FROM Reserva");

        // Crear array de recursos turísticos
        $this->recursos = [];
        while ($fila = $consulta->fetch_assoc()) {
            $nombre = $fila['nombreRecurso'];
            $tipo = $fila['tipo'];
            $precio = $fila['precio'];
            $limiteOcupacion = $fila['limiteOcupacion'];
            $descripcion = $fila['descripcion'];
            $recurso = new RecursoTuristico($nombre, $tipo, $precio, $limiteOcupacion, $descripcion);
            $this->recursos[] = $recurso;
        }

        $this->recursoSeleccionado = null;

        $this->reservas = [];
        while ($fila = $consultaReservas->fetch_assoc()) {
            $nombreRecurso = $fila['nombre_recurso'];
            $nombreUsuario = $fila['nombre_usuario'];
            $fecha = $fila['fecha_reserva'];
            $plazasReservadas = $fila['plazas_reservadas'];
            $duracion = $fila['duracion'];
            $reserva = new Reserva($nombreUsuario, $nombreRecurso, $fecha, $plazasReservadas, $duracion);
            $this->reservas[] = $reserva;
        }

        if (isset($_POST['recurso'])) {
            $indice = $_POST['recurso'];
            if (isset($this->recursos[$indice])) {
                $this->recursoSeleccionado = $this->recursos[$indice];
            }
        }

        if (isset($_POST['fecha'])) {
            $fechaReserva = $_POST['fecha'];
            $plazasReservadas = $_POST['plazas'];
            $nombreRecurso = $_POST['nombre'];
            $nombreUsuario = $_SESSION['username'];
            $duracion = $_POST['duracion'];

            // Generar un ID 
            $idReserva = count($this->reservas) + 1;

            // Insertar la nueva reserva en la tabla "reserva"
            $sql = "INSERT INTO Reserva (id_reserva, nombre_recurso, nombre_usuario, fecha_reserva, plazas_reservadas, duracion) 
             VALUES ('$idReserva', '$nombreRecurso', '$nombreUsuario', '$fechaReserva', '$plazasReservadas', '$duracion')";
            if ($conexion->query($sql) === TRUE) {
                // Actualizar el array de reservas
                $reserva = new Reserva($nombreUsuario, $nombreRecurso, $fechaReserva, $plazasReservadas, $duracion);
                $this->reservas[] = $reserva;
            } else {
                echo "Error al insertar la reserva: " . $conexion->error;
            }
        }

        $_SESSION['recursos'] = $this->recursos;
        $_SESSION['reservas'] = $this->reservas;

        $conexion->close();

    }

    public function getRecursos()
    {
        return $this->recursos;
    }

    public function getRecursoSeleccionado()
    {
        return $this->recursoSeleccionado;
    }

    public function getReservas()
    {
        return $this->reservas;
    }


}

$lista = new Lista();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial scale=1.0" />
    <meta name="keywords" content="Reservas" />
    <meta name="author" content="Diego Martín Fernández" />
    <meta name="description" content="Reservas" />
    <title>Reservas</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css">
</head>

<body>
    <header>
        <h1>Página web de reserva de Recurso Turístico</h1>
    </header>
    <nav>
        <a href="../index.html" accesskey="I" tabindex="1">
            Página principal
        </a>

        <a href="../gastronomia.html" accesskey="g" tabindex="2">
            Gastronomía
        </a>

        <a href="../rutas.html" accesskey="T" tabindex="3">
            Rutas
        </a>

        <a href="../meteorologia.html" accesskey="M" tabindex="4">
            Meteorología
        </a>

        <a href="../juego.html" accesskey="C" tabindex="6">
            Juego
        </a>

        <a href="./login.php" accesskey="C" tabindex="4">
            Reservas
        </a>
    </nav>
    <main>
        <section>
            <h2>Reservar Recurso Turístico</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="recurso">Selecciona un recurso turístico:</label>
                <select id="recurso" name="recurso">
                    <?php foreach ($lista->getRecursos() as $indice => $recurso): ?>
                        <option value="<?php echo $indice; ?>"><?php echo $recurso->getNombre(); ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Mostrar información">
            </form>
        </section>

        <?php if ($lista->getRecursoSeleccionado()): ?>
            <section>
                <h2>Información del Recurso Turístico</h2>
                <p>Nombre:
                    <?php echo $lista->getRecursoSeleccionado()->getNombre(); ?>
                </p>
                <p>Tipo:
                    <?php echo $lista->getRecursoSeleccionado()->getTipo(); ?>
                </p>
                <p>Precio:
                    <?php echo $lista->getRecursoSeleccionado()->getPrecio(); ?>
                </p>
                <p>Límite de ocupación:
                    <?php echo $lista->getRecursoSeleccionado()->getLimiteOcupacion(); ?>
                </p>
                <p>Descripción:
                    <?php echo $lista->getRecursoSeleccionado()->getDescripcion(); ?>
                </p>
            </section>

            <?php if ($lista->getReservas()): ?>
                <section>
                    <h2>Reservas</h2>
                    <?php foreach ($lista->getReservas() as $reserva): ?>
                        <?php if ($reserva->getNombreRecurso() === $lista->getRecursoSeleccionado()->getNombre()): ?>
                            
                                <p>Nombre:
                                    <?php echo $reserva->getNombre(); ?>
                                </p>
                                <p>Fecha:
                                    <?php echo $reserva->getFecha(); ?>
                                </p>
                                <p>Plazas reservadas:
                                    <?php echo $reserva->getPlazasReservadas(); ?>
                                </p>
                                <p>Duración en horas:
                                    <?php echo $reserva->getDuracion(); ?>
                                </p>
                                <p>----------------------</p>
                            
                        <?php endif; ?>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if ($lista->getRecursoSeleccionado() && $lista->getRecursoSeleccionado()->plazasRestantes($lista->getReservas()) > 0): ?>
                <section>
                    <h2>Reservar Recurso Turístico -
                        <?php echo $lista->getRecursoSeleccionado()->getNombre(); ?> -
                        <?php echo $lista->getRecursoSeleccionado()->plazasRestantes($lista->getReservas()); ?> plazas restantes
                    </h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <input type="hidden" name="nombre" value="<?php echo $lista->getRecursoSeleccionado()->getNombre(); ?>"
                            id="nombre">


                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" id="fecha" required>

                        <label for="plazas">Plazas a reservar:</label>
                        <input type="number" name="plazas" min="1"
                            max="<?php echo $lista->getRecursoSeleccionado()->plazasRestantes($lista->getReservas()); ?>"
                            id="plazas" required>

                        <label for="duracion">Horas (a partir de 8 horas es un nuevo día):</label>
                        <input type="number" name="duracion" min="1" max="24" id="duracion" required>

                        <input type="submit" value="Reservar">


                    </form>
                </section>
            <?php else: ?>
                <section>
                    <h2>No se pueden realizar más reservas</h2>
                    <p>No quedan plazas disponibles para este recurso.</p>
                </section>
            <?php endif; ?>


            <section>
                <h2>Generar presupuesto</h2>
                <a href="presupuesto.php">Ver detalle del presupuesto</a>
            </section>
        <?php endif; ?>
    </main>
    <footer>
        <p>Proyecto creado por Diego Martín Fernández</p>
    </footer>
</body>

</html>