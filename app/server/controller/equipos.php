<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";

function AltaEquipo($nombre, $marca, $modelo, $numeroDeSerie, $fechaDeCompra, $ubicacion, $descripcion, $categoria, $proveedor)
{
    global $conn;
    $sql = "INSERT INTO equipos(nombre,marca,modelo,num_serie,fecha_compra,ubicacion,descripcion,id_categoria,id_proveedor)"
        . "VALUES ('$nombre','$marca','$modelo',$numeroDeSerie,'$fechaDeCompra','$ubicacion','$descripcion',$categoria,$proveedor)";

    mysqli_query($conn, $sql);
}

function BajaEquipo($id)
{
    global $conn;
    $sql = "DELETE FROM equipos WHERE id = $id";
    mysqli_query($conn, $sql);
}

function ObtenerEquipos()
{
    global $conn;
    $sql = "SELECT * FROM equipos";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}

function ObtenerEquiposPorCategoria($id_categoria)
{
    global $conn;
    $sql = "SELECT * FROM equipos WHERE id_categoria = $id_categoria";
    $query = mysqli_query($conn, $sql);

    $array = array();
    while ($i = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $array[] = $i;
    }

    return $array;
}

function ObtenerEquipoPorId($id)
{
    global $conn;
    $sql = "SELECT * FROM equipos WHERE id = $id";
    $query = mysqli_query($conn, $sql);

    $resultado = mysqli_fetch_array($query, MYSQLI_ASSOC);

    return $resultado;
}

function CambiarEstado($id, $estado)
{
    global $conn;
    $sql = "UPDATE equipos SET estado = '$estado' WHERE id = $id";
    mysqli_query($conn, $sql);
}
