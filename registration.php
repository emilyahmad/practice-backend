<?php

require_once "../config/constants.php";

$errors = [];
$success = false;



if (isset($_POST['submit'])) {
    // Get and sanitize form inputs
    $full_name = trim($_POST['full_name'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $repeat_password = $_POST['repeat_password'] ?? '';

    // Validation
    if (empty($full_name)) {
        $errors[] = "Full name is required";
    }
    if (empty($first_name)) {
        $errors[] = "First name is required";
    }
    if (empty($last_name)) {
        $errors[] = "Last name is required";
    }
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format is invalid";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    if ($password !== $repeat_password) {
        $errors[] = "Passwords do not match";
    }

    // Check if username already exists
    if (count($errors) == 0) {
        $sql = "SELECT id FROM tbl_admin WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $errors[] = "Username already exists";
        }
        mysqli_stmt_close($stmt);
    }

    // Check if email already exists
    if (count($errors) == 0) {
        $sql = "SELECT id FROM tbl_admin WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $errors[] = "Email already exists";
        }
        mysqli_stmt_close($stmt);
    }

    // If no errors, insert into database
    if (count($errors) == 0) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $admin = 'n';
        
        $sql = "INSERT INTO tbl_admin (full_name, first_name, last_name, username, email, password, admin) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $full_name, $first_name, $last_name, $username, $email, $passwordHash, $admin);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = true;
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Admin System</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/registration.css">
<body>
    <div class="register_container">
        <div class="register_box">
            <div class="register_header">
                <h1>Create Account</h1>
                <p>Join Our Admin System</p>
            </div>

            <?php if ($success): ?>
                <div class="success_box">
                    <h2>✓ Registration Successful!</h2>
                    <p>Your account has been created successfully.</p>
                    <p>You can now log in with your credentials.</p>
                    <a href="login.php">Go to Login</a>
                </div>
            <?php else: ?>

                <?php if (count($errors) > 0): ?>
                    <div class="error_box">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="registration.php" method="POST">
                    <div class="form_row">
                        <div class="form_group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" 
                                   value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" 
                                   placeholder="John" required>
                        </div>
                        <div class="form_group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" 
                                   value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" 
                                   placeholder="Doe" required>
                        </div>
                    </div>

                    <div class="form_group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" 
                               value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" 
                               placeholder="John Doe" required>
                    </div>

                    <div class="form_group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" 
                               value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" 
                               placeholder="johndoe" minlength="3" required>
                        <p class="password_note">Minimum 3 characters</p>
                    </div>

                    <div class="form_group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                               placeholder="john@example.com" required>
                    </div>

                    <div class="form_group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" 
                               placeholder="••••••••" required>
                        <p class="password_note">Minimum 8 characters</p>
                    </div>

                    <div class="form_group">
                        <label for="repeat_password">Confirm Password</label>
                        <input type="password" id="repeat_password" name="repeat_password" 
                               placeholder="••••••••" required>
                    </div>

                    <button type="submit" name="submit" class="register_btn">Register</button>
                </form>

                <div class="register_footer">
                    <p>Already have an account?</p>
                    <a href="login.php">Log in here</a>
                </div>

            <?php endif; ?>
        </div>
    </div>
</body>
</html>