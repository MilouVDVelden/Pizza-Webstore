<?php
session_start();

if (isset($_POST["empty_cart"])) {
    // Verwijder het winkelmandje
    unset($_SESSION["cart"]);

    echo "Je winkelmandje is nu leeg.";
}
header("location: homepage.php");
?>
