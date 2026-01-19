<?php
include '../php/check_session.php';
include '../db/config.php';

$users_report = array();
$products_report = array();


if (isset($_POST['generate_report'])) {
    $report_type = $_POST['report_type'];
    
    if ($report_type == 'users') {
        $query = "SELECT COUNT(*) as total_users, 
                 SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_users,
                 SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive_users
                 FROM users WHERE user_type = 'buyer'";
        $result = mysqli_query($conn, $query);
        $users_report = mysqli_fetch_assoc($result);
    } elseif ($report_type == 'products') {
        $query = "SELECT COUNT(*) as total_products, 
                 SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available,
                 SUM(CASE WHEN status = 'unavailable' THEN 1 ELSE 0 END) as unavailable,
                 SUM(stock) as total_stock,
                 SUM(price * stock) as inventory_value
                 FROM products";
        $result = mysqli_query($conn, $query);
        $products_report = mysqli_fetch_assoc($result);
    } 
    }

?>

<!DOCTYPE html>
<html >
<head>
    
    <title>Generate Reports</title>
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
            <h1>Generate Reports</h1>
            
            <div class="report-form">
                <h2>Select Report Type</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Report Type:</label>
                        <select name="report_type">
                            <option value="users">Users Report</option>
                            <option value="products">Products Report</option>
                            
                        </select>
                    </div>
                    <button type="submit" name="generate_report" class="btn">Generate Report</button>
                </form>
            </div>

            <?php if (!empty($users_report)) { ?>
            <div class="report-result">
                <h2>Users Report</h2>
                <table class="report-table">
                    <tr>
                        <th>Metric</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Total Users</td>
                        <td><?php echo $users_report['total_users']; ?></td>
                    </tr>
                    <tr>
                        <td>Active Users</td>
                        <td><?php echo $users_report['active_users']; ?></td>
                    </tr>
                    <tr>
                        <td>Inactive Users</td>
                        <td><?php echo $users_report['inactive_users']; ?></td>
                    </tr>
                </table>
            </div>
            <?php } ?>

            <?php if (!empty($products_report)) { ?>
            <div class="report-result">
                <h2>Products Report</h2>
                <table class="report-table">
                    <tr>
                        <th>Metric</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Total Products</td>
                        <td><?php echo $products_report['total_products']; ?></td>
                    </tr>
                    <tr>
                        <td>Available</td>
                        <td><?php echo $products_report['available']; ?></td>
                    </tr>
                    <tr>
                        <td>Unavailable</td>
                        <td><?php echo $products_report['unavailable']; ?></td>
                    </tr>
                    <tr>
                        <td>Total Stock</td>
                        <td><?php echo $products_report['total_stock']; ?></td>
                    </tr>
                    <tr>
                        <td>Inventory Value</td>
                        <td>$<?php echo number_format($products_report['inventory_value'], 2); ?></td>
                    </tr>
                </table>
            </div>
            <?php } ?>

        </div>
    </div>
</body>
</html>
