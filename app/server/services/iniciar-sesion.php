<?php
// Importamos la conexión a la base de datos.
require_once __DIR__ . "/../db.php";

function IniciarSesion($email, $contraseña)
{
    global $conn;
    $b = 0;
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
