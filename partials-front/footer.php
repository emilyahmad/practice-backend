<?php
    session_start();
   
    if (!isset($_SESSION["regs"])) {
        // does it have data in it?
        // if not -> have them login
        header("Location: login.php");
        die();
    }
    $error = [];
?>
<!-- everyhing above nav in index.html -->
<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>
   
 </body>
 </html>