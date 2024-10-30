<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";

function AltaEquipo($nombre, $marca, $modelo, $numeroDeSerie, $fechaDeCompra, $ubicacion, $descripcion, $categoria, $proveedor)
{
    global $conn;
    $sql = "INSERT INTO equipos(nombre,marca,modelo,num_serie,fecha_compra,ubicacion,descripcion,id_categoria,id_proveedor)"
        . "VALUES ('$nombre','$marca','$modelo',$numeroDeSerie,$fechaDeCompra,'$ubicacion','$descripcion',$categoria,$proveedor)";

    mysqli_query($conn, $sql);
}
