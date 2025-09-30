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



// নতুন Vehicle Add করার প্রসেস
if(isset($_POST['add_vehicle'])){
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_no = $_POST['vehicle_no'];
    $route = $_POST['route'];

    $sql = "INSERT INTO vehicles (vehicle_name, vehicle_no, route) 
            VALUES ('$vehicle_name','$vehicle_no','$route')";
    mysqli_query($conn, $sql);
    header("Location: add_vehicle.php");
}

// Vehicle ডিলিট করার প্রসেস
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql = "DELETE FROM vehicles WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: add_vehicle.php");
}

// সব রুট লোড করা (dropdown এর জন্য)
$routes = mysqli_query($conn, "SELECT * FROM routes");

// সব Vehicle লোড করা
$vehicles = mysqli_query($conn, "SELECT v.id, v.vehicle_name, v.vehicle_no, r.route_name, r.source, r.destination 
                                FROM vehicles v 
                                LEFT JOIN routes r ON v.route = r.id 
                                ORDER BY v.id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Vehicle</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
   <style>
    body { margin: 0; font-family: Arial, sans-serif; padding:0; }

    /* Navbar Full Width */
    .navbar { 
        background-color: #333; 
        overflow: hidden; 
        width: 100%; 
    }
    .navbar a {
        float: left; 
        display: block; 
        color: white;
        text-align: center; 
        padding: 14px 20px;
        text-decoration: none;
    }
    .navbar a:hover { background-color: #575757; }

    /* Table Design */
    table { width: 90%; margin: 20px auto; border-collapse: collapse; }
    table, th, td { border: 1px solid black; padding: 10px; text-align: center; }

    /* Form Design */
    form { margin: 20px auto; width: 50%; }
    input[type=text], select { width: 100%; padding: 8px; margin: 5px 0; }
    input[type=submit] { padding: 10px 20px; cursor: pointer; }

    /* Only inside table links red */
    table a { text-decoration: none; color: red; }
    
    .content { padding: 20px; }
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

    <h2 align="center">Add New Vehicle</h2>

    <!-- নতুন Vehicle Add Form -->
    <form method="POST" action="">
        <label>Vehicle Name:</label>
        <input type="text" name="vehicle_name" required>

        <label>Vehicle Number:</label>
        <input type="text" name="vehicle_no" required>

        <label>Route:</label>
        <select name="route" required>
            <option value="">-- Select Route --</option>
            <?php while($r = mysqli_fetch_assoc($routes)){ ?>
                <option value="<?php echo $r['id']; ?>">
                    <?php echo $r['route_name']." (".$r['source']." → ".$r['destination'].")"; ?>
                </option>
            <?php } ?>
        </select>

        <input style = "background-color: #008080; color: white; border: none; padding: 6px 12px; border-radius: 5px;font-weight:bold;" type="submit" name="add_vehicle" value="Add Vehicle">
    </form>

    <!-- সব Vehicle লিস্ট -->
    <h2 align="center">All Vehicles</h2>
    <table>
        <tr style="background:#f2f2f2;">
            <th>ID</th>
            <th>Vehicle Name</th>
            <th>Vehicle Number</th>
            <th>Route</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($vehicles)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['vehicle_name']; ?></td>
            <td><?php echo $row['vehicle_no']; ?></td>
            <td><?php echo $row['route_name']." (".$row['source']." → ".$row['destination'].")"; ?></td>
            <td>
                <a  href="add_vehicle.php?delete=<?php echo $row['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this vehicle?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
