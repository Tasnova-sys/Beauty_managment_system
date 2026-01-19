

<?php
include '../php/check_session.php';
include '../db/config.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action == 'delete' && isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
        $delete_query = "DELETE FROM users WHERE id = $user_id AND user_type = 'admin'";
        mysqli_query($conn, $delete_query);
        header("Location: users.php");
        exit;
    }
    
  }


$users_query = "SELECT id, name, email, phone, status, created_at FROM users WHERE user_type = 'admin' ORDER BY created_at DESC";
$users_result = mysqli_query($conn, $users_query);
?>

<!DOCTYPE html>
<html >
<head>
   
    <title>Manage Users</title>
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
            <h1>Manage Users</h1>
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($users_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                         echo "<td><span class='status-" . $row['status'] . "'>" . ucfirst($row['status']) . "</span></td>";
                        echo "<td>" . date('Y-m-d', strtotime($row['created_at'])) . "</td>";
                        echo "<td>";
                        echo " <a href='users.php?action=delete&id=" . $row['id'] . "' class='btn-small btn-danger' onclick  >Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
     
</body>
</html>
