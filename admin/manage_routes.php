<?php
session_start();
include("../db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

// Common login check
if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit();
}

// Role based restriction
// শুধুমাত্র admin panel এ ঢুকতে পারবে admin role
if($_SESSION['role'] != 'admin'){
    header("Location: ../user/dashboard.php");
    exit();
}

// নতুন রুট Add করার প্রসেস
if(isset($_POST['add_route'])){
    $route_name = $_POST['route_name'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $distance = $_POST['distance'];

    $sql = "INSERT INTO routes (route_name, source, destination, distance) 
            VALUES ('$route_name','$source','$destination','$distance')";
    mysqli_query($conn, $sql);
    header("Location: manage_routes.php");
}

// রুট ডিলিট করার প্রসেস
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql = "DELETE FROM routes WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: manage_routes.php");
}

// সব রুট বের করা
$routes = mysqli_query($conn, "SELECT * FROM routes ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Routes</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <style>
        body { margin: 0; font-family: Arial, sans-serif;padding:0; }
        .navbar { background-color: #333; overflow: hidden; width: 100% auto; }
        .navbar a {
            float: left; display: block; color: white;
            text-align: center; padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover { background-color: #575757; }
        .content { padding: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 10px; text-align: center; }
        form { margin: 20px auto; width: 50%; }
        input[type=text], input[type=number] { width: 100%; padding: 8px; margin: 5px 0; }
        input[type=submit] { padding: 10px 20px; cursor: pointer; }
        a { text-decoration: none; color: red; }
    </style>
</head>
<body>
<!-- Navbar -->
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_routes.php">Manage Routes</a>
        <a href="add_vehicle.php">Manage Vehicles</a>
        <a href="bus_schedule.php">Bus Schedule</a>
        <a href="ticket_pricing.php">Ticket Pricing</a>
        <a href="view_bookings.php">View Bookings</a>
        <a href="view_messages.php">View Messages</a>
        <a href="logout.php"  style="float:right;">Logout</a>
    </div>

    <div class="content">
    <h2 align="center">Add New Routes</h2>

    <!-- নতুন রুট Add Form -->
    <form method="POST" action="">
        <label>Route Name:</label>
        <input type="text" name="route_name" required>

        <label>Source:</label>
        <input type="text" name="source" required>

        <label>Destination:</label>
        <input type="text" name="destination" required>

        <label>Distance (km):</label>
        <input type="number" step="0.01" name="distance" required>

        <input style = "background-color: #008080; color: white; border: none; padding: 6px 12px; border-radius: 5px;font-weight:bold;" type="submit" name="add_route" value="Add Route">
    </form>

    <!-- সব রুট লিস্ট -->
    <table>
        <tr>
            <th>ID</th>
            <th>Route Name</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Distance (km)</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($routes)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['route_name']; ?></td>
            <td><?php echo $row['source']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['distance']; ?></td>
            <td>
                <a href="manage_routes.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
