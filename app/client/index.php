 <?php
    session_start();
    if (isset($_SESSION['idUsuario'])) {
        header("Location: ./pages/equipos/index.php");
    }
    ?>

 <!DOCTYPE html>
 <html lang="es">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Inicio</title>
     <link rel="stylesheet" href="index.css">
     <link rel="icon" href="images/logo.png">
 </head>

 <body>

     <div class="intro-text">
         <h1>Gestión de equipos médicos. </h1>
         <p>Administra tus equipos médicos desde cualquier lugar. Mantén un control detallado del mantenimiento, inventario y estado de todos los equipos. Asegura que todo esté en orden para brindar la mejor atención.</p>
         <button onclick="window.location.href='pages/auth/iniciar-sesion.php'">Iniciar sesión</button>
     </div>
     <div class="intro-image">
         <img src="images/medicos-vector.png" alt="Imagen de Equipos Médicos">
     </div>

 </body>

 </html>