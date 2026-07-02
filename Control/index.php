<?php


if (!headers_sent()) {

    header("Location: stock.php");
    exit();

}

echo "<script>window.location.href='stock.php';</script>";

?>