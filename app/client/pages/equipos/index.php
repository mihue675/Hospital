<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos</title>
    <link rel="icon" href="../../images/logo.png" />

    <script>
        function FiltrarEquipos() {
            const categoriaSeleccionada = document.getElementById("txtCategoria").value;
            const equipos = document.getElementsByClassName("equipo")
            let array = [...equipos]

            array.forEach(equipo => {
                if (categoriaSeleccionada === "" || equipo.getAttribute("data-categoria") === categoriaSeleccionada) {
                    equipo.style.display = "block"; // Mostrar el equipo
                } else {
                    equipo.style.display = "none"; // Ocultar el equipo
                }
            });
        }

        function CambiarEstado(id, estado) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualiza la interfaz de usuario.
                    location.reload();
                }
            };
            xhr.send("id=" + id + "&estado=" + estado); // Enviar el id y el nuevo estado
        }

        function DarDeBaja(id) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualiza la interfaz de usuario.
                    location.reload();
                }
            };
            xhr.send("id=" + id + "&btnDarDeBaja=1"); // Enviar el id del equipo a eliminar.
        }
    </script>
</head>

<?php
require_once __DIR__ . "/../../../server/controller/equipos.php";
require_once __DIR__ . "/../../../server/controller/categorias.php";
require_once __DIR__ . "/../../../server/controller/proveedores.php";

if (isset($_POST['estado']) && $_POST['estado'] != "") {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    CambiarEstado($id, $estado);
}

if (isset($_POST['btnDarDeBaja'])) {
    $id = $_POST['id'];
    BajaEquipo($id);
}
?>

<body>
    <div>
        <form method="post" action="index.php">
            <label for="txtCategoria">
                Filtrar por categoria
            </label>
            <select name="txtCategoria" id="txtCategoria" onchange="FiltrarEquipos()">
                <option disabled selected value="">Seleccionar</option>
                <option value="">Todas</option>
                <?php
                $filas = ObtenerCategorias();
                for ($i = 0; $i < count($filas); $i++) {
                ?>
                    <option value=<?php echo $filas[$i]['id'] ?>> <?php echo $filas[$i]['nombre'] ?> </option>
                <?php
                }
                ?>
            </select>
        </form>
    </div>
    <div>
        <?php

        $filas = ObtenerEquipos();

        for ($i = 0; $i < count($filas); $i++) {
        ?>
            <div class="equipo" data-categoria="<?php echo ($filas[$i]['id_categoria']); ?>">
                <p> <?php echo $filas[$i]['nombre'] ?> </p>
                <p> <?php echo $filas[$i]['marca'] ?> </p>
                <p> <?php echo $filas[$i]['modelo'] ?> </p>
                <p> <?php echo date("d/m/Y", strtotime($filas[$i]['fecha_compra']));  ?> </p>
                <p> <?php echo $filas[$i]['ubicacion'] ?> </p>
                <p> <?php echo $filas[$i]['descripcion'] ?> </p>
                <p> <?php print_r(ObtenerCategoriaPorId($filas[$i]['id_categoria'])['nombre']) ?> </p>
                <p> <?php print_r(ObtenerProveedorPorId($filas[$i]['id_categoria'])['nombre']) ?> </p>
                <div>
                    <p> <?php echo $filas[$i]['estado'] ?> </p>
                    <select name="txtEstado" id="txtEStado" onchange="CambiarEstado(<?php echo $filas[$i]['id']; ?>, this.value)">
                        <option disabled selected value="">Seleccionar</option>
                        <option value="Disponible">Disponible</option>
                        <option value="En uso">En uso</option>
                        <option value="En mantenimiento">En mantenimiento</option>
                        <option value="Fuera de servicio">Fuera de servicio</option>
                    </select>
                </div>
                <div>
                    <button type="button" name="btnDarDeBaja" id="btnDarDeBaja" value="<?php echo $filas[$i]['id'] ?>" onclick="DarDeBaja(this.value)">Dar de baja</button>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>