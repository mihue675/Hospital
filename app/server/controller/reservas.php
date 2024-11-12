<?php
require_once __DIR__ . "/../db.php";

function ObtenerReservasPorEquipo($id_equipo) {
    global $conn;
    $sql = "SELECT id, id_usuario, fecha_inicio, fecha_fin, prioridad FROM reservas WHERE id_equipo = $id_equipo";
    $query = mysqli_query($conn, $sql);

    $reservas = array();
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $reservas[] = $row;
    }

    return $reservas;
}


function CrearReserva($id_equipo, $id_usuario, $fecha_inicio, $fecha_fin, $prioridad) {
    global $conn;
    $sql = "INSERT INTO reservas (id_equipo, id_usuario, fecha_inicio, fecha_fin, prioridad) VALUES ($id_equipo, $id_usuario, '$fecha_inicio', '$fecha_fin', '$prioridad')";
    mysqli_query($conn, $sql);
}

function EliminarReserva($id_reserva) {
    global $conn;
    $sql = "DELETE FROM reservas WHERE id = $id_reserva";
    mysqli_query($conn, $sql);
}

function ObtenerReservas()
{
    global $conn;
    $sql = "SELECT * FROM reservas";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}

function ObtenerEstadisticasEquiposPorDias() {
    $reservas = ObtenerReservas();
    $estadisticas = [];

    foreach ($reservas as $reserva) {
        $id_equipo = $reserva['id_equipo'];
        
        // Calcular la cantidad de días de la reserva
        $fecha_inicio = new DateTime($reserva['fecha_inicio']);
        $fecha_fin = new DateTime($reserva['fecha_fin']);
        $dias_reserva = $fecha_fin->diff($fecha_inicio)->days;

        // Sumar los días al equipo correspondiente
        if (!isset($estadisticas[$id_equipo])) {
            $estadisticas[$id_equipo] = $dias_reserva;
        } else {
            $estadisticas[$id_equipo] += $dias_reserva;
        }
    }

    // Ordenar los equipos por días reservados de mayor a menor
    arsort($estadisticas);

    return $estadisticas;
}

