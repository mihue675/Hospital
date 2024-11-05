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
    <title> Gestión de proveedores y contratos</title>
    <link rel="icon" href="../../images/logo.png" />
    <link href="index.css" rel="stylesheet">
</head>

<?php
require_once __DIR__ . "/../../../server/controller/contratos.php";
require_once __DIR__ . "/../../../server/controller/proveedores.php";
$contratos = ObtenerContratos();

if (isset($_POST['btnEliminarContrato'])) {
    $id_contrato = $_POST['id_contrato'];
    EliminarContrato($id_contrato);

    // Redirigir o actualizar la página después de la eliminación
    header("Location: ./index.php"); // O puedes usar un mensaje de éxito y no redirigir
    exit;
}



?>



<body>

    <header>
        <?php require_once __DIR__ . "/../../components/header.php" ?>
        <style>
            <?php require_once __DIR__ . "/../../components/header.css" ?>
        </style>
    </header>
    
    <div class="contenedor-proveedores">

    <main>
        <h1>Gestión de proveedores y Contratos</h1>

        <a class="enlaces" href="./alta-proveedores.php">Añadir un proveedor</a>
        <a class="enlaces" href="./alta-contratos.php">Asignar un nuevo contrato</a>

        <!-- Tabla de contratos registrados -->
        <section>
            <h2>Contratos de Mantenimiento Registrados</h2>
            <table class="tablaContratos" border="2">
                <tr>
                    <th>Proveedor</th>
                    <th>Fecha de Expiración</th>
                    <th>Términos</th>
                    <th>Costos</th>
                    <th>Acciones</th>
                </tr>
                <?php
                foreach ($contratos as $contrato) {
                    echo "<tr>
                        <td>{$contrato['nombre_proveedor']}</td>
                        <td>{$contrato['fecha_expiración']}</td>
                        <td>{$contrato['terminos']}</td>
                        <td>{$contrato['costos']}</td>
                        <td>
                        
                        <form method='post' style='display:inline;'>
                            <input type='hidden' name='id_contrato' value='{$contrato['id']}'>
                            <button type='submit' name='btnEliminarContrato' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este contrato?');\">Eliminar</button>
                        </form>
                        <button name='btnEditar' onclick=\"window.location.href='./editar-contratos.php?id={$contrato['id']}';\">Editar</button>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </section>


        <?php

        $proveedores = ObtenerProveedores();

        echo "<h2>Proveedores</h2>";
        echo "<table class='tablaProveedores'>
        <tr>
            <th>Nombre</th>
            <th>Fecha de Garantía</th>
            <th>Estado de Garantía</th>
        </tr>";

        foreach ($proveedores as $proveedor) {
            // calculo de la garantia
            $garantia = new DateTime($proveedor['garantia']);
            $fecha_actual = new DateTime();
            $intervalo = $fecha_actual->diff($garantia);

            $estado_garantia = "";
            if ($garantia < $fecha_actual) {
                $estado_garantia = "<span class='estado-expirado'>Expirada</span>";
            } elseif ($intervalo->days <= 30) {
                $estado_garantia = "<span class='estado-proximo'>Próxima a Expirar ({$intervalo->days} días)</span>";
            } else {
                $estado_garantia = "<span class='estado-vigente'>Vigente</span>";
            }
            // tabla
            echo "<tr>
            <td>{$proveedor['nombre']}</td>
            <td>{$proveedor['garantia']}</td>
            <td>{$estado_garantia}</td>
          </tr>";
        }

        echo "</table>";
        ?>




    </main>
    </div>

    <footer>
        <?php require_once __DIR__ . "/../../components/footer.php" ?>
        <style>
            <?php require_once __DIR__ . "/../../components/footer.css" ?>
        </style>
    </footer>

</body>

</html>