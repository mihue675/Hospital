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
            default:
                $fecha = NULL;
                break;
        }
    }

    global $conn;
    $sql = "INSERT INTO mantenimientos(id_equipo,fecha,tipo,descripcion)"
        . "VALUES ('$id_equipo','$fecha','$tipo','$descripcion')";

    mysqli_query($conn, $sql);
}

function ObtenerMantenimientos()
{
    global $conn;
    $sql = "SELECT * FROM mantenimientos";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}

function AsignarTecnico($id_mantenimiento, $id_tecnico)
{
    global $conn;
    $sql = "UPDATE mantenimientos SET id_tecnico = $id_tecnico WHERE id = $id_mantenimiento";
    mysqli_query($conn, $sql);
}

function ObtenerMantenimientosPorTecnico($id_tecnico)
{
    global $conn;
    $sql = "SELECT * FROM mantenimientos WHERE id_tecnico = $id_tecnico";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}

function TieneMantenimiento($id_equipo, $tipo):bool // tiene mantenimientos de ese tipo? si esta vacio el array, entonces no tiene.
{
    global $conn;
    $sql = "SELECT * FROM mantenimientos WHERE id_equipo = $id_equipo AND tipo = '$tipo' ";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    if (empty($array) ) {
        return false;
    }
    return true;
}

function BajaMantenimiento($id_mantenimiento)
{
    global $conn;

    $sql = "SELECT id_equipo FROM mantenimientos WHERE id = $id_mantenimiento";
    $query = mysqli_query($conn, $sql);
    $resultado = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $id_equipo = $resultado['id_equipo'];

    CambiarEstado($id_equipo, "Disponible");

    $sql = "DELETE FROM mantenimientos WHERE id = $id_mantenimiento";
    mysqli_query($conn, $sql);
}
