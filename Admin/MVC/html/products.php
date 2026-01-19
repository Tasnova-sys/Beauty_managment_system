<?php
include '../php/check_session.php';
include '../db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_product'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = floatval($_POST['price']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $stock = intval($_POST['stock']);
        
        $insert_query = "INSERT INTO products (name, description, price, category, stock, status) 
                        VALUES ('$name', '$description', $price, '$category', $stock, 'available')";
        mysqli_query($conn, $insert_query);
    }
    
    if (isset($_POST['update_product'])) {
        $product_id = intval($_POST['product_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = floatval($_POST['price']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $stock = intval($_POST['stock']);
        $status = $_POST['status'];
        
        $update_query = "UPDATE products SET name = '$name', description = '$description', price = $price, 
                        category = '$category', stock = $stock, status = '$status' WHERE id = $product_id";
        mysqli_query($conn, $update_query);
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $delete_query = "DELETE FROM products WHERE id = $product_id";
    mysqli_query($conn, $delete_query);
    header("Location: products.php");
    exit;
}

$products_query = "SELECT * FROM products ORDER BY created_at DESC";
$products_result = mysqli_query($conn, $products_query);
?>

<!DOCTYPE html>
<html >
<head>
   
    <title>Manage Products</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="navbar-brand">Beauty Shop Admin</div>
            <div class="navbar-menu">

                <a href="dashboard.php">Dashboard</a>
                <a href="users.php">Users</a>
                <a href="products.php">Products</a>
                <a href="activities.php">Activities</a>
                <a href="reports.php">Reports</a>
                <a href="profile.php">Profile</a>
                <a href="../php/logout.php">Logout</a>
            </div>
        </nav>

        <div class="content">
            <h1>Manage Products</h1>
            
            <div class="product-form">
                <h2>Add New Product</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Product Name:</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Price:</label>
                        <input type="number" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Category:</label>
                        <input type="text" name="category">
                    </div>
                    <div class="form-group">
                        <label>Stock:</label>
                        <input type="number" name="stock" required>
                    </div>
                    <button type="submit" name="add_product" class="btn">Add Product</button>
                </form>
            </div>

            <div class="products-list">
                <h2>Products</h2>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($products_result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>$" . number_format($row['price'], 2) . "</td>";
                            echo "<td>" . $row['stock'] . "</td>";
                            echo "<td><span class='status-" . $row['status'] . "'>" . ucfirst($row['status']) . "</span></td>";
                            echo "<td>";
                            echo "<a href='products.php?action=edit&id=" . $row['id'] . "' class='btn-small'>Edit</a>";
                            echo "  or <a href='products.php?action=delete&id=" . $row['id'] . "' class='btn-small btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
