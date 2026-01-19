<?php
include '../php/check_session.php';
include '../db/config.php';

$admin_id = $_SESSION['admin_id'];

$user_count_query = "SELECT COUNT(*) as total FROM users WHERE user_type='buyer'";
$user_count_result = mysqli_query($conn, $user_count_query);
$user_count = mysqli_fetch_assoc($user_count_result)['total'];


$product_count_query = "SELECT COUNT(*) as total FROM products";
$product_count_result = mysqli_query($conn, $product_count_query);
$product_count = mysqli_fetch_assoc($product_count_result)['total'];



$recent_activities_query = "SELECT a.action, a.description, a.created_at, u.name FROM activities a JOIN users u ON a.user_id = u.id ORDER BY a.created_at DESC LIMIT 10";
$recent_activities_result = mysqli_query($conn, $recent_activities_query);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Admin Dashboard - Beauty Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    </head>
<body>
    <div class="container">
        <nav class ="navbar">
            <div class ="navbar-brand">Beauty Shop Admin</div>
            <div class ="navbar-menu">

                <a href="dashboard.php" >Dashboard</a>
                <a href="users.php">Users</a>
                <a href="products.php">Products</a>
                <a href="activities.php">Activities</a>
               <a href="reports.php">Reports</a>
                <a href="profile.php">Profile</a>
                <a href="../php/logout.php">Logout</a>
</div>
</nav>
        <div class ="content">

        <h1>Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['admin_name']; ?> </p>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <h2>Total Buyers</h2>
        <p class ="start-number"><?php echo $user_count; ?></p>
    </div>
    <div class="dashboard-card">
        <h2>Total Products</h2>
        <p class = "start-number"><?php echo $product_count; ?></p>
    </div>
   
    
    </div>

    <div class ="recent-activities">
        <h2>Recent Activities</h2>
        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Date </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($recent_activities_result)) {
                    echo "<tr>";
                    echo "<td>" . $row['action'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . date('Y-m-d H:i', strtotime($row['created_at'])) . "</td>";
                            echo "</tr>";
                } ?>
            </tbody>    
        </table>
    </div>
        </div>
    </div>
</body>
</html>

