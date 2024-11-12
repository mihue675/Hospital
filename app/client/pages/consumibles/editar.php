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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consumible</title>
    <link rel="icon" href="../../images/logo.png" />
    <link rel="stylesheet" href="editar.css"/>
</head>

<?php
require_once __DIR__ . "/../../../server/controller/consumibles.php";

$id = $_GET['id'];

$consumible = ObtenerConsumiblePorId($id);

if (
    isset($_POST['btnEditarConsumible']) && $_POST['txtNombre'] != "" && $_POST['txtCantidad'] != "" && $_POST['txtCantidadMinima'] != ""
) {
    $nombre =  $_POST['txtNombre'];
    $cantidad =  $_POST['txtCantidad'];
    $cantidad_minima =  $_POST['txtCantidadMinima'];

    EditarConsumible($id, $nombre, $cantidad, $cantidad_minima);

    header("Location: ./index.php");
    exit;
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
    <h1 class="h1">Editar consumible</h1>
    <div class="contenedor-form">
    <form class= "form" method="post" action="">
        <label class="label">
            Nombre:
            <input type="text" name="txtNombre" id="txtNombre" value="<?php echo $consumible['nombre']; ?>" required />
        </label>
        <br/>
        <label class="label">
            Cantidad:
            <input type="number" name="txtCantidad" id="txtCantidad" value="<?php echo $consumible['cantidad']; ?>" required />
        </label>
        <br/>
        <label class="label">
            Punto de reposición:
            <input type="number" name="txtCantidadMinima" id="txtCantidadMinima" value="<?php echo $consumible['cantidad_minima']; ?>" required />
        </label>
        <br/>
        <div clase="contenedor-botones">
        <button type="button" onclick="window.location.href = './index.php'">Volver</button>
        <button class="btnEditarConsumible" type="submit" name="btnEditarConsumible" id="btnEditarConsumible">Guardar</button>
        </div>
    </form>
    
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