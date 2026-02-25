<?php
// Start session
session_start();

// Check if user is logged in via session (authentication)
if (!isset($_SESSION['user_id'])) {
    // Not logged in - redirect to login with GET parameter
    header('Location: login.php?message=Please%20login%20first&error=auth');
    exit();
}

// Check if we have a login success GET parameter
$login_success = isset($_GET['login_success']) ? true : false;

// Set a session data display
$session_data = [
    'user_id' => $_SESSION['user_id'],
    'username' => $_SESSION['username'],
    'login_time' => $_SESSION['login_time']
];

// Get cookie data
$cookie_data = $_COOKIE;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Session & Cookie Demo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if ($login_success): ?>
            <div class="success-message">
                <p>✓ Login successful! (GET parameter: ?login_success=1)</p>
            </div>
        <?php endif; ?>
        
        <h1>Welcome to Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        
        <div class="welcome-message">
            <p>You are successfully logged in using SESSION authentication.</p>
        </div>
        
        <!-- SESSION DEMO SECTION -->
        <div class="demo-section">
            <h2>📌 Session Data (for screenshot):</h2>
            <pre>
<?php print_r($session_data); ?>
            </pre>
            <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
            <p><strong>Session Save Path:</strong> <?php echo session_save_path(); ?></p>
        </div>
        
        <!-- COOKIE DEMO SECTION -->
        <div class="demo-section">
            <h2>🍪 Cookie Data (for screenshot):</h2>
            <pre>
<?php print_r($cookie_data); ?>
            </pre>
            <p><strong>Cookies set:</strong></p>
            <ul>
                <?php foreach($cookie_data as $key => $value): ?>
                    <li><strong><?php echo $key; ?>:</strong> <?php echo $value; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- SESSION VS COOKIE EXPLANATION -->
        <div class="info-box">
            <h3>How Sessions & Cookies Work Here:</h3>
            <ul>
                <li><strong>SESSIONS:</strong> Stored on server. Used to keep you logged in (authentication).</li>
                <li><strong>COOKIES:</strong> Stored in browser. Used for "Remember Me" and preferences.</li>
                <li><strong>Current Session:</strong> User #<?php echo $_SESSION['user_id']; ?> logged in at <?php echo $_SESSION['login_time']; ?></li>
                <li><strong>Current Cookies:</strong> Remember Me: <?php echo isset($_COOKIE['remembered_user']) ? 'Yes' : 'No'; ?>, Last Login: <?php echo isset($_COOKIE['last_login']) ? $_COOKIE['last_login'] : 'Not set'; ?></li>
            </ul>
        </div>
        
        <!-- FORM VALIDATION SUMMARY -->
        <div class="validation-summary">
            <h3>✓ Form Validations Implemented (3+):</h3>
            <ol>
                <li><strong>Required Fields:</strong> Username, email, password, confirm password</li>
                <li><strong>Email Format:</strong> Valid email format using filter_var()</li>
                <li><strong>Password Confirmation:</strong> Password and confirm password must match</li>
                <li><strong>Minimum Length:</strong> Password at least 6 characters (bonus)</li>
            </ol>
        </div>
        
        <p><a href="logout.php">Logout</a> | <a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>