<?php
// index.php - Home page
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - Authentication System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Authentication System</h1>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="success-message">
                <p>You are logged in as: <strong><?php echo $_SESSION['username']; ?></strong></p>
                <p><a href="dashboard.php">Go to Dashboard</a> | <a href="logout.php">Logout</a></p>
            </div>
        <?php else: ?>
            <div class="info">
                <p>You are not logged in.</p>
                <p>
                    <a href="login.php">Login</a> | 
                    <a href="signup.php">Sign Up</a>
                </p>
            </div>
        <?php endif; ?>
        
        <h2>About This Project</h2>
        <p>This project demonstrates:</p>
        <ul>
            <li><strong>PHP Forms:</strong> POST method on signup/login, GET parameters</li>
            <li><strong>Form Validation:</strong> Required fields, email format, password confirmation, min length</li>
            <li><strong>Sessions:</strong> User authentication and login state</li>
            <li><strong>Cookies:</strong> Remember me functionality and user preferences</li>
        </ul>
        
        <h2>Quick Navigation</h2>
        <div class="demo-section">
            <h3>Test Pages:</h3>
            <ul>
                <li><a href="signup.php">Signup Page (POST method demo)</a></li>
                <li><a href="login.php">Login Page (POST + GET demo + Cookies)</a></li>
                <li><a href="login.php?message=test_get">Login with GET parameter</a></li>
                <li><a href="dashboard.php">Dashboard (Session protected)</a></li>
            </ul>
        </div>
    </div>
</body>
</html>