<?php
session_start();
function access($rank)
{
    if(isset($_SESSION["ACCESS"]) && !$_SESSION["ACCESS"][$rank]) 
    {
        header("location: denied.php");
        die;   
    }
}

$_SESSION["ACCESS"]["ADMIN"] = isset($_SESSION['myrank']) && ($_SESSION['myrank']) == "admin";
$_SESSION["ACCESS"]["USER"] = isset($_SESSION['myrank']) && ($_SESSION['myrank']) == "user";
?>