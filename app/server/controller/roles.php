<?php
require_once __DIR__ . "/../db.php";
function AsignarRol($id_usuario, $id_rol)
{
    global $conn;
    $sql = "UPDATE usuarios SET id_rol = $id_rol WHERE id = $id_usuario";
    mysqli_query($conn, $sql);
}

function ObtenerRolPorId($id)
{
    global $conn;
    $sql = "SELECT * FROM roles WHERE id = $id";
    $query = mysqli_query($conn, $sql);

    $resultado = mysqli_fetch_array($query, MYSQLI_ASSOC);

    return $resultado;
}

function ObtenerRoles()
{
    global $conn;
    $sql = "SELECT * FROM roles";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}