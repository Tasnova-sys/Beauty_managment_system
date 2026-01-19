<?php
include '../php/check_session.php';
include '../db/config.php';

$admin_id = $_SESSION['admin_id'];
$error = '';
$success = '';

$user_query = "SELECT id, name, email, phone FROM users WHERE id = $admin_id";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        
        $update_query = "UPDATE users SET name = '$name', email = '$email', phone = '$phone' WHERE id = $admin_id";
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['admin_name'] = $name;
            $_SESSION['admin_email'] = $email;
            $success = "Profile updated successfully!";
            $user_data['name'] = $name;
            $user_data['email'] = $email;
            $user_data['phone'] = $phone;
        } else {
            $error = "Failed to update profile.";
        }
    }
    
    if (isset($_POST['change_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        $pass_query = "SELECT password FROM users WHERE id = $admin_id";
        $pass_result = mysqli_query($conn, $pass_query);
        $pass_data = mysqli_fetch_assoc($pass_result);
        
        if (password_verify($old_password, $pass_data['password']) || $old_password == $pass_data['password']) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $change_query = "UPDATE users SET password = '$hashed_password' WHERE id = $admin_id";
                if (mysqli_query($conn, $change_query)) {
                    $success = "Password changed successfully!";
                } else {
                    $error = "Failed to change password.";
                }
            } else {
                $error = "New passwords do not match!";
            }
        } else {
            $error = "Old password is incorrect!";
        }
    }
}
?>

<!DOCTYPE html>
<html >
<head>
   
    <title>My Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">Beauty Shop Admin</div>
        <div class="navbar-menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="users.php">Users</a>
            <a href="products.php">Products</a>
            <a href="activities.php">Activities</a>
            <a href="complaints.php">Complaints</a>
            <a href="reports.php">Reports</a>
            <a href="profile.php">Profile</a>
            <a href="../php/logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="profile-section">
            <h2>My Profile</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <strong>Error:</strong> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="profile-form">

                <h3>Update Profile Information</h3>

                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>">
                </div>
                
                <button type="submit" name="update_profile" class="btn">Update Profile</button>
            </form>
            
            <hr style="margin: 40px 0; border: none; border-top: 1px solid #ddd;">
            
            <form method="POST" action="" class="profile-form">
                
                <h3>Change Password</h3>
                <div class="form-group">
                    <label for="old_password">Current Password:</label>
                    <input type="password" id="old_password" name="old_password" placeholder="Enter your current password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                </div>
                
                <button type="submit" name="change_password" class="btn">Change Password</button>
            </form>
        </div>
    </div>
</body>
</html>
