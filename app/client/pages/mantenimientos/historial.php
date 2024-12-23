<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
    exit();
}

if (isset($_SESSION['idUsuario']) && $_SESSION['id_rol'] == 2) {
    header("Location: ../../error-permisos.php");
}

include_once __DIR__ . "/../../../server/controller/equipos.php";
include_once __DIR__ . "/../../../server/controller/historial-mantenimientos.php";
include_once __DIR__ . "/../../../server/controller/reservas.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
    <h2 style="text-align: center; font-weight: bold;">Historial de mantenimientos</h2>
</div>

<div class="contenedor-btn">
    <button class="btn" onclick="window.location.href='./index.php'">Volver</button>
</div>

<div class="contenedor">
    <?php
    $filas = ObtenerHistorialMantenimientos();

    if (empty($filas)) : ?>
        <p style="text-align: center; font-weight: bold;">El historial de mantenimientos esta vacio.</p>
    <?php else : 
        foreach ($filas as $fila) :
            $id_equipo = $fila['id_equipo'];
            $tipo_mantenimiento = $fila['tipo'];
            $equipo = ObtenerEquipoPorId($id_equipo);
            ?>

            <div class="mantenimiento" data-tecnico="<?= $fila['id_tecnico'] ?>" data-vencimiento="<?= $fila['fecha'] ?>" data-tipo="<?= $tipo_mantenimiento ?>">
                <p><strong>Equipo:</strong> <?= $equipo['nombre'] ?></p>
                
                <?php if ($fila['fecha'] != "0000-00-00") : ?>
                    <p><strong>Fecha:</strong> <?= $fila['fecha'] ?></p>
                <?php endif; ?>
                
                <p><strong>Tipo:</strong> <?= $tipo_mantenimiento ?></p>

                <?php if (!empty($fila['descripcion'])) : ?>
                    <p><strong>Descripción:</strong> <?= $fila['descripcion'] ?></p>
                <?php endif; ?>

            </div>
        <?php endforeach; 
    endif; ?>
</div>

<footer>
    <?php require("../../components/footer.php"); ?>
</footer>   
</body>
</html>