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


