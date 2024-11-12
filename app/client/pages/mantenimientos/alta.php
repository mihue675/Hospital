<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../index.php");
}

if (isset($_SESSION['idUsuario']) && $_SESSION['id_rol'] == 3) {
    header("Location: ../../error-permisos.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <html translate="no">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimientos</title>
    <link rel="icon" href="../../images/logo.png" />
    <link rel="stylesheet" href="alta.css" />
</head>

<?php
include_once __DIR__ . "/../../../server/controller/equipos.php";
include_once __DIR__ . "../../../../server/controller/mantenimientos.php";
// Mantenimiento preventivo.
if (isset($_POST['btnAsignar']) && $_POST['txtEquipo'] != "" && $_POST['txtMantenimiento'] != "") {
    $id_equipo = $_POST['txtEquipo'];
    $fecha = $_POST['txtMantenimiento'];
    $tipo = "Preventivo";

    if(TieneMantenimiento($id_equipo, $tipo) == true) { // si ya tiene un preventivo, no puede tener más.
        echo '<script type="text/javascript">
        window.onload = function () { alert("Este equipo ya tiene un mantenimiento preventivo asignado."); } 
        </script>';
    }
    else {
        AltaMantenimiento($id_equipo, $fecha, $tipo);
        header("Location: index.php");
    }
}

// Mantenimiento correctivo.
if (isset($_POST['btnReportar']) && $_POST['txtEquipoCorrectivo'] != "" && $_POST['txtFallo'] != "") {
    $id_equipo = $_POST['txtEquipoCorrectivo'];
    $tipo = "Correctivo";
    $descripcion = $_POST['txtFallo'];
    AltaMantenimiento($id_equipo, "", $tipo, $descripcion);
    CambiarEstado($id_equipo, "En mantenimiento"); // se q en el index igual nos fijamos, pero el cambio deberia reflejarse de inmediato en la bd.
    header("Location: index.php");
}
?>

<body>

    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>

    <div style="display: flex; flex-direction: column; align-items: center;">
        <h1>Registro de mantenimientos</h1>
        <p> Complete el formulario correspondiente al tipo de mantenimiento que desea registrar para un equipo.</p>
        <div class="contenedor-formularios">
            <div class="formulario">
                <span class="span">Mantenimiento preventivo</span>
                <form method="post" action="alta.php">
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
            <div class="formulario">
                <span class="span">Mantenimiento correctivo</span>
                <form method="post" action="alta.php">
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
                        Descripción del fallo:
                        <textarea name="txtFallo" id="txtFallo"></textarea>
                    </label>
                    <button type="submit" id="btnReportar" name="btnReportar">Reportar</button>
                </form>
            </div>
        </div>

        <button onclick="window.location.href = './index.php'">
            Volver
        </button>
    </div>

    <footer>
        <?php require("../../components/footer.php") ?>
        <style>
            <?php require("../../components/footer.css")  ?>
        </style>
    </footer>
</body>

</html>