<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}

if (isset($_SESSION['idUsuario']) && $_SESSION['id_rol'] != 1) {
    header("Location: ../../error-permisos.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <html translate="no">
    <meta charset="UTF-8">
    <link href="alta-proveedores.css" rel="stylesheet">
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
    
    <header>
        <?php require_once __DIR__ . "/../../components/header.php" ?>
        <style>
            <?php require_once __DIR__ . "/../../components/header.css" ?>
        </style>
    </header>

    <div class="contenedor">
    <div class="form-container">
    <h1>Alta de proveedores</h1>
    <form method="post" action="./alta-proveedores.php">
        <label>
            Nombre:
            <input type="text" name="txtNombre" id="txtNombre" value="">
        </label>
        <label>
            Contacto:
            <input type="number" name="numContacto" id="numContacto" value="">
        </label>
        <label>
            Garantía:
            <input type="date" name="dateGarantia" id="dateGarantia" value="">
        </label>
        <div class="button-group">
            <button type="button" name="btnVolver" onclick="window.location.href='./index.php'">Volver</button>
            <button type="submit" name="btnAltaProveedor" id="btnAltaProveedor">Alta</button>
        </div>
    </form>
    </div>
    </div>
    
    <footer>
        <?php require_once __DIR__ . "/../../components/footer.php" ?>
        <style>
            <?php require_once __DIR__ . "/../../components/footer.css" ?>
        </style>
    </footer>

</body>

</html>