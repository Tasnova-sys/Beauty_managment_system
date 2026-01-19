<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../db/connection.php';
include_once 'CartController.php';

function placeOrder($userId, $totalAmount, $deliveryAddress)
{
    global $connection;

    mysqli_begin_transaction($connection);

    try {
        $deliveryAddress = escapeInput($deliveryAddress);

        $orderQuery = "INSERT INTO orders (user_id, total_amount, delivery_address, order_status, delivery_status)
                       VALUES ($userId, $totalAmount, '$deliveryAddress', 'confirmed', 'pending')";

        if (!executeQuery($orderQuery)) {
            throw new Exception("Error creating order");
        }

        $orderId = getLastInsertedId();

        
        $cartItems = getCartItems($userId);

    
        foreach ($cartItems as $item) {
            $itemQuery = "INSERT INTO order_items (order_id, product_id, quantity, unit_price)
                          VALUES ($orderId, " . $item['product_id'] . ", " . $item['quantity'] . ", " . $item['price'] . ")";

            if (!executeQuery($itemQuery)) {
                throw new Exception("Error adding items to order");
            }

            
            $stockQuery = "UPDATE products SET stock_quantity = stock_quantity - " . $item['quantity'] . " WHERE product_id = " . $item['product_id'];

            if (!executeQuery($stockQuery)) {
                throw new Exception("Error updating stock");
            }
        }

    
        clearCart($userId);

        
        mysqli_commit($connection);

        return array('status' => true, 'message' => 'Order placed successfully', 'order_id' => $orderId);
    } catch (Exception $e) {
        
        mysqli_rollback($connection);
        return array('status' => false, 'message' => $e->getMessage());
    }
}

function getUserOrders($userId)
{
    $query = "SELECT * FROM orders WHERE user_id = $userId ORDER BY order_date DESC";
    return fetchAll($query);
}

function getOrderDetails($orderId)
{
    $query = "SELECT * FROM orders WHERE order_id = $orderId";
    return fetchOne($query);
}

function getOrderItems($orderId)
{
    $query = "SELECT oi.*, p.product_name, p.product_image FROM order_items oi
              JOIN products p ON oi.product_id = p.product_id
              WHERE oi.order_id = $orderId";

    return fetchAll($query);
}
