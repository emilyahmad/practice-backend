<?php
require_once ('../config/constants.php');

// authorization - access control
// check whether user is logged in or not

if(!isset($_SESSION['user'])) // if user session isn't set
{
    // user isn't logged in; redirect to login page w message
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel</div>"
    // redirect to login page
    header('location:.'SITEURL.'admin/login.php');
}

?>