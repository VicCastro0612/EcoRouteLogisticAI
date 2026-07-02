<?php
session_start();

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("La versión de PHP instalada no es compatible con el sistema.");
}

if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once "libraries/password_compatibility_library.php";
}



require_once "config/db.php";
require_once "classes/Login.php";



$auth = new Login();



if ($auth->isUserLoggedIn()) {

    header("Location: stock.php");
    exit();

}

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EcoRoute Logistic AI | Acceso</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/login.css">

</head>

<body>

<div class="container">

    <div class="card card-container">

        <img
            src="img/avatar_2x.png"
            class="profile-img-card"
            alt="Usuario">

        <h3 class="text-center">
            EcoRoute Logistic AI
        </h3>

        <?php

        if (!empty($auth->errors)) {

            echo '<div class="alert alert-danger">';

            foreach ($auth->errors as $error) {
                echo "<p>$error</p>";
            }

            echo '</div>';

        }

        if (!empty($auth->messages)) {

            echo '<div class="alert alert-success">';

            foreach ($auth->messages as $message) {
                echo "<p>$message</p>";
            }

            echo '</div>';

        }

        ?>

        <form
            action="login.php"
            method="POST"
            autocomplete="off"
            class="form-signin">

            <input
                type="text"
                name="user_name"
                class="form-control"
                placeholder="Nombre de usuario"
                required>

            <br>

            <input
                type="password"
                name="user_password"
                class="form-control"
                placeholder="Contraseña"
                required>

            <br>

            <button
                type="submit"
                name="login"
                class="btn btn-success btn-lg btn-block">

                Ingresar al Sistema

            </button>

        </form>

    </div>

</div>

</body>

</html>