<?php
// Start session
session_start();

// Initialize variables
$errors = [];
$success = '';

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from POST superglobal
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // VALIDATION 1: Required fields
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if (empty($confirm_password)) {
        $errors[] = "Confirm password is required";
    }
    
    // VALIDATION 2: Email format validation
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // VALIDATION 3: Password confirmation
    if (!empty($password) && !empty($confirm_password) && $password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // VALIDATION 4: Minimum length (bonus)
    if (!empty($password) && strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    // If no errors, save to "database" (using file for simplicity)
    if (empty($errors)) {
        // In a real app, you'd save to database
        // For demo, we'll just set a cookie to remember the user
        setcookie('signup_success', 'true', time() + 3600, '/');
        $success = "Signup successful! You can now login.";
        
        // Clear POST data after success
        $_POST = [];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup - POST Method Demo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Signup Form (POST Method)</h1>
        
        <!-- SHOW SUPERGLOBAL DATA FOR SCREENSHOT -->
        <div class="superglobal-demo">
            <h3>$_POST Data (for screenshot):</h3>
            <pre>
<?php
if (!empty($_POST)) {
    print_r($_POST);
} else {
    echo "No POST data - Submit the form to see \$_POST in action";
}
?>
            </pre>
        </div>
        
        <!-- Display errors -->
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach($errors as $error): ?>
                    <p class="error">• <?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Display success -->
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        
        <!-- Signup Form - POST method -->
        <form method="POST" action="signup.php">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <small>Validation: Must be valid email format</small>
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password">
                <small>Validation: Min 6 characters</small>
            </div>
            
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password">
                <small>Validation: Must match password</small>
            </div>
            
            <button type="submit">Sign Up (POST)</button>
        </form>
        
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>