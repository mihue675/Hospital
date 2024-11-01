<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";

function ObtenerUsuarios()
{
    global $conn;
    $sql = "SELECT * FROM usuarios";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}

function ObtenerUsuarioPorId($id)
{
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $query = mysqli_query($conn, $sql);

    $resultado = mysqli_fetch_array($query, MYSQLI_ASSOC);

    return $resultado;
}

function ObtenerTecnicos()
{
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE id_rol = 3";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}
