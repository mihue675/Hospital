<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";


function ObtenerHistorialMantenimientos()
{
    global $conn;
    $sql = "SELECT * FROM historial_mantenimientos";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}