<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}

if (isset($_SESSION['idUsuario']) && $_SESSION['id_rol'] != 1) {
    header("Location: ../../error-permisos.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <html translate="no">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Historial</title>
    <link rel="icon" href="../../images/logo.png" />
    <link rel="stylesheet" href="historial.css" />
</head>


<?php
require_once __DIR__ . "/../../../server/controller/reservas.php";
require_once __DIR__ . "/../../../server/controller/equipos.php";
require_once __DIR__ . "/../../../server/controller/usuarios.php";

?>

<body>

    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>

    <div class="h1">
        <h1>Historial de reservas</h1>
    </div>

    <div class="contenedor">
        <?php
        $filas = ObtenerReservas();
        for ($i = 0; $i < count($filas); $i++) {
        ?>
            <div class="reserva">
                <p><strong>Equipo: </strong><?php echo ObtenerEquipoPorId($filas[$i]['id_equipo'])['nombre'] ?></p>
                <p><strong>Usuario:</strong> <?php echo ObtenerUsuarioPorId($filas[$i]['id_usuario'])['nombre'] . " " . ObtenerUsuarioPorId($filas[$i]['id_usuario'])['apellido'] ?></p>
                <p><strong>Fecha de inicio:</strong> <?php echo $filas[$i]['fecha_inicio'] ?></p>
                <p><strong>Fecha de fin:</strong> <?php echo $filas[$i]['fecha_fin'] ?></p>
                <p><strong>Prioridad:</strong> <?php echo $filas[$i]['prioridad'] ?></p>
            </div>
        <?php
        }

        ?>


    </div>

    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css")  ?>
        </style>
    </footer>
</body>

</html>