<?php
session_start();



class Presupuesto
{

    private $nombreUsuario;
    private $precio;

    public function __construct($nombreUsuario, $precio)
    {

        $this->nombreUsuario = $nombreUsuario;
        $this->precio = $precio;
    }

    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    public function getPrecio()
    {
        return $this->precio;
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
    private $reservas;
    private $recursos;

    private $presupuestos;

    public function __construct()
    {
        $this->reservas = $_SESSION['reservas'];
        $this->recursos = $_SESSION['recursos'];
        $nombreUsuario = $_SESSION['username'];
        $conexion = new PDO("mysql:host=localhost;dbname=sew", "test", "test");


        // Consulta para obtener los presupuestos por usuario
        $consulta = $conexion->query("SELECT * FROM presupuesto WHERE nombre_usuario = '$nombreUsuario'");

        // Crear array de presupuestos
        $this->presupuestos = [];
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $nombre = $fila['nombre_usuario'];
            $precio = $fila['precio'];

            $presupuesto = new Presupuesto($nombre, $precio);
            $this->presupuestos[] = $presupuesto;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $prectioTotal = $this->calcularPrecioTotal() * $_POST['duracion'];
            $conexion->query("INSERT INTO presupuesto (nombre_usuario, precio) VALUES ('$nombreUsuario', $prectioTotal)");

        }



        



    }


    public function getReservas()
    {
        $nombre = $_SESSION['username'];
        $reservasFiltradas = array_filter($this->reservas, function ($reserva) use ($nombre) {
            return $reserva->getNombre() === $nombre;
        });

        return $reservasFiltradas;
    }

    public function getPrecioRecurso($recurso)
    {
        foreach ($this->recursos as $recursoTuristico) {
            if ($recursoTuristico->getNombre() === $recurso) {
                return $recursoTuristico->getPrecio();
            }
        }

        return "Recurso no encontrado";
    }

    public function calcularPrecioTotal()
    {
        $precioTotal = 0;

        foreach ($this->reservas as $reserva) {
            $precioPorPlaza = $this->getPrecioRecurso($reserva->getNombreRecurso());
            $plazasReservadas = $reserva->getPlazasReservadas();
            $precioTotal += $precioPorPlaza * $plazasReservadas * $reserva->getDuracion();
        }

        return $precioTotal;
    }

    public function getPresupuestos()
    {
        return $this->presupuestos;
    }
}

$listaReservas = new Lista();
$reservas = $listaReservas->getReservas();
$presupuestos = $listaReservas->getPresupuestos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial scale=1.0" />
    <meta name="keywords" content="Reservas" />
    <meta name="author" content="Diego Martín Fernández" />
    <meta name="description" content="Reservas" />
    <title>Listado de Reservas</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css">
</head>

<body>
    <header>
        <h1>Listado de Reservas</h1>
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
            <h2>Listado de Reservas para:
                <?php echo $_SESSION['username']; ?>
            </h2>
            <?php if (!empty($reservas)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Recurso</th>
                            <th>Fecha</th>
                            <th>Plazas reservadas</th>
                            <th>Horas</th>
                            <th>Precio por hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservas as $reserva): ?>
                            <tr>
                                <td>
                                    <?php echo $reserva->getNombreRecurso(); ?>
                                </td>
                                <td>
                                    <?php echo $reserva->getFecha(); ?>
                                </td>
                                <td>
                                    <?php echo $reserva->getPlazasReservadas(); ?>
                                </td>
                                <td>
                                    <?php echo $reserva->getDuracion(); ?>
                                </td>
                                <td>
                                    <?php echo $listaReservas->getPrecioRecurso($reserva->getNombreRecurso()); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron reservas.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Listado de Presupuestos para:
                <?php echo $_SESSION['username']; ?>
            </h2>
            <?php if (!empty($presupuestos)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre usuario</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($presupuestos as $presupuesto): ?>
                            <tr>
                                <td>
                                    <?php echo $presupuesto->getNombreUsuario(); ?>
                                </td>
                                <td>
                                    <?php echo $presupuesto->getPrecio(); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron presupuestos.</p>
            <?php endif; ?>
        </section>

        <?php if (!empty($reservas)): ?>
            <section>
                <h2>Precio Total</h2>
                <p>El precio total de las reservas es:
                    <?php echo $listaReservas->calcularPrecioTotal(); ?>
                </p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="submit" value="Guardar presupuesto">
                </form>
            </section>
        <?php endif; ?>

        <section>
            <h2>Reservas</h2>
            <a href="inicio.php">Volver a reservas</a>
        </section>
    </main>
    <footer>
        <p>Proyecto creado por Diego Martín Fernández</p>
    </footer>
</body>

</html>