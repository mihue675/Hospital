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
    <title>Roles</title>
    <link rel="icon" href="../../images/logo.png" />
    <link rel="stylesheet" href="asignacion.css" />
</head>

<script>
        function AsignarRol(id_usuario, id_rol) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "asignacion.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualiza la interfaz de usuario.
                    location.reload();
                }
            };
            xhr.send("id=" + id_usuario + "&rol=" + id_rol); // Enviar el id y el nuevo rol
        }

</script>

<?php
require_once __DIR__ . "/../../../server/controller/roles.php";
require_once __DIR__ . "/../../../server/controller/usuarios.php";

if (isset($_POST['rol']) && $_POST['rol'] != "") {
    $id_usuario = $_POST['id'];
    $rol = $_POST['rol'];
    AsignarRol($id_usuario, $rol);
}
?>

<body>

    <header>
        <?php require("../../components/header.php") ?>
        <style>
            <?php require("../../components/header.css") ?>
        </style>
    </header>

    <div class="h1">
    <h1>Gestión de usuarios</h1>
    </div>
    
    <div class="contenedor">
    <?php
        $filas = ObtenerUsuarios();
        for ($i = 0; $i < count($filas); $i++) {
                ?>
                    <div class="usuario">
                <p><strong>Nombre: </strong><?php echo $filas[$i]['nombre']?></p>
                <p><strong>Apellido:</strong> <?php echo $filas[$i]['apellido'] ?></p>
                <p><strong>E-mail:</strong> <?php echo $filas[$i]['email'] ?></p>
                <div>
                    <p><strong>Rol: </strong> 
                        <?php
                            echo ObtenerRolPorId($filas[$i]['id_rol'])['nombre'];
                        ?>     
                        </p>
                        <select name="txtRol" id="txtRol" onchange="AsignarRol(<?php echo $filas[$i]['id']?>, this.value)">
                            <option disabled selected value="">Asignar rol</option>
                            <?php 
                            $filasRoles = ObtenerRoles();
                            for ($j = 0; $j < count($filasRoles); $j++) {
                                ?>
                                <option value="<?php echo $filasRoles[$j]['id'] ?>"> <?php echo $filasRoles[$j]['nombre'] ?></option>
                            <?php    
                            }
                            ?>
                        </select>          
                </div>
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