<?php
session_start();
include "access.php";
{
    header("location: login.php");
    die;   
}
?>
<h1>Access denied</h1>