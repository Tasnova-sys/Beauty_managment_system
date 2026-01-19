<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../db/connection.php';

function addToCart($userId, $productId, $quantity = 1)
{
    global $connection;

    $product = fetchOne("SELECT * FROM products WHERE product_id = $productId");

    if (!$product) {
        return array('status' => false, 'message' => 'Product not found');
    }

    if ($product['stock_quantity'] < $quantity) {
        return array('status' => false, 'message' => 'Insufficient stock');
    }

   
    $existingCart = fetchOne("SELECT cart_id, quantity FROM cart WHERE user_id = $userId AND product_id = $productId");

    if ($existingCart) {
        
        $newQuantity = $existingCart['quantity'] + $quantity;
        $updateQuery = "UPDATE cart SET quantity = $newQuantity WHERE cart_id = " . $existingCart['cart_id'];

        if (executeQuery($updateQuery)) {
            return array('status' => true, 'message' => 'Product quantity updated in cart');
        } else {
            return array('status' => false, 'message' => 'Error updating cart');
        }
    } else {
       
        $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $productId, $quantity)";

        if (executeQuery($insertQuery)) {
            return array('status' => true, 'message' => 'Product added to cart');
        } else {
            return array('status' => false, 'message' => 'Error adding to cart');
        }
    }
}

function getCartItems($userId)
{
    $query = "SELECT c.cart_id, p.product_id, p.product_name, p.price, p.product_image, c.quantity, (p.price * c.quantity) as total_price
              FROM cart c
              JOIN products p ON c.product_id = p.product_id
              WHERE c.user_id = $userId";

    return fetchAll($query);
}


function getCartCount($userId)
{
    $result = fetchOne("SELECT COUNT(cart_id) as count FROM cart WHERE user_id = $userId");
    return $result['count'];
}


function getCartTotal($userId)
{
    $result = fetchOne("SELECT SUM(p.price * c.quantity) as total FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = $userId");
    return $result['total'];
}


function updateCartQuantity($userId, $cartId, $quantity)
{
    if ($quantity <= 0) {
        return removeFromCart($userId, $cartId);
    }

    $query = "UPDATE cart SET quantity = $quantity WHERE cart_id = $cartId AND user_id = $userId";

    if (executeQuery($query)) {
        return array('status' => true, 'message' => 'Cart updated');
    } else {
        return array('status' => false, 'message' => 'Error updating cart');
    }
}


function removeFromCart($userId, $cartId)
{
    $query = "DELETE FROM cart WHERE cart_id = $cartId AND user_id = $userId";

    if (executeQuery($query)) {
        return array('status' => true, 'message' => 'Product removed from cart');
    } else {
        return array('status' => false, 'message' => 'Error removing from cart');
    }
}

function clearCart($userId)
{
    $query = "DELETE FROM cart WHERE user_id = $userId";

    if (executeQuery($query)) {
        return array('status' => true, 'message' => 'Cart cleared');
    } else {
        return array('status' => false, 'message' => 'Error clearing cart');
    }
}
