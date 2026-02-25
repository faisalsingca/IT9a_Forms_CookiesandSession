<?php
// Start session for login authentication
session_start();

// Check if user clicked "Remember Me" from cookie
$remembered_user = '';
if (isset($_COOKIE['remembered_user'])) {
    $remembered_user = $_COOKIE['remembered_user'];
}

// Initialize variables
$errors = [];
$get_message = '';

// Check if there's a message via GET (for screenshot)
if (isset($_GET['message'])) {
    $get_message = $_GET['message'];
}

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']) ? true : false;
    
    // Simple validation
    if (empty($username) || empty($password)) {
        $errors[] = "Username and password are required";
    } else {
        // Simple hardcoded authentication (in real app, check database)
        if ($username === 'demo' && $password === 'password123') {
            // Set session for login authentication
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = $username;
            $_SESSION['login_time'] = date('Y-m-d H:i:s');
            
            // Set cookie if "Remember Me" is checked
            if ($remember) {
                setcookie('remembered_user', $username, time() + (86400 * 7), '/'); // 7 days
                setcookie('user_preference', 'dark_mode', time() + (86400 * 7), '/');
            }
            
            // Set a login status cookie
            setcookie('last_login', date('Y-m-d H:i:s'), time() + 3600, '/');
            
            // Redirect to dashboard with GET parameter (for screenshot)
            header('Location: dashboard.php?login_success=1');
            exit();
        } else {
            $errors[] = "Invalid credentials (Try: demo / password123)";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - POST Method with Cookie Demo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login Form</h1>
        
        <!-- SHOW GET DATA FOR SCREENSHOT -->
        <div class="superglobal-demo">
            <h3>$_GET Data (for screenshot):</h3>
            <pre>
<?php
if (!empty($_GET)) {
    print_r($_GET);
} else {
    echo "No GET data - Try clicking the link below to see \$_GET in action";
}
?>
            </pre>
            <p><a href="login.php?message=Please%20login%20to%20continue&from=demo">Click here to test $_GET</a></p>
        </div>
        
        <!-- Display GET message if exists -->
        <?php if ($get_message): ?>
            <div class="info">
                <strong>GET Message:</strong> <?php echo htmlspecialchars($get_message); ?>
            </div>
        <?php endif; ?>
        
        <!-- Display errors -->
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach($errors as $error): ?>
                    <p class="error">• <?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Login Form - POST method -->
        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($remembered_user); ?>" placeholder="demo">
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" placeholder="password123">
            </div>
            
            <div class="form-group">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me (sets cookie)</label>
            </div>
            
            <button type="submit">Login (POST)</button>
        </form>
        
        <!-- Show Cookie info -->
        <div class="cookie-info">
            <h4>Cookie Status:</h4>
            <?php if (isset($_COOKIE['remembered_user'])): ?>
                <p>✓ Remember Me cookie is set for: <strong><?php echo $_COOKIE['remembered_user']; ?></strong></p>
            <?php else: ?>
                <p>✗ No remember me cookie set</p>
            <?php endif; ?>
            
            <?php if (isset($_COOKIE['user_preference'])): ?>
                <p>✓ User preference cookie: <strong><?php echo $_COOKIE['user_preference']; ?></strong></p>
            <?php endif; ?>
        </div>
        
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</body>
</html>