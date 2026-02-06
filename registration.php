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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="registration.php" method="post">
        <h1> Please fill out this registration form</h1>
        <br>
        <br>
        <input type="text" name="full_name" placeholder="Full Name: ">
        <br><br>
        <input type="text" name="first_name" placeholder="First Name: ">
        <br><br>
        <input type="text" name="last_name" placeholder="Last Name: ">
        <br><br>
        <input type="text" name="email" placeholder="Email: ">
        <br><br>
        <input type="text" name="password" placeholder="Password: ">
        <br><br>
        <input type="submit" name="submit" value="Login">
        <br><br>
</form>
    <?php
    if(isset($_POST['submit'])) {
        $full_name = $_POST["full_name"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $password = $_POST["pasword"];
        $repeat_password = $_POST["repeat_password"];
    }

    require_once "constants.php";
    $sql = "SELECT * from tb1_admin WHERE email = '$email'";
    $result = $mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
        array_push($errors, "Email already exists!");
    }



    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // $errors = array();

    if (empty($full_name) || empty($first_name) || empty($last_name) || empty(email) || empty($password) || empty($repeat_password)) {
        array_push($errors, "All fields are required!");

    } if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    } if (strlen(password)<8) {
        array_push($errors, "Password must be at least 8 chars long");
    } if ($password !== $repeat_password) {
        array_push($errors, "Password does not match");
    }

    if (count($errors)>0) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }

    ?>
    <?php
        $admin = "n";
        $sql = "INSERT INTO tb1_admin (fullname, first_name, last_name, email, password, repeat_password) values(?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "ssssss");
        }




</body>
</html>