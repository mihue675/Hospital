<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";


function AltaContrato($id_proveedor, $fecha_expiracion, $terminos, $costos)
{
    global $conn;
    $sql = "INSERT INTO contratos(id_proveedor,fecha_expiración,terminos,costos) VALUES ('$id_proveedor','$fecha_expiracion','$terminos','$costos')";

    mysqli_query($conn, $sql);
}

function ObtenerContratos() {
    global $conn;
    $sql = "SELECT contratos.id, contratos.fecha_expiración, contratos.terminos, contratos.costos, proveedores.nombre AS nombre_proveedor
            FROM contratos
            JOIN proveedores ON contratos.id_proveedor = proveedores.id";
    
    $result = mysqli_query($conn, $sql);
    $contratos = [];

    while ($fila = mysqli_fetch_assoc($result)) {
        $contratos[] = $fila;
    }

    return $contratos;
}

function ObtenerContratoPorId($id_contrato) {
    global $conn;
    $sql = "SELECT * FROM contratos WHERE id = '$id_contrato'";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}

function EditarContrato($id_contrato, $id_proveedor, $fecha_expiracion, $terminos, $costos) {
    global $conn;
    $sql = "UPDATE contratos 
            SET id_proveedor = '$id_proveedor', fecha_expiración = '$fecha_expiracion', terminos = '$terminos', costos = '$costos'
            WHERE id = '$id_contrato'";

    mysqli_query($conn, $sql);
}

function EliminarContrato($id_contrato) {
    global $conn;
    $sql = "DELETE FROM contratos WHERE id = '$id_contrato'";
    mysqli_query($conn, $sql);
}