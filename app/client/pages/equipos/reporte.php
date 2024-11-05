<?php
session_start();
require_once __DIR__ . "/../../../server/controller/equipos.php";

if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
    exit();
}

$equipos = ObtenerEquipos();
?>
<html>
<head>
    <style>
        /* lo pongo asi porque no tendria que haber un css para esto */
        body { font-family: Arial, sans-serif; }
        h2 { text-align: center; margin-top: 20px;}
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }

        .aviso {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }

        /* solo para cuando imprimo */
        @media print {
            body { margin: 0; }
            h2 { page-break-after: avoid; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            button { display: none; } /* para q no aparezcan a la hora de imprimir */
            .print-instructions { display: none; } /* lo mismo pero para las instrucciones */
        }
    </style>

    <script>
        function printReport() {
            window.print();
        }
    </script>
</head>

<body>
    <h2>Informe de Estado de Equipos</h2>
    <div class="aviso">

        <p class="print-instructions" style="margin: 0 10px">
        Para una mejor visualizacion, asegurate de desactivar "Incluir encabezados y pies de página" en las opciones de impresión de tu navegador.
        </p>

        <div>
        <button onclick="printReport()" style="margin: 0 10px; padding: 10px 15px;">Imprimir Informe</button>
        <button onclick="window.location.href='./index.php'" style="margin: 0 10px; padding: 10px 15px;">Volver</button>
        </div>

    </div>

    <table>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Ubicación</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($equipos as $equipo): ?>
                <tr>
                    <td><?php echo ($equipo['nombre']); ?></td>
                    <td><?php echo ($equipo['descripcion']); ?></td>
                    <td><?php echo ($equipo['ubicacion']); ?></td>
                    <td><?php echo ($equipo['estado']); ?></td>
                </tr>
            <?php endforeach; ?>
    </table>
</body>
</html>