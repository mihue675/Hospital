<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";

function AltaMantenimiento($id_equipo, $fecha = null, $tipo, $descripcion = null)
{
    if ($tipo == "Preventivo") {
        switch ($fecha) {
            case "Mensual":
                $fecha = new DateTime();
                $fecha->modify("+1 month");
                $fecha = $fecha->format('Y-m-d');
                break;
            case "Trimestral":
                $fecha = new DateTime();
                $fecha->modify("+3 month");
                $fecha = $fecha->format('Y-m-d');
                break;
            case "Anual":
                $fecha = new DateTime();
                $fecha->modify("+1 year");
                $fecha = $fecha->format('Y-m-d');
                break;
        }
    }

    global $conn;
    $sql = "INSERT INTO mantenimientos(id_equipo,fecha,tipo,descripcion)"
        . "VALUES ('$id_equipo','$fecha','$tipo','$descripcion')";

    mysqli_query($conn, $sql);
}
