<!DOCTYPE html>
<html>

<head>
    
    <title>Checkout - Beauty Store</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    session_start();
    include_once '../php/AuthController.php';
    include_once '../php/CartController.php';

    if (!isUserLoggedIn()) {
        header('Location: login.php');
        exit();
    }

    $userId = getCurrentUserId();
    $cartItems = getCartItems($userId);
    $cartTotal = getCartTotal($userId);

    if (count($cartItems) == 0) {
        header('Location: cart.php');
        exit();
    }
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
        <div class="checkout-header">
            <h2>Checkout</h2>
        </div>

        <div class="checkout-container">
            <div class="checkout-main">
                <form method="POST" action="../php/CheckoutHandler.php" id="checkout-form" class="checkout-form">
                    <div class="form-section">
                        <h3>Delivery Address</h3>
                        <textarea id="delivery_address" name="delivery_address" required
                            placeholder="Enter your delivery address" rows="4" class="form-textarea"></textarea>
                    </div>

                    <div class="form-section">
                        <h3>Order Review</h3>
                        <table class="order-review-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item): ?>
                                    <tr>
                                        <td><?php echo $item['product_name']; ?></td>
                                        <td>Tk. <?php echo number_format($item['price'], 2); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td>Tk. <?php echo number_format($item['total_price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-section">
                        <h3>Payment Details</h3>
                        <div class="payment-info">
                            <div class="payment-row">
                                <span>Subtotal:</span>
                                <span>Tk. <?php echo number_format($cartTotal, 2); ?></span>
                            </div>
                            <div class="payment-row">
                                <span>Shipping:</span>
                                <span>Tk. 100</span>
                            </div>
                            <div class="payment-row total-row">
                                <span>Total Amount:</span>
                                <span>Tk. <?php echo number_format($cartTotal + 100, 2); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-actions">
                        <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p> Beauty Product Management System. </p>
    </footer>

    <script src="../js/checkout.js"></script>
</body>

</html>
