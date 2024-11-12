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
require_once __DIR__ . "/../../../server/controller/consumibles.php";

if (isset($_POST['btnAltaEquipo'])) {
    $nombre = $_POST['txtNombre'];
    $marca = $_POST['txtMarca'];
    $modelo = $_POST['txtModelo'];
    $numeroDeSerie = $_POST['txtNumeroDeSerie'];
    $fechaDeCompra = $_POST['txtFechaDeCompra'];
    $ubicacion = $_POST['txtUbicacion'];
    $descripcion = $_POST['txtDescripcion'];
    $categoria = $_POST['txtCategoria'];
    $proveedor = $_POST['txtProveedor'];
    $consumibles = $_POST['consumibles'];
    $cantidades = $_POST['cantidades'];

    // todo esto es el control de stock, si no se subia sin consumibles o se subia 2 veces alto lore
    $stockSuficiente = true;

    foreach ($consumibles as $i => $consumible_id) {
        $cantidad_solicitada = intval($cantidades[$i]);
        $consumible = ObtenerConsumiblePorId($consumible_id);

        // chequeamos si el consumible existe y si hay suficiente stock
        if (!$consumible || $cantidad_solicitada > $consumible['cantidad']) {
            $stockSuficiente = false;
            break; // si falla en uno, cortamos
        }
    }

    // si tenemos stock para todos, sigue el alta
    if ($stockSuficiente) {
        // creamos el equipo y guardamos su id para despues
        AltaEquipo($nombre, $marca, $modelo, $numeroDeSerie, $fechaDeCompra, $ubicacion, $descripcion, $categoria, $proveedor);
        $equipo_id = mysqli_insert_id($conn);

        // recorremos los consumibles y ahora si los asignamos
        foreach ($consumibles as $i => $consumible_id) {
            $cantidad_solicitada = intval($cantidades[$i]);
            $consumible = ObtenerConsumiblePorId($consumible_id);

            // restamos la cantidad usada del stock q queda
            $nuevo_stock = $consumible['cantidad'] - $cantidad_solicitada;
            EditarConsumible($consumible_id, $consumible['nombre'], $nuevo_stock, $consumible['cantidad_minima']);

            // guardamos en la bd en equipos_consumibles
            AltaEquipoConsumible($equipo_id, $consumible_id, $cantidad_solicitada);
        }

        header("Location: index.php");
    } else {
        // si no hay stock suficiente, mostramos una alerta y no hacemos el alta
        echo '<script type="text/javascript">
    window.onload = function () { alert("No hay suficiente stock para los consumibles asignados."); }
    </script>';
    }
}

?>

<script>
                // lista de consumibles disponibles
                const consumiblesDisponibles = [
                    <?php
                    foreach (ObtenerConsumibles() as $consumible) {
                        echo "{ id: {$consumible['id']}, nombre: '{$consumible['nombre']}', cantidad: {$consumible['cantidad']} },";
                    }
                    ?>
                ];

                // esto agrega un consumible al formulario
                function agregarConsumible() {
                    const container = document.getElementById("consumibles-container");
                    const div = document.createElement("div");
                    div.classList.add("consumible-item");

                    // generamos las opciones para el select, con los consumibles disponibles
                    let options = `<option disabled selected value="">Seleccione un consumible</option>`;
                    consumiblesDisponibles.forEach(consumible => {
                        options += `<option value="${consumible.id}">${consumible.nombre} - Stock: ${consumible.cantidad}</option>`;
                    });

                    // metemos el select, selector de cantidad y el boton para borrarlo dentro del div
                    div.innerHTML = `<select name="consumibles[]" required>${options}</select>
                    <input type="number" name="cantidades[]" min="1" placeholder="Cantidad" required />
                    <button type="button" onclick="eliminarConsumible(this)">Eliminar</button>`;

                    // agregamos el div con el consumible al contenedor
                    container.appendChild(div);
                }

                function eliminarConsumible(button) {
                    button.parentElement.remove(); // borra el div donde esta el consumible
                }
            </script>




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
            <div id="consumibles-container">
                <h3>Asignar Consumibles</h3>
                <button type="button" onclick="agregarConsumible()">Agregar Consumible</button>
            </div>

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