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
    <title>Editar Contrato</title>
    <link rel="icon" href="../../images/logo.png" />
</head>

<?php
require_once __DIR__ . "/../../../server/controller/proveedores.php";
require_once __DIR__ . "/../../../server/controller/contratos.php";

// Obtener el id del contrato a editar
$id_contrato = $_GET['id'];

// Verificar si el contrato existe y obtener sus datos
$contrato = ObtenerContratoPorId($id_contrato);
if (!$contrato) {
    echo "Contrato no encontrado.";
    exit;
}

// Guardar los cambios si se envía el formulario
if (
    isset($_POST['btnEditarContrato']) && $_POST['txtProveedor'] != "" && $_POST['dateExpiracion'] != "" && $_POST['txtTerminos'] != "" && $_POST['numCosto'] != ""
) {
    $id_proveedor =  $_POST['txtProveedor'];
    $fecha_expiracion =  $_POST['dateExpiracion'];
    $terminos =  $_POST['txtTerminos'];
    $costos = $_POST['numCosto'];

    EditarContrato($id_contrato, $id_proveedor, $fecha_expiracion, $terminos, $costos);

    // Redirigir a la lista de contratos después de guardar
    header("Location: ./index.php");
    exit;
}

?>

<body>
    <main>
        <h1>Editar Contrato</h1>
        <div class="formProveedor">
        <form method="post" action="">
            <label>
            Proveedor:
            <select name="txtProveedor" id="txtProveedor">
                <option disabled value="">Seleccione un proveedor</option>
                <?php
                $filas = ObtenerProveedores();
                foreach ($filas as $proveedor) {
                    // Marcar el proveedor actual del contrato como seleccionado
                    $selected = $proveedor['id'] == $contrato['id_proveedor'] ? 'selected' : '';
                    echo "<option value='{$proveedor['id']}' $selected>{$proveedor['nombre']}</option>";
                }
                ?>
            </select>
            </label>
            <br>
            <label> 
                Fecha de expiración: 
                <input type="date" name="dateExpiracion" id="dateExpiracion" value="<?php echo $contrato['fecha_expiración']; ?>">
            </label>
            <br>
            <label> 
                Términos:
                <input type="text" name="txtTerminos" id="txtTerminos" value="<?php echo $contrato['terminos']; ?>">
            </label>
            <br>
            <label> 
                Costos:
                <input type="number" name="numCosto" id="numCosto" value="<?php echo $contrato['costos']; ?>">
            </label>
            <button type="submit" name="btnEditarContrato" id="btnEditarContrato">Guardar Cambios</button>
        </form>
        <button name="btnVolver" onclick="window.location.href='./index.php'">Volver</button>   
        </div>

    </main>
</body>
</html>