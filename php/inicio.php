<?php

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
}

class Reserva
{
    private $nombre;
    private $nombreRecurso;
    private $fecha;

    private $plazasReservadas;

    public function __construct($nombre, $nombreRecurso, $fecha, $plazasReservadas)
    {
        $this->nombre = $nombre;
        $this->nombreRecurso = $nombreRecurso;
        $this->fecha = $fecha;
        $this->plazasReservadas = $plazasReservadas;
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
        $conexion = new PDO("mysql:host=localhost;dbname=sew", "test", "test");

        // Consulta para obtener los recursos turísticos
        $consulta = $conexion->query("SELECT * FROM Recursoturistico");

        // Consulta para obtener las reservas
        $consultaReservas = $conexion->query("SELECT * FROM Reserva");

        // Crear array de recursos turísticos
        $this->recursos = [];
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $nombre = $fila['nombreRecurso'];
            $tipo = $fila['tipo'];
            $precio = $fila['precio'];
            $limiteOcupacion = $fila['limiteOcupacion'];
            $descripcion = $fila['descripcion'];
            $recurso = new RecursoTuristico($nombre, $tipo, $precio, $limiteOcupacion, $descripcion);
            $this->recursos[] = $recurso;
        }

        $this->recursoSeleccionado = null;

        $this->reservas = [new Reserva("test", "Recorrido en Bicicleta", "test", 0)];
        while ($fila = $consultaReservas->fetch(PDO::FETCH_ASSOC)) {
            $nombreRecurso = $fila['nombre_recurso'];
            $nombreUsuario = $fila['nombre_usuario'];
            $fecha = $fila['fecha_reserva'];
            $plazasReservadas = $fila['plazas_reservadas'];
            $reserva = new Reserva($nombreUsuario, $nombreRecurso, $fecha, $plazasReservadas);
            $this->reservas[] = $reserva;
        }

        if (isset($_POST['recurso'])) {
            $indice = $_POST['recurso'];
            if (isset($this->recursos[$indice])) {
                $this->recursoSeleccionado = $this->recursos[$indice];
            }
        }


        if (isset($_POST['fecha']) && $this->recursoSeleccionado) {
          //Añade el código para agregar una entidad a la tabla reservas aqui
        }

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
                <br>
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
                    <h2>Reservas realizadas para el recurso seleccionado</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Plazas reservadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista->getReservas() as $reserva): ?>
                                <?php if ($reserva->getNombreRecurso() === $lista->getRecursoSeleccionado()->getNombre()): ?>
                                    <tr>
                                        <td>
                                            <?php echo $reserva->getNombre(); ?>
                                        </td>
                                        <td>
                                            <?php echo $reserva->getFecha(); ?>
                                        </td>
                                        <td>
                                            <?php echo $reserva->getPlazasReservadas(); ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>

            <?php if ($lista->getRecursoSeleccionado()): ?>
                <section>
                    <h2>Reservar Recurso Turístico -
                        <?php echo $lista->getRecursoSeleccionado()->getNombre(); ?>
                    </h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="recurso"
                            value="<?php echo $lista->getRecursoSeleccionado()->getNombre(); ?>">
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" required>
                        <label for="plazas">Plazas a reservar:</label>
                        <input type="number" name="plazas" min="1" required>
                        <input type="submit" value="Reservar">
                    </form>
                </section>
            <?php endif; ?>
        <?php endif; ?>
    </main>
    <footer>
        <p>Proyecto creado por Diego Martín Fernández</p>
    </footer>
</body>

</html>