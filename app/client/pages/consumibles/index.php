<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <html translate="no">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumibles </title>
    <link rel="icon" href="../../images/logo.png" />
    <link rel="stylesheet" href="index.css"/>
</head>

<?php
require_once __DIR__ . "/../../../server/controller/consumibles.php";
?>

<body>

    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>
    <div>
        <button type="button" onclick="window.location.href = './alta.php'" class="btn-alta">Nuevo consumible</button>
    </div>
    <div class="contenedor">
    <?php
        $filas = ObtenerConsumibles();
        for ($i = 0; $i < count($filas); $i++) {
        ?>
        <div class="consumible">
            <p><strong>Nombre: </strong> <?php echo $filas[$i]['nombre'] ?> </p>
            <p><strong>Cantidad: </strong> 
                <?php 
                    if ($filas[$i]['cantidad'] <= $filas[$i]['cantidad_minima']) {
                        echo "<span >" . $filas[$i]['cantidad']  . "<span class='bajo-stock'>¡Bajo stock!</span>" . "</span>";
                    } else {
                        echo $filas[$i]['cantidad'];
                    }
                ?> 
            </p>
            <p><strong>Cantidad mínima: </strong> <?php echo $filas[$i]['cantidad_minima'] ?> </p>
            <button class="btnEditar" onclick="window.location.href='./editar.php?id=<?= $filas[$i]['id'] ?>'">Editar</button>
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