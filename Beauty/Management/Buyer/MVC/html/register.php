<!DOCTYPE html>
<html>
<head>
    <title>Register - Beauty Product Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <h1>Register</h1>
            
            <?php
            session_start();
            if (isset($_GET['error'])) {
                echo '<div class="error-message">';
                if (isset($_SESSION['response']) && isset($_SESSION['response']['message'])) {
                    echo $_SESSION['response']['message'];
                    unset($_SESSION['response']);
                } else {
                    echo 'Registration failed. Please try again.';
                }
                echo '</div>';
            }
            ?>
            
            <form method="POST" action="../php/AuthController.php" class="auth-form">
                <input type="hidden" name="action" value="register">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            
            <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
