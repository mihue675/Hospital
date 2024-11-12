<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
    exit();
}

if (isset($_SESSION['idUsuario']) && $_SESSION['id_rol'] != 3) {
    header("Location: ../../error-permisos.php");
}

include_once __DIR__ . "/../../../server/controller/equipos.php";
include_once __DIR__ . "/../../../server/controller/mantenimientos.php";

$id_tecnico = $_SESSION['idUsuario'];

// Procesamiento de formulario
if (isset($_POST['finalizar_mantenimiento'])) {
    BajaMantenimiento($_POST['id_mantenimiento']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de mantenimientos</title>
    <link rel="stylesheet" href="control.css" />
    <link rel="stylesheet" href="../../components/header.css" />
    <link rel="stylesheet" href="../../components/footer.css" />
    <link rel="icon" href="../../images/logo.png" />
</head>
<body>

<header>
    <?php require("../../components/header.php"); ?>
</header>

<div class="contenedor-titulos">
    <h2 style="text-align: center; font-weight: bold;">Mis mantenimientos</h2>
</div>

<div class="contenedor-btn">
    <button class="btn" onclick="window.location.href='./index.php'">Volver</button>
</div>

<div class="contenedor">
    <?php
    $filas = ObtenerMantenimientosPorTecnico($id_tecnico);

    if (empty($filas)) : ?>
        <p style="text-align: center; font-weight: bold;">Usted no tiene ningún mantenimiento asignado</p>
    <?php else : 
        foreach ($filas as $fila) :
            $fecha_actual = new DateTime();
            $fecha_vencimiento = new DateTime($fila['fecha']);
            $dias_restantes = $fecha_actual->diff($fecha_vencimiento)->days;
            $id_mantenimiento = $fila['id'];
            $id_equipo = $fila['id_equipo'];
            $tipo_mantenimiento = $fila['tipo'];
            $equipo = ObtenerEquipoPorId($id_equipo);
            ?>

            <div class="mantenimiento" data-tecnico="<?= $fila['id_tecnico'] ?>" data-vencimiento="<?= $fila['fecha'] ?>" data-tipo="<?= $tipo_mantenimiento ?>">
                <p><strong>Equipo:</strong> <?= $equipo['nombre'] ?></p>
                
                <?php if ($fila['fecha'] != "0000-00-00") : ?>
                    <p><strong>Próximo mantenimiento:</strong> <?= $fila['fecha'] ?></p>
                <?php endif; ?>
                
                <p><strong>Tipo:</strong> <?= $tipo_mantenimiento ?></p>

                <?php if (!empty($fila['descripcion'])) : ?>
                    <p><strong>Descripción:</strong> <?= $fila['descripcion'] ?></p>
                <?php endif; ?>

                <?php if ($tipo_mantenimiento == "Preventivo") : ?>
                    <?php if ($fecha_vencimiento > $fecha_actual) : ?>
                        <p><strong>Días restantes para el próximo mantenimiento:</strong> <?= $dias_restantes ?> días</p>
                    <?php elseif ($fecha_vencimiento == $fecha_actual) : 
                        CambiarEstado($id_equipo, "En mantenimiento"); ?>
                        <p><strong>Estado:</strong> En mantenimiento (Hoy es el día del mantenimiento preventivo)</p>
                    <?php endif; ?>
                <?php endif; ?>

                <form method="post">
                    <input type="hidden" name="id_mantenimiento" value="<?= $id_mantenimiento ?>">
                    <button type="submit" name="finalizar_mantenimiento">Finalizar</button>
                </form>
            </div>
        <?php endforeach; 
    endif; ?>
</div>

<footer>
    <?php require("../../components/footer.php"); ?>
</footer>

</body>
</html>