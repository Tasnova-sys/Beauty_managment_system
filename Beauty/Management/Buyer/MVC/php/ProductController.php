<?php

include_once '../db/connection.php';

function getAllProducts()
{
    $query = "SELECT * FROM products WHERE stock_quantity > 0 ORDER BY created_at DESC";
    return fetchAll($query);
}

function getProductById($productId)
{
    $query = "SELECT * FROM products WHERE product_id = $productId";
    return fetchOne($query);
}


function searchProducts($searchTerm)
{
    global $connection;

    $searchTerm = escapeInput($searchTerm);
    $query = "SELECT * FROM products
              WHERE (product_name LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%' OR category LIKE '%$searchTerm%')
              AND stock_quantity > 0
              ORDER BY created_at DESC";

    return fetchAll($query);
}

function getProductsByCategory($category)
{
    global $connection;

    $category = escapeInput($category);
    $query = "SELECT * FROM products WHERE category = '$category' AND stock_quantity > 0 ORDER BY created_at DESC";

    return fetchAll($query);
}


function getAllCategories()
{
    $query = "SELECT DISTINCT category FROM products WHERE category IS NOT NULL ORDER BY category";
    $results = fetchAll($query);

    $categories = array();
    foreach ($results as $result) {
        $categories[] = $result['category'];
    }
    return $categories;
}
