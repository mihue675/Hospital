<?php 
    session_start();
    if (!isset($_SESSION['idUsuario'])) {
        header("Location: ./pages/equipos/index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link href="error-permisos.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/logo.png" />
    <title>Error</title>
</head>
<body>
    <h1>Acceso denegado.</h1>
    <p>No tienes permisos para acceder a esta página.</p>
    <div>
    <button type="button" onclick="window.location.href = './index.php'">Volver al inicio</button>
    </div>
</body>
</html>