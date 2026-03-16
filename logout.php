<?php
require_once ('../config/constants.php');

// include constants for SITEURL
    include ('partials/menu.php');
    require_once ('../config/constants.php');


// destroy session
session_destroy() // unsets $_SESSION['user]

// redirect to login
head('location:'.SITEURL.'admin/login.php');

?>