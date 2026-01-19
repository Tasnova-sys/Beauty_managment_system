<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'AuthController.php';
include_once 'CartController.php';
include_once 'OrderController.php';

if (!isUserLoggedIn()) {
    header('Location: ../html/login.php');
    exit();
}

$userId = getCurrentUserId();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deliveryAddress = isset($_POST['delivery_address']) ? trim($_POST['delivery_address']) : '';

    if (empty($deliveryAddress)) {
        header('Location: ../html/checkout.php?error=Please enter delivery address');
        exit();
    }

    
    $cartItems = getCartItems($userId);
    if (empty($cartItems)) {
        header('Location: ../html/cart.php?error=Your cart is empty');
        exit();
    }

    $cartTotal = getCartTotal($userId);
    if (!$cartTotal || $cartTotal <= 0) {
        header('Location: ../html/cart.php?error=Invalid cart total');
        exit();
    }

    $totalAmount = $cartTotal + 100; 

    $result = placeOrder($userId, $totalAmount, $deliveryAddress);

    if ($result['status']) {
        header('Location: ../html/order-detail.php?order_id=' . $result['order_id'] . '&success=1');
    } else {
        header('Location: ../html/checkout.php?error=' . urlencode($result['message']));
    }
    exit();
}

header('Location: ../html/cart.php');
exit();
