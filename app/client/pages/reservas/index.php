<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}

if (isset($_SESSION['idUsuario']) && $_SESSION['id_rol'] == 3) {
    header("Location: ../../error-permisos.php");
}

include '../../components/calendar.php';
include_once __DIR__ . "/../../../server/controller/equipos.php";
include_once __DIR__ . "/../../../server/controller/reservas.php";
include_once __DIR__ . "/../../../server/controller/usuarios.php";
$calendar = new Calendar(); // esto es un import que encontre, tiene add_event(nombreEvento, fechaInicio, dias, color), con eso hacemos todo
$id_usuario = $_SESSION["idUsuario"];

if (!empty($_POST['txtEquipoReserva'])) {
    $id_equipo = $_POST['txtEquipoReserva'];
    $reservas = ObtenerReservasPorEquipo($id_equipo);
    foreach ($reservas as $reserva) {
        $idAutorReserva = $reserva['id_usuario'];
        $nombreAutor = ObtenerUsuarioPorId($idAutorReserva);
        $nombreAutor = $nombreAutor['nombre'];
        $color = $reserva['prioridad'] == 'Alta' ? 'red' : 'yellow';
        $calendar->add_event($nombreAutor, $reserva['fecha_inicio'], (strtotime($reserva['fecha_fin']) - strtotime($reserva['fecha_inicio'])) / 86400 + 1, $color);
        // esto de arriba es el add event del calendario, lo usamos para cargar todas las reservas x cada equipo
    }
}

if (isset($_POST['btnAsignar'])) {
    $id_equipo = $_POST['txtEquipoReserva'];
    $fecha_inicio = $_POST['txtFechaInicio'];
    $fecha_fin = $_POST['txtFechaFin'];
    $prioridad = $_POST['txtPrioridad'];

    // empezamos asumiendo q no hay conflicto
    $reservas_existentes = ObtenerReservasPorEquipo($id_equipo);
    $conflicto = false;

    foreach ($reservas_existentes as $reserva) {
        // las fechas se solapan?
        $hay_conflicto_fechas = $fecha_inicio <= $reserva['fecha_fin'] && $fecha_fin >= $reserva['fecha_inicio'];

        if ($hay_conflicto_fechas) {
            if ($prioridad === "Baja") {
                $conflicto = true;
                echo "<script>alert('Conflicto con otra reserva. Si es de urgencia, intente reservar con alta prioridad.');</script>";
                break;
            } elseif ($prioridad === "Alta") {
                if ($reserva['prioridad'] === "Baja") {
                    EliminarReserva($reserva['id']);
                } elseif ($reserva['prioridad'] === "Alta") {
                    $conflicto = true;  // marcar conflicto en caso de prioridad alta
                    echo "<script>alert('Conflicto con una reserva de alta prioridad existente. No se puede realizar la nueva reserva.');</script>";
                    break;
                }
            }
        }
    }

    if (!$conflicto) { // creamos solo si no hay conflictos.
        CrearReserva($id_equipo, $id_usuario, $fecha_inicio, $fecha_fin, $prioridad);
        header("Location: index.php?txtEquipoReserva=$id_equipo");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link rel="icon" href="../../images/logo.png" />
    <link rel="stylesheet" href="index.css" />
    <link href="../../components/calendar.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>
    <div class="contenedor-calendario">
        <div class="div formulario">
            <form method="post" action="index.php">
                <h2>Asignar una reserva</h2>
                </br>
                <select name="txtEquipoReserva" id="txtEquipoReserva" onchange="this.form.submit()"> <!-- todo depende de ese onchange, si no no se actualiza el calendario -->
                    <option disabled <?= empty($_POST['txtEquipoReserva']) ? 'selected' : '' ?> value="">Seleccionar
                        Equipo</option>
                    <?php
                    $filas = ObtenerEquipos();
                    foreach ($filas as $fila) {
                        $selected = isset($_POST['txtEquipoReserva']) && $_POST['txtEquipoReserva'] == $fila['id'] ? 'selected' : '';
                        echo "<option value='{$fila['id']}' $selected>{$fila['nombre']}</option>";
                    }
                    ?>
                </select>
                </br>
                <select name="txtPrioridad" id="txtPrioridad">
                    <option disabled selected value="">Prioridad</option>
                    <option value="Alta">Alta</option>
                    <option value="Baja">Baja</option>
                </select>
                </br>
                <label>
                    Fecha de inicio:
                    <input type="date" name="txtFechaInicio" id="txtFechaInicio" value="" required />
                </label>
                </br>
                <label>
                    Fecha fin:
                    <input type="date" name="txtFechaFin" id="txtFechaFin" value="" required />
                </label>
                </br>
                <button type="submit" name="btnAsignar" class="btn-alta">Reservar</button>
            </form>
        </div>

        <div class="calendario"> <!-- aqui se muestra el calendario nada mas-->
            <?php echo $calendar; ?>
        </div>
    </div>

    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css") ?>
        </style>
    </footer>
</body>

</html>