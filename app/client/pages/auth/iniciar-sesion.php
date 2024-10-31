<?php
session_start();
if (isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital - Iniciar Sesión</title>
    <link rel="stylesheet" href="iniciar-sesion.css">
</head>

<?php
require_once __DIR__ . "/../../../server/controller/auth.php";

if (isset($_POST['btnIniciarSesion']) && $_POST['txtEmail'] != "" && $_POST['txtContraseña'] != "") {
    if (IniciarSesion($_POST['txtEmail'], $_POST['txtContraseña'])) {
        header("Location: ../../index.php");
    }
}
?>

<body>
    <div class="div-Todo">
        <! necesitas un div que contenga los paneles, dentro del panel pones en uno de esos el forumlario, el formulario ta dividido en 2 divs />
        <div class="panel-izquierdo">
            <h2>¡Bienvenido!</h2>
            <p>Si no tiene una cuenta aún, por favor regístrese.</p>
            <button onclick="window.location.href='registrarse.php'">Registrarse</button>
        </div>
        <div class="panel-derecho">
            <h2>Iniciar Sesión</h2>
            <form method="post" action="iniciar-sesion.php">
                <div class="grupo-formulario">
                    <label for="txtEmail">Email:</label>
                    <input type="email" name="txtEmail" id="txtEmail" required />
                </div>
                <div class="grupo-formulario">
                    <label for="txtContraseña">Contraseña:</label>
                    <input type="password" name="txtContraseña" id="txtContraseña" required />
                </div>
                <button type="submit" name="btnIniciarSesion" id="btnIniciarSesion" class="btn">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>

</html>