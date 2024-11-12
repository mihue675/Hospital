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

$estadisticas = ObtenerEstadisticasEquiposPorDias();

// Convertir los datos de PHP a arrays de JavaScript
$nombresEquipos = [];
$diasReservados = [];

foreach ($estadisticas as $id_equipo => $dias_reserva) {
    $equipo = ObtenerEquipoPorId($id_equipo);
    $nombresEquipos[] = $equipo['nombre'];
    $diasReservados[] = $dias_reserva;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

<script>
    // Pasar los datos de PHP a JavaScript
    const nombresEquipos = <?php echo json_encode($nombresEquipos); ?>;
    const diasReservados = <?php echo json_encode($diasReservados); ?>;
</script>

<script>
    // para configurar el grafico
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('graficoReservas').getContext('2d');
        const graficoReservas = new Chart(ctx, {
            type: 'bar',  // Tipo de gráfico (barras)
            data: {
                labels: nombresEquipos,  // Nombres de los equipos
                datasets: [{
                    label: 'Días reservados',
                    data: diasReservados,  // Días reservados
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',  // Color de las barras
                    borderColor: 'rgba(54, 162, 235, 1)',        // Color del borde
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Días de Reserva',
                            font:{
                                size:16
                            }
                        },
                        ticks: {
                            font: {
                                size: 16
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Equipos',
                            font:{
                                size:16
                            }
                        },
                        ticks: {
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<body>

    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>

    
        <div class="estadisticas">
            <h2 style="font-size: 40px; color: #00796b; text-align:center">Equipos más usados</h2>
            <canvas id="graficoReservas" width="400px" height="150px"></canvas>
        </div>
        


    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css")  ?>
        </style>
    </footer>
</body>

</html>