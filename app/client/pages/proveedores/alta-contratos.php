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
    <link href="alta-contratos.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Contratos</title>
    <link rel="icon" href="../../images/logo.png" />
</head>

<?php
require_once __DIR__ . "/../../../server/controller/proveedores.php";
require_once __DIR__ . "/../../../server/controller/contratos.php";

if (
    isset($_POST['btnAltaContrato']) && $_POST['txtProveedor'] != "" && $_POST['dateExpiracion'] != "" && $_POST['txtTerminos'] != "" && $_POST['numCosto']
) {
    $id_proveedor =  $_POST['txtProveedor'];
    $fecha_expiracion =  $_POST['dateExpiracion'];
    $terminos =  $_POST['txtTerminos'];
    $costos = $_POST['numCosto'];

    AltaContrato($id_proveedor, $fecha_expiracion, $terminos, $costos);
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
            <h1>Alta de contratos</h1>
                <form method="post" action="./alta-contratos.php">
                    <label>
                        Proveedor:
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
                    <label>
                        Fecha de expiracion:
                        <input type="date" name="dateExpiracion" id="dateExpiracion" value="">
                    </label>
                    <label>
                        Terminos:
                        <input type="text" name="txtTerminos" id="txtTerminos" value="">
                    </label>
                    <label>
                        Costos:
                        <input type="number" name="numCosto" id="numCosto" value="">
                    </label>
                    <div class="button-group">
                        <button type="button" name="btnVolver" onclick="window.location.href='./index.php'">Volver</button>
                        <button type="submit" name="btnAltaContrato" id="btnAltaContrato">Alta</button>
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
