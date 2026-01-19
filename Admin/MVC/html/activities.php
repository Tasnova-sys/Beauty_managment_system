</<?php
include '../php/check_session.php';
include '../db/config.php';

$page =isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page =20;
$offset = ($page - 1) * $per_page;


$activities_query = "SELECT a.id, a.action,  a.description, a.created_at, u.name FROM activities a JOIN users u ON a.user_id = u.id ORDER BY a.created_at DESC LIMIT $per_page OFFSET $offset";
$activities_result = mysqli_query($conn, $activities_query);    

$total_query = "SELECT COUNT(*) as total FROM activities";
$total_result = mysqli_query($conn, $total_query);   
$total_activities = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_activities / $per_page);
?>

<!DOCTYPE html>
<html >
<head>
  
    <title>Monitor activities</title>
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

        <h1>Monitor activities</h1>
      
        <table class="activities-table">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Date </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($activities_result)) {
                    echo "<tr>";
                    echo "<td>" . $row['action'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . date('Y-m-d H:i', strtotime($row['created_at'])) . "</td>";
                            echo "</tr>";
                } ?>
            </tbody>    
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++){

            
                if($i==$page){
                    echo"<span class='current-page'>$i</span>";
                } else {
                    echo"<a href='activities.php?page=$i'>$i</a>";
                }}?>
                </div>
    </div>
    </div>
</body>
</html>

