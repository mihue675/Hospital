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
</head>

<?php
require_once __DIR__ . "/../../../server/services/iniciar-sesion.php";

if (isset($_POST['btnIniciarSesion']) && $_POST['txtEmail'] != "" && $_POST['txtContraseña'] != "") {
    if (IniciarSesion($_POST['txtEmail'], $_POST['txtContraseña'])) {
        header("Location: ../../index.php");
    }
}

?>

<body>
    <form method="post" action="iniciar-sesion.php">
        <label>
            Email:
            <input type=" email" name="txtEmail" id="txtEmail" value="" />
        </label>
        <br />
        <lable>
            Contraseña:
            <input type="password" name="txtContraseña" id="txtContraseña" value="" />
        </lable>
        <br />
        <button type="submit" name="btnIniciarSesion" id="btnIniciarSesion">Iniciar Sesión</button>
    </form>
</body>

</html>