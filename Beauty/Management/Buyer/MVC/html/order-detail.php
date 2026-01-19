<!DOCTYPE html>
<html>

<head>
    <title>Order Details</title>
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
    $orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

    $order = getOrderDetails($orderId);
    if (!$order || $order['user_id'] != $userId) {
        header('Location: orders.php');
        exit();
    }

    $orderItems = getOrderItems($orderId);
    ?>

    <div class="navbar">
        <div class="navbar-container">
            <h1 class="logo">Beauty Store</h1>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../php/LogoutHandler.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="order-detail-header">
            <h2>Order #<?php echo $order['order_id']; ?></h2>
            <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
        </div>

        <div class="order-detail-content">
            <div class="order-status-section">
                <h3>Order Status</h3>
                <div class="status-timeline">
                    <div class="status-item <?php echo ($order['order_status'] == 'confirmed') ? 'active' : ''; ?>">
                        <div class="status-dot"></div>
                        <p>Order Confirmed</p>
                    </div>
                    <div class="status-item <?php echo (strpos($order['delivery_status'], 'shipped') !== false) ? 'active' : ''; ?>">
                        <div class="status-dot"></div>
                        <p>Shipped</p>
                    </div>
                    <div class="status-item <?php echo ($order['delivery_status'] == 'delivered') ? 'active' : ''; ?>">
                        <div class="status-dot"></div>
                        <p>Delivered</p>
                    </div>
                </div>
            </div>

            <div class="order-items-section">
                <h3>Order Items</h3>
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="item-with-image">
                                        <img src="../images/<?php echo $item['product_image'] ?: 'no-image.png'; ?>" alt="<?php echo $item['product_name']; ?>">
                                        <span><?php echo $item['product_name']; ?></span>
                                    </div>
                                </td>
                                <td>Tk. <?php echo number_format($item['unit_price'], 2); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>Tk. <?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="order-summary-section">
                <h3>Order Summary</h3>
                <div class="order-summary">
                    <p><strong>Order Date:</strong> <?php echo date('d M Y, H:i', strtotime($order['order_date'])); ?></p>
                    <p><strong>Delivery Address:</strong> <?php echo $order['delivery_address']; ?></p>
                    <?php if ($order['estimated_delivery_date']): ?>
                        <p><strong>Estimated Delivery:</strong> <?php echo date('d M Y', strtotime($order['estimated_delivery_date'])); ?></p>
                    <?php endif; ?>
                    <hr>
                    <p><strong>Total Amount:</strong> Tk. <?php echo number_format($order['total_amount'], 2); ?></p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p> Beauty Product Management System.</p>
    </footer>

    <script src="../js/order-detail.js"></script>
</body>

</html>
