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
    <title>Equipos</title>
    <link href="index-equipos.css" rel="stylesheet">
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
        document.addEventListener("DOMContentLoaded", function() {
    const selectsEstado = document.querySelectorAll("select[name='txtEstado']");

    selectsEstado.forEach(select => {
        const equipoId = select.getAttribute("onchange").match(/\d+/)[0];
        const estadoTexto = document.getElementById("estadoTexto-" + equipoId);

        // Función para actualizar el texto y el color de fondo del estado
        function actualizarEstadoTexto(estado) {
            estadoTexto.classList.remove("disponible-bg", "en-uso-bg", "en-mantenimiento-bg", "fuera-de-servicio-bg");

            switch (estado) {
                case "Disponible":
                    estadoTexto.textContent = "Disponible";
                    estadoTexto.classList.add("disponible-bg");
                    break;
                case "En uso":
                    estadoTexto.textContent = "En uso";
                    estadoTexto.classList.add("en-uso-bg");
                    break;
                case "En mantenimiento":
                    estadoTexto.textContent = "En mantenimiento";
                    estadoTexto.classList.add("en-mantenimiento-bg");
                    break;
                case "Fuera de servicio":
                    estadoTexto.textContent = "Fuera de servicio";
                    estadoTexto.classList.add("fuera-de-servicio-bg");
                    break;
            }
        }

        // Enviar el estado seleccionado al servidor sin recargar
        select.addEventListener("change", function() {
            const nuevoEstado = select.value;

            // Llama a la función para actualizar el color localmente
            actualizarEstadoTexto(nuevoEstado);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Estado actualizado en el servidor");
                    // No recargamos la página, ya que el estado se ha actualizado localmente
                }
            };
            xhr.send("id=" + equipoId + "&estado=" + nuevoEstado); // Enviar el id y el nuevo estado
        });

        // Inicializa el estado con el valor actual
        actualizarEstadoTexto(select.value);
    });
});

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

<script>
    async function loadHeader() {
      const response = await fetch('../../components/header.html');
      const html = await response.text();
      document.getElementById('header').innerHTML = html;
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = '../../components/header.css';
      document.head.appendChild(link);
    }

    loadHeader();
</script>

<script>
    async function loadFooter() {
      const response = await fetch('../../components/footer.html');
      const html = await response.text();
      document.getElementById('footer').innerHTML = html;

      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = '../../components/footer.css';
      document.head.appendChild(link);
    }

    loadFooter();
</script>


<body>
    <div id="header"></div>
    <div>
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
                <p><strong>Nombre:</strong> <?php echo $equipo['nombre']; ?></p>
                <p><strong>Marca:</strong> <?php echo $equipo['marca']; ?></p>
                <p><strong>Modelo:</strong> <?php echo $equipo['modelo']; ?></p>
                <p><strong>Numero de serie:</strong> <?php echo $equipo['num_serie']; ?></p>
                <p><strong>Fecha de compra:</strong> <?php echo date("d/m/Y", strtotime($equipo['fecha_compra'])); ?></p>
                <p><strong>Ubicacion:</strong> <?php echo $equipo['ubicacion']; ?></p>
                <p><strong>Descripcion:</strong> <?php echo $equipo['descripcion']; ?></p>
                <p><strong>Categoria:</strong> <?php echo ObtenerCategoriaPorId($equipo['id_categoria'])['nombre']; ?></p>
                <p><strong>Proveedor:</strong> <?php echo ObtenerProveedorPorId($equipo['id_categoria'])['nombre']; ?></p>
                
                <div class="estado">
                    <p><span id="estadoTexto-<?php echo $equipo['id']; ?>"><?php echo $equipo['estado']; ?></span></p>
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
    </div>
    
    <div id="footer"></div>
</body>


</html>