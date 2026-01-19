<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
    session_start();
    include_once '../php/AuthController.php';
    include_once '../php/ProfileController.php';
    
    if (!isUserLoggedIn()) {
        header('Location: login.php');
        exit();
    }
    
    $userId = getCurrentUserId();
    $userProfile = getUserProfile($userId);
    
    $activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'info';
    ?>
    
    <div class="navbar">
        <div class="navbar-container">
            <h1 class="logo">Beauty Store</h1>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="../php/LogoutHandler.php">Logout</a></li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <div class="profile-header">
            <h2>My Profile</h2>
        </div>
        
        <?php
        if (isset($_GET['success'])) {
            echo '<div class="success-message">Profile updated successfully!</div>';
        }
        if (isset($_GET['error'])) {
            echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>
        
        <div class="profile-container">
            <div class="profile-tabs">
                <button class="tab-btn <?php echo ($activeTab == 'info') ? 'active' : ''; ?>" onclick="switchTab('info')">Profile Info</button>
                <button class="tab-btn <?php echo ($activeTab == 'password') ? 'active' : ''; ?>" onclick="switchTab('password')">Change Password</button>
                <button class="tab-btn danger" onclick="deleteAccount()">Delete Account</button>
            </div>
            
            <div class="profile-content">

                <div id="info-tab" class="tab-content <?php echo ($activeTab == 'info') ? 'active' : ''; ?>">
                    <form method="POST" action="../php/ProfileHandler.php" class="profile-form">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" id="first_name" name="first_name" value="<?php echo $userProfile['first_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" id="last_name" name="last_name" value="<?php echo $userProfile['last_name']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" id="email" value="<?php echo $userProfile['email']; ?>" disabled>
                            <small>Email cannot be changed</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $userProfile['phone'] ?: ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea id="address" name="address" rows="3"><?php echo $userProfile['address'] ?: ''; ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City:</label>
                                <input type="text" id="city" name="city" value="<?php echo $userProfile['city'] ?: ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Postal Code:</label>
                                <input type="text" id="postal_code" name="postal_code" value="<?php echo $userProfile['postal_code'] ?: ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="country">Country:</label>
                                <input type="text" id="country" name="country" value="<?php echo $userProfile['country'] ?: ''; ?>">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
                
                <div id="password-tab" class="tab-content <?php echo ($activeTab == 'password') ? 'active' : ''; ?>">
                    <form method="POST" action="../php/ProfileHandler.php" class="profile-form">
                        <input type="hidden" name="action" value="change_password">
                        
                        <div class="form-group">
                            <label for="current_password">Current Password:</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <p>Beauty Product Management System.</p>
    </footer>
    
    <script src="../js/profile.js"></script>
</body>
</html>
