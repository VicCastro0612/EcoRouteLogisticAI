<?php

$conexion = mysqli_init();

if (!$conexion) {
    exit("Error al inicializar la conexión.");
}

mysqli_real_connect(
    $conexion,
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME
);

if (mysqli_connect_errno()) {
    exit(
        "No fue posible conectar con la base de datos. Error (" .
        mysqli_connect_errno() .
        "): " .
        mysqli_connect_error()
    );
}

mysqli_set_charset($conexion, "utf8mb4");

?>