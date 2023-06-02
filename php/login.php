<?php
class LoginForm
{
    private $username;
    private $password;
    private $error;

    public function __construct()
    {
        $this->error = '';
    }

    public function handleLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->username = $_POST["username"];
            $this->password = $_POST["password"];

            if ($this->username === "usuario" && $this->password === "contraseña") {
                // Las credenciales son válidas, redireccionar a la página de inicio
                header("Location: inicio.php");
                exit();
            } else {
                // Las credenciales son inválidas, mostrar mensaje de error
                $this->error = "Usuario o contraseña incorrectos";
                $this->logError($this->error);
            }
        }
    }

    private function logError($message)
    {
        error_log($message);
    }

    public function getError()
    {
        return $this->error;
    }
}

// Crear una instancia del formulario de inicio de sesión
$loginForm = new LoginForm();
$loginForm->handleLogin();
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
        <h1>Página web de Caravia</h1>
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
            <h2>Iniciar sesión</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Iniciar sesión">

                <?php if ($loginForm->getError()): ?>
                    <p>
                        <?php echo $loginForm->getError(); ?>
                    </p>
                <?php endif; ?>
            </form>
        </section>
    </main>
</body>

</html>