<?php
require_once "../config/constants.php";

$errors = [];

if (isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // if no validation errors, check database
    if (count($errors) == 0) {
        $sql = "SELECT * FROM tbl_admin WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_password = $row['password'];

            // verify passwordif (password_verify($password, $db_password)) {
                // login Successfully
                $_SESSION['id'] = $row['id'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['admin'] = $row['admin'];
                $_SESSION['logged_in'] = true;

                // redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Password is incorrect";
            }
        } else {
            $errors[] = "Username not found";
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin System</title>
        <link href="https:fonts.googleapis.com/css2?family=Lato:ital,wght