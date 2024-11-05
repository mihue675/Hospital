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
    <link rel="icon" href="../../images/logo.png" />
    <link rel="stylesheet" href ="alta.css"/>
    <title>Consumibles - Alta</title>
</head>

<?php
require_once __DIR__ . "/../../../server/controller/consumibles.php";

if (
    isset($_POST['btnAltaConsumible']) && ($_POST['txtNombre'])!= "" && ($_POST['txtCantidad'])!="" && ($_POST['txtCantidadMinima'])!="" 
){
    $nombre = $_POST['txtNombre'];
    $cantidad = $_POST['txtCantidad'];
    $cantidad_minima = $_POST['txtCantidadMinima'];
    AltaConsumible($nombre, $cantidad, $cantidad_minima);
    header("Location: index.php");
}
?>


<body>
    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>

    <div style="align-items:center;">
    <h1 class="h1">Alta de consumibles</h1>
    <div class="contenedor-form">
    <form class= "form" method="post" action="alta.php">
        <label class="label">
            Nombre:
            <input type="text" name="txtNombre" id="txtNombre" value="" required />
        </label>
        <br/>
        <label class="label">
            Cantidad:
            <input type="number" name="txtCantidad" id="txtCantidad" value="" required />
        </label>
        <br/>
        <label class="label">
            Cantidad mínima:
            <input type="number" name="txtCantidadMinima" id="txtCantidadMinima" value="" required />
        </label>
        <br/>

        <button class="btnAltaConsumible" type="submit" name="btnAltaConsumible" id="btnAltaConsumible">Guardar</button>
    </form>
    
    </div>
    <div class="contenedor-boton">
        <button onclick="window.location.href = './index.php'">
            Volver
        </button>
    </div>
    </div>

    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css")  ?>
        </style>
    </footer>
</body>

</html>

