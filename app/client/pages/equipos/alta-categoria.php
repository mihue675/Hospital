<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}

if (isset($_SESSION['idUsuario']) && $_SESSION['id_rol'] != 1) {
    header("Location: ../../error-permisos.php");
}


require_once __DIR__ . "/../../../server/controller/equipos.php";
require_once __DIR__ . "/../../../server/controller/categorias.php";

if (isset($_POST['btnAltaCategoria']) && $_POST['txtCategoria'] != "") {
    $categoria = $_POST['txtCategoria'];
    AltaCategoria($categoria);
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta categorias</title>
    <link href="alta.css" rel="stylesheet">
    <link rel="icon" href="../../images/logo.png" />
</head>
<body>
<header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>

    <div style="display:flex; justify-content: center; margin-top:100px; padding-bottom: 30px;">
        <form method="post" action="./alta-categoria.php">
            <h1>Alta de Categorias</h1>
            <label>
                Categoria:
                <input type="text" name="txtCategoria" id="txtCategoria" value="" required />
            </label>
            <br />

            <button type="button" onclick="window.location.href = './index.php'">Volver</button>
            <button type="submit" name="btnAltaCategoria" id="btnAltaCategoria">Alta</button>
        </form>
    </div>



    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css")  ?>
        </style>
    </footer>
    
</body>
</html>