<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <html translate="no">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de proveedores</title>
    <link rel="icon" href="../../images/logo.png" />
</head>

<?php
require_once __DIR__ . "/../../../server/controller/proveedores.php";

if (
    isset($_POST['btnAltaProveedor']) && $_POST['txtNombre'] != "" && $_POST['numContacto'] != "" && $_POST['dateGarantia'] != ""
) {
    $nombre =  $_POST['txtNombre'];
    $telefono =  $_POST['numContacto'];
    $garantia =  $_POST['dateGarantia'];

    AltaProveedor($nombre, $telefono, $garantia);
}

?>

<body>


    <main>
        <h1>Alta de proveedores.</h1>
        <div class="formProveedor">
            <form method="post" action="./alta-proveedores.php">
                <label>
                    Nombre:
                    <input type="text" name="txtNombre" id="txtNombre" value="">
                </label>
                <br>
                <label>
                    Contacto:
                    <input type="number" name="numContacto" id="numContacto" value="">
                </label>
                <br>
                <label>
                    Garantia:
                    <input type="date" name="dateGarantia" id="dateGarantia" value="">
                </label>
                <br>
                <button type="submit" name="btnAltaProveedor" id="btnAltaProveedor">Alta</button>

            </form>
            <button name="btnVolver" onclick="window.location.href='./index.php'">Volver</button>
        </div>

    </main>
</body>

</html>