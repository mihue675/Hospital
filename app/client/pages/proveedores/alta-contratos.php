<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Contratos</title>
    <link rel="icon" href="../../images/logo.png" />
</head>

<?php
require_once __DIR__ . "/../../../server/controller/proveedores.php";
require_once __DIR__ . "/../../../server/controller/contratos.php";

if (
    isset($_POST['btnAltaContrato']) && $_POST['txtProveedor'] != "" && $_POST['dateExpiracion'] != "" && $_POST['txtTerminos'] != "" && $_POST['numCosto']) {
    $id_proveedor =  $_POST['txtProveedor'];
    $fecha_expiracion =  $_POST['dateExpiracion'];
    $terminos =  $_POST['txtTerminos'];
    $costos = $_POST['numCosto'];

    AltaContrato($id_proveedor,$fecha_expiracion,$terminos,$costos);
}
?>

<body>
    <main>
        <h1>Alta de contratos.</h1>
        <div class="formProveedor">
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
            <br>
            <label> 
                Fecha de expiracion: 
                <input type="date" name="dateExpiracion" id="dateExpiracion" value="">
            </label>
            <br>
            <label> 
                Terminos:
                <input type="text" name="txtTerminos" id="txtTerminos" value="">
            </label>
            <br>
            <label> 
                Costos:
                <input type="number" name="numCosto" id="numCosto" value="">
            </label>
            <button type="submit" name="btnAltaContrato" id="btnAltaContrato">Alta</button>
        </form>
        <button name="btnVolver" onclick="window.location.href='./index.php'">Volver</button>   
        </div>

    </main>
</body>
</html>