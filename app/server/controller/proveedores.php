<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";

function ObtenerProveedores()
{
    global $conn;
    $sql = "SELECT * FROM proveedores";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}

function ObtenerProveedorPorId($id)
{
    global $conn;
    $sql = "SELECT * FROM proveedores WHERE id = $id";
    $query = mysqli_query($conn, $sql);

    $resultado = mysqli_fetch_array($query, MYSQLI_ASSOC);

    return $resultado;
}
