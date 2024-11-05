<?php
    require_once __DIR__ . "/../db.php";

function AltaConsumible($nombre, $cantidad, $cantidad_minima){
    global $conn;
    $sql = "INSERT INTO consumibles(nombre, cantidad, cantidad_minima) VALUES ('$nombre', $cantidad, $cantidad_minima)";
    mysqli_query($conn, $sql);
}

function ObtenerConsumibles()
{
    global $conn;
    $sql = "SELECT * FROM consumibles";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}