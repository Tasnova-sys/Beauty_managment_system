<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - Beauty Product Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    session_start();
    include_once '../php/AuthController.php';

    if (!isUserLoggedIn()) {
        header('Location: login.php');
        exit();
    }
    ?>

    <div class="navbar">
        <div class="navbar-container">
            <h1 class="logo">Beauty Store</h1>
            <ul class="nav-menu">
                <li><a href="dashboard.php" class="active">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="cart.php">Cart <span id="cart-count" class="cart-badge"></span></a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../php/LogoutHandler.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>!</h2>
            <p>Your personalized beauty shopping experience</p>
        </div>

        <div class="dashboard-content">
            <div class="featured-section">
                <h3>Featured Products</h3>
                <div id="featured-products" class="products-grid">
                    <p>Loading featured products...</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>Beauty Product Management System.</p>
    </footer>

    <script src="../js/dashboard.js"></script>
</body>

</html>
