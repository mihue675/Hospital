<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital - Registrarse</title>
</head>

<?php
require_once __DIR__ . "/../../../server/controller/auth.php";

if (isset($_POST['btnRegistrarse']) && $_POST['txtEmail'] != "" && $_POST['txtContraseña'] != "" && $_POST['txtNombre'] != "" && $_POST['txtApellido'] != "") {
    if (Registrar($_POST['txtNombre'], $_POST['txtApellido'], $_POST['txtEmail'], $_POST['txtContraseña'])) {
        header("Location: ../../index.php");
    }
}

?>

<body>
    <form method="post" action="registrarse.php">
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
        <label>
            Email:
            <input type=" email" name="txtEmail" id="txtEmail" value="" required />
        </label>
        <br />
        <lable>
            Contraseña:
            <input type="password" name="txtContraseña" id="txtContraseña" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número, una letra mayúscula y minúscula, y al menos 8 o más caracteres" required />
        </lable>
        <br />
        <button type="submit" name="btnRegistrarse" id="btnRegistrarse">Registrarse</button>
    </form>
</body>

</html>