<?php
require_once __DIR__ . "/../../server/controller/mantenimientos.php";
require_once __DIR__ . "/../../server/controller/equipos.php";
require_once __DIR__ . "/../../server/controller/consumibles.php";

$idUsuario = $_SESSION['idUsuario'];

// Notificación de próximos mantenimientos.

$filas = ObtenerMantenimientosPorTecnico($idUsuario);

// Fecha actual
$hoy = new DateTime(); // La fecha de hoy
$diferenciasDias = []; // Array para almacenar las diferencias

// Filtrar elementos
$filasRecientes = array_filter($filas, function ($fila) use ($hoy, &$diferenciasDias) {
    $fechaMantenimiento = isset($fila['fecha']) ? new DateTime($fila['fecha']) : null;
    $tipo = $fila['tipo']; // Obtener el tipo de mantenimiento

    // Comprobar si es correctivo
    if ($tipo === 'Correctivo') {
        $diferenciasDias[] = null; // Añadir un valor nulo para correctivos
        return true; // Mantener el elemento en el filtro
    }

    // Si es preventivo, comprobar la fecha
    if ($tipo === 'Preventivo' && $fechaMantenimiento) {
        $intervalo = $hoy->diff($fechaMantenimiento);
        // Aquí verificamos que la diferencia de días sea positiva y dentro del rango deseado
        $diferenciaDias = (int)$intervalo->format('%a') + 1; // Obtener solo los días como entero

        // Almacenar solo las diferencias de los elementos filtrados
        if ($diferenciaDias <= 7 && $diferenciaDias >= 0) {
            array_push($diferenciasDias, $diferenciaDias); // Añadir la diferencia al array
            return true; // Mantener el elemento en el filtro
        }
    }

    return false; // Excluir el elemento
});

// Reindexar el array de filas recientes
$filasRecientes = array_values($filasRecientes);


// Notificación de baja de stock.
$filasConsumibles = ObtenerConsumibles();
$filasConsumibles = array_filter($filasConsumibles, function ($consumible) {
    return $consumible['cantidad'] < $consumible['cantidad_minima'];
});

$filasConsumibles = array_values($filasConsumibles);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <html translate="no">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./header.css" />
    <title>Document</title>
</head>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const notificationIcon = document.getElementById("notification-icon");
        const notificationsMenu = document.getElementById("notifications");

        // Alterna la visibilidad del menú de notificaciones al hacer clic en la campana
        notificationIcon.addEventListener("click", function(event) {
            event.stopPropagation(); // Previene que el evento se propague
            notificationsMenu.style.display = notificationsMenu.style.display === "block" ? "none" : "block";
        });

        // Oculta el menú de notificaciones si se hace clic fuera de él
        document.addEventListener("click", function(event) {
            if (!notificationIcon.contains(event.target) && !notificationsMenu.contains(event.target)) {
                notificationsMenu.style.display = "none";
            }
        });
    });

    document.addEventListener('mousedown', function(event) {
        if (event.detail > 1) {
            event.preventDefault();
        }
    }, false);
</script>


<body>
    <header class='main-header'>
        <nav class='nav-container'>
            <ul class='nav-menu'>
                <li class='has-submenu'>
                    <a>Servicios</a>
                    <ul class='submenu'>
                        <li><a href='http://localhost/Hospital/app/client/pages/equipos/'>Equipos</a></li>
                        <li style="<?php if ($_SESSION['id_rol'] != 1) echo "display: none;" ?>"><a href='http://localhost/Hospital/app/client/pages/mantenimientos/'>Mantenimientos</a></li>
                        <li style="<?php if ($_SESSION['id_rol'] != 1) echo "display: none;" ?>"><a href='http://localhost/Hospital/app/client/pages/proveedores/'>Proveedores y contratos</a></li>
                        <li style="<?php if ($_SESSION['id_rol'] != 1) echo "display: none;" ?>"><a href='http://localhost/Hospital/app/client/pages/consumibles/'>Consumibles</a></li>
                        <li style="<?php if ($_SESSION['id_rol'] == 3) echo "display: none;" ?>"><a href='http://localhost/Hospital/app/client/pages/reservas/'>Reservas</a></li>
                        <li style="<?php if ($_SESSION['id_rol'] != 3) echo "display: none;" ?>"><a href='http://localhost/Hospital/app/client/pages/mantenimientos/control.php'>Mis mantenimientos</a></li>
                        <li style="<?php if ($_SESSION['id_rol'] != 1) echo "display: none;" ?>"><a href='http://localhost/Hospital/app/client/pages/roles/'>Gestión de usuarios</a></li>
                    </ul>
                </li>
                <li><a href='http://localhost/Hospital/app/client/sobreNosotros.php'>Sobre Nosotros</a></li>
            </ul>
            <div class="nav-right" style="position: relative;">
                <span class="icon-bell" id="notification-icon">🔔</span>

                <!-- Contenedor del menú de notificaciones -->
                <div class="notifications-menu" id="notifications" style="display: none;">
                    <?php if (count($filasRecientes) > 0) { ?>
                        <?php
                        for ($i = 0; $i < (count($filasRecientes)); $i++) {
                        ?>
                            <a class="mantenimiento-link">
                                <div class="mantenimiento-notificacion">
                                    <h4>¡Próximo mantenimiento!</h4>
                                    <p><strong>Equipo:</strong> <?= ObtenerEquipoPorId($filasRecientes[$i]['id_equipo'])['nombre']; ?></p>
                                    <p><strong>Tipo:</strong> <?= $filasRecientes[$i]['tipo']; ?></p>
                                    <?php if (isset($diferenciasDias[$i])) {
                                    ?>
                                        <p><strong>Días restantes:</strong> <?= $diferenciasDias[$i]; ?></p>
                                    <?php
                                    } ?>
                                    <?php if (isset($filasRecientes[$i]['descripcion'])) {
                                    ?>
                                        <p><strong>Descripción:</strong> <?= $filasRecientes[$i]['descripcion']; ?></p>
                                    <?php
                                    } ?>
                                </div>
                            </a>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>

                    <!-- Notificación baja de stock !-->
                    <?php
                    if ($_SESSION['id_rol'] == 1 && count($filasConsumibles) > 0) {
                        for ($i = 0; $i < count($filasConsumibles); $i++) {
                    ?>
                            <div class="mantenimiento-notificacion">
                                <h4>¡Stock Bajo!</h4>
                                <p><strong>Insumo: <?php echo $filasConsumibles[$i]['nombre'] ?></strong></p>
                                <p><strong>Stock Actual: <?php echo $filasConsumibles[$i]['cantidad'] ?></strong></p>
                                <p><strong>Punto de reposición : <?php echo $filasConsumibles[$i]['cantidad_minima'] ?></strong></p>
                            </div>
                    <?php
                        }
                    }
                    ?>

                    <?php
                    if (count($filasRecientes) == 0 && count($filasConsumibles) == 0) {
                    ?>
                        <a href="#" class="mantenimiento-link">
                            <div class="mantenimiento-notificacion">
                                <h4>Sin notificaciones</h4>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
                <a href="http://localhost/Hospital/app/client/pages/auth/cerrar-sesion.php" class="logout">Cerrar Sesión</a>
            </div>


            </div>
        </nav>
    </header>

</body>

</html>