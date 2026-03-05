<?php
require_once = "../config/constatns.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Admin System</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/dashboard.css">

</head>
<body>
    <nav class="navbar">
        <div class="navbar_left">
            <div class="logo">
                <i class="fas fa-lock"></i>
                <span>Admin Panel</span>
            </div>
        </div>
        <div class="navbar_right">
        <div class="user_info">
            <p>Welcome back,</p>
            <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong>
        </div>
        <form action="logout.php" method="POST" style="margin: 0;">
            <button type="submit" class="logout_btn">Logout</button>
        </form>
    </nav>
    <div class="dashboard_container">
        <div class="welcome_section">
            <h1>Welcome to your dashboard</h1>
            <p>You are successfully logged into the admin system. Below is your account information and quick access to import features</p>
        </div>
    </div>

    <div class="info_grid">
        <div class="info_card">
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
            <h3>Full Name</h3>
            <p><?php echo htmlspecialchars($_SESSION['username']); ?> </php>
        </div>

        <div class="info_card">
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h3>Email</h3>
            <p><?php echo htmlspecialchars($_SESSION['email']); ?> </php>
        </div>

        <div class="info_card">
            <div class="icon">
                <i class="fas fa-shield"></i>
            </div>
            <div class="admin_badge <?php echo $_SESSION['admin'] ? 'y' : 'n'; ?>">
            <p><?php echo $_SESSION['admin'] ? 'Administrator' : 'Regular User'; ?> </php>
        </div>
    </div>
    
</body>
</html>