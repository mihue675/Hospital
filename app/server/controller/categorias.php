<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";

function AltaCategoria($categoria){
    global $conn;
    $sql = "INSERT INTO categorias (nombre) VALUES ('$categoria')";
    mysqli_query($conn, $sql);
}


function ObtenerCategorias()
{
    global $conn;
    $sql = "SELECT * FROM categorias";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}

function ObtenerCategoriaPorId($id)
{
    global $conn;
    $sql = "SELECT * FROM categorias WHERE id = $id";
    $query = mysqli_query($conn, $sql);

    $resultado = mysqli_fetch_array($query, MYSQLI_ASSOC);

    return $resultado;
}
