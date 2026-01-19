<?php
session_start();
include '../db/config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password =  $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }
    
    else { $check_email ="SELECT id FROM users WHERE email ='$email'";
    $check_result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($check_result) > 0) {
        $error = "Email already exists.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $insert_query = "INSERT INTO users (name, email, phone, password, user_type, status) VALUES ('$name', '$email', '$phone', '$hashed_password','admin','active')";
        if (mysqli_query($conn, $insert_query)) {
            $success = "Registration successful.login kindly.";
        } else {
            $error = "Registration failed. TRY AGAIN!"; 
        }
    }
    }} ?>
<!DOCTYPE html>
<html >
    <head>
        
        <title>Admin Registration</title>
        <link rel="stylesheet" href="../css/auth.css">

        <style>
            .error {  background: #fbccd1;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;} 

            .success { background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;}
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-box">
                <div style ="text-align: center; margin-bottom: 20px;">

            <h1 style="margin-bottom: 5px;"> BEAUTY SHOP</h1>
            <p> Registration</p>
                </div>      




            <?php if ($error): ?>
                <div class="error">
                    <strong> Error:</strong>
                    <?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?>

            <br><a href="login.php"  style="color: #155724; text-decoration: underline;">Click here to login</a>
                </div>
            <?php endif; ?>


                 <form method="POST" action="">

                <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required></div>

                <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required></div>

                <div class="form-group">

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required></div>

                <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required></div>

                <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required></div>

                <button type="submit">Register</button>
            </form>
            <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body> 
</html>
