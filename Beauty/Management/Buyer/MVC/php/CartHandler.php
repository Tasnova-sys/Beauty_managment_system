<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'AuthController.php';
include_once 'CartController.php';

if (!isUserLoggedIn()) {
    echo json_encode(array('status' => false, 'message' => 'Not logged in'));
    exit();
}

$userId = getCurrentUserId();
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'add_to_cart') {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if ($quantity <= 0) {
        $quantity = 1;
    }
    
    $result = addToCart($userId, $productId, $quantity);
    echo json_encode($result);
    exit();
}

if ($action == 'update_cart') {
    $cartId = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    
    $result = updateCartQuantity($userId, $cartId, $quantity);
    echo json_encode($result);
    exit();
}

if ($action == 'remove_from_cart') {
    $cartId = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
    
    $result = removeFromCart($userId, $cartId);
    echo json_encode($result);
    exit();
}

if ($action == 'get_cart_count') {
    $count = getCartCount($userId);
    echo json_encode(array('status' => true, 'count' => $count));
    exit();
}

echo json_encode(array('status' => false, 'message' => 'Invalid action'));
exit();

?>
