<?php
session_start();
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
    private $reservas;
    private $recursos;

    public function __construct()
    {
        $this->reservas = $_SESSION['reservas'];
        $this->recursos = $_SESSION['recursos'];
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
            $precioTotal += $precioPorPlaza * $plazasReservadas;
        }

        return $precioTotal;
    }
}

$listaReservas = new Lista();
$reservas = $listaReservas->getReservas();
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
                            <th>Precio por plaza</th>
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


        <?php if (!empty($reservas)): ?>
            <section>
                <h2>Precio Total</h2>
                <p>El precio total de las reservas es:
                    <?php echo $listaReservas->calcularPrecioTotal(); ?>
                </p>
                <form action="inicio.php" method="post">
                    <input type="submit" value="Guardar presupuesto">
                </form>
            </section>
        <?php endif; ?>
    </main>
    <footer>
        <p>©
            <?php echo date('Y'); ?> Reservas
        </p>
    </footer>
</body>

</html>