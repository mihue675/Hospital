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
    <link href="alta.css" rel="stylesheet">
    <link rel="icon" href="../../images/logo.png" />
    <title>Equipos - Alta</title>
</head>

<?php
require_once __DIR__ . "/../../../server/controller/categorias.php";
require_once __DIR__ . "/../../../server/controller/proveedores.php";
require_once __DIR__ . "/../../../server/controller/equipos.php";

if (
    isset($_POST['btnAltaEquipo']) && $_POST['txtNombre'] != "" && $_POST['txtMarca'] != "" && $_POST['txtModelo'] != "" && $_POST['txtNumeroDeSerie'] != ""
    && $_POST['txtFechaDeCompra'] != "" && $_POST['txtUbicacion'] != "" && $_POST['txtDescripcion'] != "" && $_POST['txtCategoria'] != "" && $_POST['txtProveedor'] != ""
) {
    $nombre =  $_POST['txtNombre'];
    $marca =  $_POST['txtMarca'];
    $modelo =  $_POST['txtModelo'];
    $numeroDeSerie =  $_POST['txtNumeroDeSerie'];
    $fechaDeCompra =  $_POST['txtFechaDeCompra'];
    $ubicacion =  $_POST['txtUbicacion'];
    $descripcion =  $_POST['txtDescripcion'];
    $categoria =  $_POST['txtCategoria'];
    $proveedor =  $_POST['txtProveedor'];
    AltaEquipo($nombre, $marca, $modelo, $numeroDeSerie, $fechaDeCompra, $ubicacion, $descripcion, $categoria, $proveedor);
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

    <div style="display:flex; justify-content: center; align-items: center; padding-bottom: 30px;">
        <form method="post" action="./alta.php">
            <h1>Alta de Equipos</h1>
            <label>
                Nombre:
                <input type="text" name="txtNombre" id="txtNombre" value="" required />
            </label>
            <br />
            <label>
                Marca:
                <input type="text" name="txtMarca" id="txtMarca" value="" required />
            </label>
            <br />
            <label>
                Modelo:
                <input type="text" name="txtModelo" id="txtModelo" value="" required />
            </label>
            <br />
            <label>
                Número de serie:
                <input type="number" name="txtNumeroDeSerie" id="txtNumeroDeSerie" value="" required />
            </label>
            <br />
            <label>
                Fecha de compra:
                <input type="date" name="txtFechaDeCompra" id="txtFechaDeCompra" value="" required />
            </label>
            <br />
            <label>
                Ubicación:
                <input type="text" name="txtUbicacion" id="txtUbicacion" value="" required />
            </label>
            <br />
            <label>
                Descripción:
                <input type="text" name="txtDescripcion" id="txtDescripcion" value="" required />
            </label>
            <br />
            <label>
                Categoría:
                <select name="txtCategoria" id="txtCategoria" required>
                    <option disabled selected value="">Seleccione una categoría</option>
                    <?php
                    $filas = ObtenerCategorias();
                    for ($i = 0; $i < count($filas); $i++) {
                    ?>
                        <option value=<?php echo $filas[$i]['id'] ?>><?php echo $filas[$i]['nombre'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </label>
            <br />
            <label>
                Proveedor:
                <select name="txtProveedor" id="txtProveedor" required>
                    <option disabled selected value="">Seleccione un proveedor</option>
                    <?php
                    $filas = ObtenerProveedores();
                    for ($i = 0; $i < count($filas); $i++) {
                    ?>
                        <option value=<?php echo $filas[$i]['id'] ?>><?php echo $filas[$i]['nombre'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </label>
            <br />
            <button type="button" onclick="window.location.href = './index.php'">Volver</button>
            <button type="submit" name="btnAltaEquipo" id="btnAltaEquipo">Alta</button>
        </form>
    </div>


    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css")  ?>
        </style>
    </footer>
</body>

</html>