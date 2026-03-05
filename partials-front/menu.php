<?php
    session_start();


    include('./config/constants.php');
   
    if (!isset($_SESSION["regs"])) {
        // does it have data in it?
        // if not -> have them login
        header("Location: login.php");
        die();
    }
    $error = [];
?>
<!-- everyhing above nav in index.html -->
