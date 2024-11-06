<?php 
    session_start();
    if (!isset($_SESSION['idUsuario'])) {
        header("Location: ./pages/equipos/index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="sobreNosotros.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/logo.png" />
    <title>Sobre Nosotros</title>
</head>
<body>
    <header>
        <?php require("./components/header.php") ?>
        <style>
            <?php require("./components/header.css") ?>
        </style>
    </header>

    <div class="contenedor">
    <section class="universidad">
        <h2>Universidad Católica de Santiago del Estero</h2>
        <p>Facultad de Ciencias Para la Innovación y el Desarrollo</p>
        <p>Ingeniería en Informática</p>
        <p>Año-2024</p>
        <hr>
        <h3>Proyecto Web: Gestión de Equipos Médicos en Hospital</h3>
    </section>
    <section class="integrantes">
        <h2>Integrantes del Equipo</h2>
        <ul>
            <li>José Samir Antonio</li>
            <li>Trejo Arce Luisana Paola</li>
            <li>Calviño Lautaro Alexis</li>
            <li>Slamich José Rafael</li>
        </ul>
    </section>
    <section class="proyecto">
        <h2>Descripción del Proyecto</h2>
        <p>Nuestro proyecto consiste en el desarrollo de un sistema web que permita gestionar eficientemente los equipos médicos de un hospital, abordando múltiples aspectos críticos de su administración. Este sistema ofrece funcionalidades para llevar un control exhaustivo del inventario, permitiendo registrar equipos con sus detalles completos (nombre, marca, modelo, ubicación, entre otros) y categorizarlos por tipo, estado actual y ubicación. Además, incluye una sección de mantenimiento, en la que se pueden programar intervenciones preventivas, registrar el historial de mantenimiento de cada equipo y generar alertas automáticas cuando un equipo requiera revisión.</p>
        <p>El sistema también facilita la gestión de la disponibilidad y uso de los equipos, permitiendo reservas por parte del médico personal y proporcionando una visualización en tiempo real del estado de cada equipo. Asimismo, administra los consumibles asociados, como electrodos y baterías, y envía notificaciones cuando el stock está bajo. También incluye un módulo para el manejo de proveedores y contratos, donde se registran las garantías y acuerdos de servicio, generando alertas cuando las garantías están próximas a expirar.</p>    
        <p>Para una mayor seguridad y control, el sistema cuenta con autenticación de usuarios y asignación de roles, lo que permite diferenciar accesos y permisos entre administradores, técnicos de mantenimiento y médico personal. Por último, ofrece la capacidad de generar informes detallados sobre el estado, uso y mantenimiento de los equipos, proporcionando datos útiles para la toma de decisiones.</p>
        <p>Nuestro proyecto busca optimizar la gestión de los recursos médicos del hospital, mejorando la eficiencia operativa y la disponibilidad de los equipos para garantizar la continuidad de los servicios de salud.</p>
        
    </section>
    </div>

    <footer>
        <?php require("./components/footer.php") ?>
        <style>
            <?php require("./components/footer.css")  ?>
        </style>
    </footer>
</body>
</html>