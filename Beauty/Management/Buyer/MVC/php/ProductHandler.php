<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'AuthController.php';
include_once 'ProductController.php';

if (!isUserLoggedIn()) {
    echo json_encode(array('status' => false, 'message' => 'Not logged in'));
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'get_product') {
    $productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
    
    $product = getProductById($productId);
    
    if (!$product) {
        echo json_encode(array('status' => false, 'message' => 'Product not found'));
        exit();
    }
    
    echo json_encode(array('status' => true, 'product' => $product));
    exit();
}

if ($action == 'search_products') {
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    if (empty($searchTerm)) {
        $products = getAllProducts();
    } else {
        $products = searchProducts($searchTerm);
    }
    
    echo json_encode(array('status' => true, 'products' => $products));
    exit();
}

if ($action == 'get_category_products') {
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    
    if (empty($category)) {
        $products = getAllProducts();
    } else {
        $products = getProductsByCategory($category);
    }
    
    echo json_encode(array('status' => true, 'products' => $products));
    exit();
}

echo json_encode(array('status' => false, 'message' => 'Invalid action'));
exit();

?>
