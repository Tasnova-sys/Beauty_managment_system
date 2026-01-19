<!DOCTYPE html>
<html >

<head>
   
    <title>Shopping Cart</title>
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
    ?>

    <div class="navbar">
        <div class="navbar-container">
            <h1 class="logo">Beauty Store</h1>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="cart.php" class="active">Cart <span id="cart-count" class="cart-badge"></span></a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../php/LogoutHandler.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="cart-header">
            <h2>Shopping Cart</h2>
        </div>

        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error-message">Error: ' . htmlspecialchars($_GET['error']) . '</div>';
        }
        if (isset($_GET['success'])) {
            echo '<div class="success-message">Item updated successfully.</div>';
        }
        ?>

        <div class="cart-content">
            <?php if (count($cartItems) > 0): ?>
                <table class="cart-table">
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
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="cart-item-name">
                                        <img src="../images/<?php echo $item['product_image'] ?: 'no-image.png'; ?>" alt="<?php echo $item['product_name']; ?>" class="cart-item-image">
                                        <span><?php echo $item['product_name']; ?></span>
                                    </div>
                                </td>
                                <td>Tk. <?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <input type="number" min="1" value="<?php echo $item['quantity']; ?>"
                                        onchange="updateCartQuantity(<?php echo $item['cart_id']; ?>, this.value)" class="qty-input">
                                </td>
                                <td>Tk. <?php echo number_format($item['total_price'], 2); ?></td>
                                <td>
                                    <button onclick="removeFromCart(<?php echo $item['cart_id']; ?>)" class="btn btn-danger btn-small">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <div class="summary-item">
                        <span>Subtotal:</span>
                        <span>Tk. <?php echo number_format($cartTotal, 2); ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping:</span>
                        <span>Tk. 100</span>
                    </div>
                    <div class="summary-item total">
                        <span>Total:</span>
                        <span>Tk. <?php echo number_format($cartTotal + 100, 2); ?></span>
                    </div>
                </div>

                <div class="cart-actions">
                    <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
                    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <p>Your cart is empty</p>
                    <a href="products.php" class="btn btn-primary">Start Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        <p> Beauty Product Management System.</p>
    </footer>

    <script src="../js/cart.js"></script>
</body>

</html>
