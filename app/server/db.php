<?php
require_once __DIR__ . "/../../constants/db_constants.php";

$conn = mysqli_connect(db_constants::Server(), db_constants::User(), db_constants::Password(), db_constants::DataBase());
// Verificar conexión.
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

return $conn;
