<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";

function IniciarSesion($email, $contraseña)
{
    global $conn;
    $b = 0; // Bandera.
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);
    $resultado = mysqli_fetch_array($query, MYSQLI_ASSOC); // Resultado del usuario encontrado con ese email.

    if ($resultado > 0) {
        if (password_verify($contraseña, $resultado['contraseña']) /* Verificar si la contraseña ingresada coincide.*/) {
            $_SESSION['idUsuario'] = $resultado['id'];
            $b = 1;
        };
    }

    return $b;
}

function Registrar($nombre, $apellido, $email, $contraseña)
{
    global $conn;
    $b = 0; // Bandera.
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);
    $resultado = mysqli_fetch_array($query, MYSQLI_ASSOC);

    if ($resultado == 0) { /* Verificar si no existe un usuario con ese email. */
        $hash = password_hash($contraseña, PASSWORD_BCRYPT); // Hashear contraseña.
        $sql = "INSERT INTO usuarios (nombre, apellido, email, contraseña) VALUES ('$nombre','$apellido','$email','$hash')";
        mysqli_query($conn, $sql);
        $b = 1;
    };

    return $b;
}
