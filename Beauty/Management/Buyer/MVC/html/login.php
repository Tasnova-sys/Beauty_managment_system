<!DOCTYPE html>
<html>

<head>
    
    <title>Login - Beauty Product Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <div class="auth-container">
            <h1>Login</h1>

            <?php
            session_start();
            if (isset($_GET['success'])) {
                echo '<div class="success-message">Registration successful! </div>';
            }
            if (isset($_GET['deleted'])) {
                echo '<div class="success-message">Your account has been deleted successfully.</div>';
            }
            if (isset($_GET['error'])) {
                echo '<div class="error-message">';
                if (isset($_SESSION['response'])) {
                    echo $_SESSION['response']['message'];
                    unset($_SESSION['response']);
                } else {
                    echo 'Login failed. Please try again.';
                }
                echo '</div>';
            }
            ?>

            <form method="POST" action="../php/AuthController.php" class="auth-form">
                <input type="hidden" name="action" value="login">

                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <p class="auth-link">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>

</html>
