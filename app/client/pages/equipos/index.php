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
    <title>Equipos</title>
    <link rel="stylesheet" href="index.css">
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
                    // Cambia el texto y el fondo sin recargar la página
                    const estadoTexto = document.getElementById("estadoTexto-" + id);
                    estadoTexto.textContent = estado;
                    estadoTexto.className = ""; // Quita todas las clases de fondo

                    // Asigna la clase de fondo según el estado seleccionado
                    switch (estado) {
                        case "Disponible":
                            estadoTexto.classList.add("disponible-bg");
                            break;
                        case "En uso":
                            estadoTexto.classList.add("en-uso-bg");
                            break;
                        case "En mantenimiento":
                            estadoTexto.classList.add("en-mantenimiento-bg");
                            break;
                        case "Fuera de servicio":
                            estadoTexto.classList.add("fuera-de-servicio-bg");
                            break;
                    }
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

    <script>
        function CambiarClassSegunEstado() {
            elementos = document.querySelectorAll("#estado")
            className = ""

            elementos.forEach(elemento => {
                switch (elemento.querySelector("span").textContent) {
                    case "Disponible":
                        className = "disponible-bg"
                        break
                    case "En uso":
                        className = "en-uso-bg";
                        break
                    case "En mantenimiento":
                        className = "en-mantenimiento-bg"
                        break
                    case "Fuera de servicio":
                        className = "fuera-de-servicio-bg"
                        break
                }

                elemento.querySelector("span").className = className
            });

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

    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>

    <div class="contenedor-filtros">
        <form method="post" action="index.php">
            <label for="txtCategoria">Filtrar por categoria</label>
            <select name="txtCategoria" id="txtCategoria" onchange="FiltrarEquipos()">
                <option disabled selected value="">Seleccionar</option>
                <option value="">Todas</option>
                <?php
                $filas = ObtenerCategorias();
                foreach ($filas as $categoria) {
                ?>
                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                <?php
                }
                ?>
            </select>
        </form>
    </div>

    <div class="contenedor-equipos">
        <?php
        $filas = ObtenerEquipos();
        foreach ($filas as $equipo) {
        ?>
            <div class="equipo" data-categoria="<?php echo $equipo['id_categoria']; ?>">
                <p class="p"><strong>Marca:</strong> <?php echo $equipo['marca']; ?></p>
                <p class="p"><strong>Nombre:</strong> <?php echo $equipo['nombre']; ?></p>
                <p class="p"><strong>Modelo:</strong> <?php echo $equipo['modelo']; ?></p>
                <p class="p"><strong>Numero de serie:</strong> <?php echo $equipo['num_serie']; ?></p>
                <p class="p"><strong>Fecha de compra:</strong> <?php echo date("d/m/Y", strtotime($equipo['fecha_compra'])); ?></p>
                <p class="p"><strong>Ubicacion:</strong> <?php echo $equipo['ubicacion']; ?></p>
                <p class="p"><strong>Descripcion:</strong> <?php echo $equipo['descripcion']; ?></p>
                <p class="p"><strong>Categoria:</strong> <?php echo ObtenerCategoriaPorId($equipo['id_categoria'])['nombre']; ?></p>
                <p class="p"><strong>Proveedor:</strong> <?php echo ObtenerProveedorPorId($equipo['id_categoria'])['nombre']; ?></p>

                <div class="estado" id="estado">
                    <span id="estadoTexto-<?php echo $equipo['id'] ?>"><?php echo $equipo['estado']; ?></span>
                    <select name="txtEstado" onchange="CambiarEstado(<?php echo $equipo['id']; ?>, this.value)">
                        <option disabled selected value="">Seleccionar</option>
                        <option value="Disponible">Disponible</option>
                        <option value="En uso">En uso</option>
                        <option value="En mantenimiento">En mantenimiento</option>
                        <option value="Fuera de servicio">Fuera de servicio</option>
                    </select>
                </div>

                <div>
                    <button type="button" onclick="DarDeBaja(<?php echo $equipo['id']; ?>)">Dar de baja</button>
                </div>

            </div>
        <?php
        }
        ?>

        <script>
            CambiarClassSegunEstado()
        </script>

    </div>

    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css")  ?>
        </style>
    </footer>
</body>

</html>