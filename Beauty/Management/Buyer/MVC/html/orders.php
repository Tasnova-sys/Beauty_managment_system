<!DOCTYPE html>
<html >

<head>
    
    <title>My Orders</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    session_start();
    include_once '../php/AuthController.php';
    include_once '../php/OrderController.php';

    if (!isUserLoggedIn()) {
        header('Location: login.php');
        exit();
    }

    $userId = getCurrentUserId();
    $orders = getUserOrders($userId);
    ?>

    <div class="navbar">
        <div class="navbar-container">
            <h1 class="logo">Beauty Store</h1>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="orders.php" class="active">My Orders</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../php/LogoutHandler.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="orders-header">
            <h2>My Orders</h2>
        </div>

        <?php if (count($orders) > 0): ?>
            <div class="orders-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <h3>Order #<?php echo $order['order_id']; ?></h3>
                                <p class="order-date"><?php echo date('d M Y', strtotime($order['order_date'])); ?></p>
                            </div>
                            <div class="order-status">
                                <span class="status-badge <?php echo strtolower($order['delivery_status']); ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $order['delivery_status'])); ?>
                                </span>
                            </div>
                        </div>

                        <div class="order-details">
                            <p><strong>Total Amount:</strong> Tk. <?php echo number_format($order['total_amount'], 2); ?></p>
                            <p><strong>Delivery Address:</strong> <?php echo $order['delivery_address']; ?></p>
                            <?php if ($order['estimated_delivery_date']): ?>
                                <p><strong>Estimated Delivery:</strong> <?php echo date('d M Y', strtotime($order['estimated_delivery_date'])); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="order-actions">
                            <a href="order-detail.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-secondary">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>You haven't placed any orders yet.</p>
                <a href="products.php" class="btn btn-primary">Start Shopping</a>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>Beauty Product Management System.</p>
    </footer>
</body>

</html>
