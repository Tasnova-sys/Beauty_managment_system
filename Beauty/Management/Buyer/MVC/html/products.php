<!DOCTYPE html>
<html >

<head>
    <title>Shop - Beauty Products</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    session_start();
    include_once '../php/AuthController.php';
    include_once '../php/ProductController.php';

    if (!isUserLoggedIn()) {
        header('Location: login.php');
        exit();
    }

    $allProducts = getAllProducts();
    $categories = getAllCategories();
    ?>

    <div class="navbar">
        <div class="navbar-container">
            <h1 class="logo">Beauty Store</h1>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php" class="active">Shop</a></li>
                <li><a href="cart.php">Cart <span id="cart-count" class="cart-badge"></span></a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../php/LogoutHandler.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="shop-header">
            <h2>Beauty Products</h2>
            <p>Explore our collection of premium beauty products</p>
        </div>

        <div class="shop-container">
            <aside class="shop-sidebar">
                <div class="filter-section">
                    <h3>Search Products</h3>
                    <input type="text" id="search-input" placeholder="Search..." class="search-input">
                    <button onclick="searchProducts()" class="btn btn-secondary">Search</button>
                </div>

                <div class="filter-section">
                    <h3>Categories</h3>
                    <ul class="category-list">
                        <li><a href="#" onclick="filterByCategory('')">All Products</a></li>
                        <?php foreach ($categories as $category): ?>
                            <li><a href="#" onclick="filterByCategory('<?php echo $category; ?>')"><?php echo $category; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <main class="shop-main">
                <div id="products-grid" class="products-grid">
                    <?php
                    if (count($allProducts) > 0) {
                        foreach ($allProducts as $product) {
                    ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <?php if ($product['product_image']): ?>
                                        <img src="../images/<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
                                    <?php else: ?>
                                        <img src="../images/no-image.png" alt="No Image">
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h3><?php echo substr($product['product_name'], 0, 30); ?></h3>
                                    <p class="category"><?php echo $product['category']; ?></p>
                                    <p class="description"><?php echo substr($product['description'], 0, 50); ?>...</p>

                                    <div class="product-footer">
                                        <span class="price">Tk. <?php echo number_format($product['price'], 2); ?></span>
                                        <div class="product-actions">
                                            <button onclick="viewProduct(<?php echo $product['product_id']; ?>)" class="btn btn-small">View</button>
                                            <button onclick="addToCart(<?php echo $product['product_id']; ?>)" class="btn btn-small btn-primary">Add Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<p>No products available.</p>';
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>
    <div id="product-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modal-body">
                <p>Loading...</p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>Beauty Product Management System. </p>
    </footer>

    <script src="../js/products.js"></script>
</body>

</html>
