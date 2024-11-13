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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimientos - Historial</title>
    <link rel="icon" href="../../images/logo.png" />
    <link rel="stylesheet" href="index.css" />

    <script>
        function AsignarTecnico(id_mantenimiento, id_tecnico) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualiza la interfaz de usuario.
                    location.reload();
                }
            };
            xhr.send("id=" + id_mantenimiento + "&tecnico=" + id_tecnico); // Enviar el id y el nuevo tecnico.
        }

        function FiltrarMantenimientosPorVencimiento() {
            let vencimientoSeleccionado = document.getElementById("selectPorVencimiento").value;
            const mantenimientos = document.getElementsByClassName("mantenimiento");
            let fechaDeHoy = new Date();

            Array.from(mantenimientos).forEach(mantenimiento => {
                let fechaMantenimientoStr = mantenimiento.getAttribute("data-vencimiento");
                let fechaMantenimiento = null;

                if (fechaMantenimientoStr && fechaMantenimientoStr !== "0000-00-00") {
                    fechaMantenimiento = new Date(fechaMantenimientoStr);
                }

                if (vencimientoSeleccionado === "" || vencimientoSeleccionado === "Todos") {
                    mantenimiento.style.display = "block"; // Mostrar todos los mantenimientos
                } else if (vencimientoSeleccionado === "Vencidos") {
                    if (fechaMantenimiento && fechaMantenimiento < fechaDeHoy) {
                        mantenimiento.style.display = "block";
                    } else {
                        mantenimiento.style.display = "none";
                    }
                } else if (vencimientoSeleccionado === "Prox") {
                    if (fechaMantenimiento && fechaMantenimiento > fechaDeHoy) {
                        mantenimiento.style.display = "block";
                    } else {
                        mantenimiento.style.display = "none";
                    }
                }
            });
            window.document.getElementById("selectPorVencimiento").value = "";
        }

        function FiltrarMantenimientosPorTecnico() {
            let tecnicoSeleccionado = document.getElementById("selectPorTecnicoAsignado").value;
            const mantenimientos = document.getElementsByClassName("mantenimiento");

            Array.from(mantenimientos).forEach((mantenimiento) => {
                const idTecnico = mantenimiento.getAttribute("data-tecnico");
                console.log(idTecnico)
                console.log(tecnicoSeleccionado)
                if (tecnicoSeleccionado == "" || tecnicoSeleccionado == "Todos") {
                    mantenimiento.style.display = "block";
                } else if (tecnicoSeleccionado == "SinTecnicoAsignado") {
                    if (!idTecnico) {
                        mantenimiento.style.display = "block";
                    } else {
                        mantenimiento.style.display = "none";
                    }
                } else {
                    if (idTecnico == tecnicoSeleccionado) {
                        mantenimiento.style.display = "block";
                    } else {
                        mantenimiento.style.display = "none";
                    }
                }
            })
            window.document.getElementById("selectPorTecnicoAsignado").value = "";
        }

        function FiltrarMantenimientosPorTipo() {
            let tipoSeleccionado = document.getElementById("selectPorTipoDeMantenimiento").value;
            const mantenimientos = document.getElementsByClassName("mantenimiento");

            Array.from(mantenimientos).forEach((mantenimiento) => {
                const tipo = mantenimiento.getAttribute("data-tipo");

                if (tipoSeleccionado == "" || tipoSeleccionado == "Todos") {
                    mantenimiento.style.display = "block";
                } else if (tipoSeleccionado == "Correctivo") {
                    if (tipo == "Correctivo") {
                        mantenimiento.style.display = "block";
                    } else {
                        mantenimiento.style.display = "none";
                    }
                } else if (tipoSeleccionado == "Preventivo") {
                    if (tipo == "Preventivo") {
                        mantenimiento.style.display = "block";
                    } else {
                        mantenimiento.style.display = "none";
                    }
                }
            })
            window.document.getElementById("selectPorTecnicoAsignado").value = "";
        }
    </script>
</head>

<?php
require_once __DIR__ . "/../../../server/controller/mantenimientos.php";
require_once __DIR__ . "/../../../server/controller/usuarios.php";
require_once __DIR__ . "/../../../server/controller/equipos.php";
if (isset($_POST['tecnico']) && $_POST['tecnico'] != "") {
    $id_mantenimiento = $_POST['id'];
    $tecnico = $_POST['tecnico'];
    AsignarTecnico($id_mantenimiento, $tecnico);
}
?>

<body>

    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>

    <div class="contenedor-contenedor-filtros">
        <div class="contenedor-filtros">
            <span>Filtrar mantenimientos:</span>
            <div class="filtro">
                <select name="selectPorVencimiento" id="selectPorVencimiento" onchange="FiltrarMantenimientosPorVencimiento()">
                    <option disabled selected value="">Por vencimiento</option>
                    <option value="Todos">Todos</option>
                    <option value="Vencidos">Vencidos</option>
                    <option value="Prox">Próximos a vencer</option>
                </select>
                <select name="selectPorTecnicoAsignado" id="selectPorTecnicoAsignado" onchange="FiltrarMantenimientosPorTecnico()">
                    <option disabled selected value="">Por técnico asignado</option>
                    <option value="SinTecnicoAsignado">Sin técnico asignado</option>
                    <option value="Todos">Todos</option>
                    <?php
                    $filas = ObtenerTecnicos();
                    for ($i = 0; $i < count($filas); $i++) {
                    ?>
                        <option value="<?php echo $filas[$i]['id'] ?>"><?php echo $filas[$i]['nombre'] . " " . $filas[$i]['apellido'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <select name="selectPorTipoDeMantenimiento" id="selectPorTipoDeMantenimiento" onchange="FiltrarMantenimientosPorTipo()">
                    <option>Por tipo de mantenimiento</option>
                    <option value="Todos">Todos</option>
                    <option value="Preventivo">Preventivo</option>
                    <option value="Correctivo">Correctivo</option>
                </select>
            </div>
        </div>
    </div>

    <div class="contenedor-btn">
        <button class="btn" onclick="window.location.href='./alta.php'">Nuevo mantenimiento</button>
        <button class="btn" onclick="window.location.href='./historial.php'">Historial de mantenimientos</button>
    </div>

    <div class=" contenedor">
        <?php
        $filas = ObtenerMantenimientos();
        for ($i = 0; $i < count($filas); $i++) {
        ?>
            <div class="mantenimiento" data-tecnico="<?php echo ($filas[$i]['id_tecnico']); ?>" data-vencimiento="<?php echo $filas[$i]['fecha'] ?>" data-tecnico="<?php echo $filas[$i]['id_tecnico'] ?>" data-tipo=<?php echo $filas[$i]['tipo'] ?>>
                <p><strong>Equipo: </strong><?php print_r(ObtenerEquipoPorId($filas[$i]['id_equipo'])['nombre'])  ?></p>
                <?php if ($filas[$i]['fecha'] != "0000-00-00" && $filas[$i]['fecha']) { ?><p><strong>Próximo mantenimiento: </strong> <?php $newDate = date("d/m/Y", strtotime($filas[$i]['fecha'])); echo $newDate ?> </p> <?php } ?>
                <p><strong>Tipo:</strong> <?php echo $filas[$i]['tipo'] ?></p>
                <?php if ($filas[$i]['descripcion'] != "") { ?><p><strong>Descripción:</strong> <?php echo $filas[$i]['descripcion'] ?> </p> <?php } ?>
                <div>
                    <p><strong>Técnico: </strong> <?php
                                                    if (isset($filas[$i]['id_tecnico'])) {
                                                        print_r(ObtenerUsuarioPorId($filas[$i]['id_tecnico'])['nombre'] . " " . ObtenerUsuarioPorId($filas[$i]['id_tecnico'])['apellido']);
                                                    } else {
                                                        echo "SIN ASIGNAR";
                                                    }
                                                    ?> </p>
                    <select name="txtTecnico" id="txtTecnico" onchange="AsignarTecnico(<?php echo $filas[$i]['id'] ?>, this.value)">
                        <option disabled selected value="">Asignar Técnico</option>
                        <?php
                        $filasTecnicos = ObtenerTecnicos();
                        for ($j = 0; $j < count($filasTecnicos); $j++) {
                        ?>
                            <option value="<?php echo $filasTecnicos[$j]['id'] ?>"><?php echo $filasTecnicos[$j]['nombre'] . " " . $filasTecnicos[$j]['apellido'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css")  ?>
        </style>
    </footer>
</body>

</html>