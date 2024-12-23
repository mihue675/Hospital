<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital - Registrarse</title>
    <link rel="stylesheet" href="registrarse.css">
    <link rel="icon" href="../../images/logo.png" />
</head>

<?php
require_once __DIR__ . "/../../../server/controller/auth.php";
$result;
if (isset($_POST['btnRegistrarse']) && $_POST['txtEmail'] != "" && $_POST['txtContraseña'] != "" && $_POST['txtNombre'] != "" && $_POST['txtApellido'] != "") {
    $result = Registrar($_POST['txtNombre'], $_POST['txtApellido'], $_POST['txtEmail'], $_POST['txtContraseña']);
    if ($result == 1) {
        header("Location: ../../index.php");
    }
}
?>

<body>
    <div class="divTodo">

        <div class="panel-derecho">
            <h2>Registrarse</h2>
            <form method="post" action="registrarse.php">
                <div class="grupo-formulario">
                    <label>
                        Nombre:
                        <input type="text" name="txtNombre" id="txtNombre" value="" required />
                    </label>
                    <br />
                    <label>
                        Apellido:
                        <input type="text" name="txtApellido" id="txtApellido" value="" required />
                    </label>
                    <br />
                </div>
                <div class="grupo-formulario">
                    <label>
                        Email:
                        <input type="email" name="txtEmail" id="txtEmail" value="" required />
                    </label>
                    <br />
                    <label>
                        Contraseña:
                        <input type="password" name="txtContraseña" id="txtContraseña" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número, una letra mayúscula y minúscula, y al menos 8 o más caracteres" required />
                    </label>
                    <br />
                    <span style="display: none;<?php 
                        if($result == 0 && isset($_POST['btnRegistrarse']) && $_POST['txtEmail'] != "" && $_POST['txtContraseña'] != "" && $_POST['txtNombre'] != "" && $_POST['txtApellido'] != "") {
                        echo "display: block; color: red;";
                    }
                    ?>">Usuario ya registrado</span>
                    <button type="submit" name="btnRegistrarse" class="btn" id="btnRegistrarse">Registrarse</button>
                </div>
            </form>
        </div>

        <div class="panel-izquierdo">
            <h2>¡Bienvenido!</h2>
            <p>Si ya tiene una cuenta, por favor inicie sesión.</p>
            <button onclick="window.location.href='iniciar-sesion.php'">Iniciar sesión</button>
        </div>

    </div>

</body>

</html>