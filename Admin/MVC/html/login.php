<?php
session_start();
include '../db/config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT id, name, email, user_type, password FROM users WHERE email = '$email' AND user_type = 'admin'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $row['password'])  || $password == $row['password']) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];
            
            $activity_query = "INSERT INTO activities (user_id, action, description) VALUES ('{$row['id']}', 'login', 'Admin logged in')";
            mysqli_query($conn, $activity_query);
            
            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Admin not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Admin Login - Beauty Shop</title>
    <link rel="stylesheet" href="../css/auth.css">
    <style>
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #2c3e50; margin: 0 0 10px 0; font-size: 28px;">Beauty Shop</h1>
                <p style="color: #666; margin: 0;">Admin Panel</p>
            </div>
            
            <?php if ($error): ?>
                <div class="error">
                    <strong>Error:</strong> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn">Login</button>
            </form>
            
              
                <p >
                    Don't have an account? <a href="register.php" style="color: #3498db;">Register here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
