<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
}

?>

<body>
    <form method="post" action="./alta.php">
        <label>
            Nombre:
            <input type="text" name="txtNombre" id="txtNombre" value="" />
        </label>
        <br />
        <label>
            Marca:
            <input type="text" name="txtMarca" id="txtMarca" value="" />
        </label>
        <br />
        <label>
            Modelo
            <input type="text" name="txtModelo" id="txtModelo" value="" />
        </label>
        <br />
        <label>
            Número de serie:
            <input type="number" name="txtNumeroDeSerie" id="txtNumeroDeSerie" value="" />
        </label>
        <br />
        <label>
            Fecha de compra
            <input type="date" name="txtFechaDeCompra" id="txtFechaDeCompra" value="" />
        </label>
        <br />
        <label>
            Ubicación:
            <input type="text" name="txtUbicacion" id="txtUbicacion" value="" />
        </label>
        <br />
        <label>
            Descripción:
            <input type="text" name="txtDescripcion" id="txtDescripcion" value="" />
        </label>
        <br />
        <label>
            Categoría:
            <select name="txtCategoria" id="txtCategoria">
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
            Proveedor
            <select name="txtProveedor" id="txtProveedor">
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
        <button>Volver</button>
        <button type="submit" name="btnAltaEquipo" id="btnAltaEquipo">Alta</button>
    </form>
</body>

</html>