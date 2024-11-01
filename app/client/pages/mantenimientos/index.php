<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimientos</title>
    <link rel="icon" href="../../images/logo.png" />
</head>

<?php
include_once __DIR__ . "/../../../server/controller/equipos.php";
include_once __DIR__ . "../../../../server/controller/mantenimientos.php";
// Mantenimiento preventivo.
if (isset($_POST['btnAsignar']) && $_POST['txtEquipo'] != "" && $_POST['txtMantenimiento'] != "") {
    $id_equipo = $_POST['txtEquipo'];
    $fecha = $_POST['txtMantenimiento'];
    $tipo = "Preventivo";
    AltaMantenimiento($id_equipo, $fecha, $tipo);
    header("Location: index.php");
}

// Mantenimiento correctivo.
if (isset($_POST['btnReportar']) && $_POST['txtEquipoCorrectivo'] != "" && $_POST['txtFallo'] != "") {
    $id_equipo = $_POST['txtEquipoCorrectivo'];
    $tipo = "Correctivo";
    $descripcion = $_POST['txtFallo'];
    AltaMantenimiento($id_equipo, "", $tipo, $descripcion);
    header("Location: index.php");
}
?>

<body>
    <div>
        <span>Asignar plan de mantenimineto preventivo a un equipo</span>
        <form method="post" action="index.php">
            <select name="txtEquipo" id="txtEquipo">
                <option disabled selected value="">Seleccionar Equipo</option>
                <?php
                $filas = ObtenerEquipos();
                for ($i = 0; $i < count($filas); $i++) {
                ?>
                    <option value="<?php echo $filas[$i]['id'] ?>"><?php echo $filas[$i]['nombre'] ?></option>
                <?php
                }
                ?>
            </select>
            <select name="txtMantenimiento" id="txtMantenimiento">
                <option disabled selected value="">Seleccionar Mantenimiento</option>
                <option value="Mensual">Mensual</option>
                <option value="Trimestral">Trimestral</option>
                <option value="Anual">Anual</option>
            </select>
            <button type="submit" id="btnAsignar" name="btnAsignar">Asignar</button>
        </form>
    </div>
    <div>
        <span>Solicitud de mantenimiento correctivo</span>
        <form method="post" action="index.php">
            <select name="txtEquipoCorrectivo" id="txtEquipoCorrectivo">
                <option disabled selected value="">Seleccionar Equipo</option>
                <?php
                $filas = ObtenerEquipos();
                for ($i = 0; $i < count($filas); $i++) {
                ?>
                    <option value="<?php echo $filas[$i]['id'] ?>"><?php echo $filas[$i]['nombre'] ?></option>
                <?php
                }
                ?>
            </select>
            <label for="txtFallo">
                Descripcion del fallo
                <textarea name="txtFallo" id="txtFallo"></textarea>
            </label>
            <button type="submit" id="btnReportar" name="btnReportar">Reportar</button>
        </form>
    </div>
    <div>
        <button onclick="window.location.href = './historial.php'">
            Ver todos los mantenimientos
        </button>
    </div>
</body>

</html>