<?php
session_start();
include("../db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

// Add Ticket Price
if (isset($_POST['add'])) {
    $route = !empty($_POST['new_route']) ? $_POST['new_route'] : $_POST['route'];
    $price = $_POST['price'];
    $bus_type = $_POST['bus_type'];

    // নতুন রুট routes টেবিলে না থাকলে যুক্ত করো
    $check_route = $conn->query("SELECT * FROM routes WHERE route_name='$route'");
    if($check_route->num_rows == 0){
        $conn->query("INSERT INTO routes (route_name) VALUES ('$route')");
    }

    $sql = "INSERT INTO ticket_pricing (route, price, bus_type) VALUES ('$route','$price','$bus_type')";
    $conn->query($sql);
}

// Delete Ticket Price
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM ticket_pricing WHERE id=$id");
}

// Update Ticket Price
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $route = $_POST['route'];
    $price = $_POST['price'];
    $bus_type = $_POST['bus_type'];

    // নতুন রুট routes টেবিলে না থাকলে যুক্ত করো
    $check_route = $conn->query("SELECT * FROM routes WHERE route_name='$route'");
    if($check_route->num_rows == 0){
        $conn->query("INSERT INTO routes (route_name) VALUES ('$route')");
    }

    $sql = "UPDATE ticket_pricing SET route='$route', price='$price', bus_type='$bus_type' WHERE id=$id";
    $conn->query($sql);
}

// Fetch all ticket pricing
$result = $conn->query("SELECT * FROM ticket_pricing");

// Fetch all routes from routes table
$route_result = $conn->query("SELECT route_name FROM routes");
$routes = [];
while($r = $route_result->fetch_assoc()){
    $routes[] = $r['route_name'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket Pricing Management</title>
    <style>
        body{font-family: Arial; margin:20px; background:#f5f5f5;padding:0; margin:0;}
        h2{color:#333;}
        
        /* Form Styling */
        /* Form Styling */
form { 
    background:#fff; 
    padding:20px; 
    border:1px solid #ddd; 
    width:400px; 
    margin:30px auto; /* center horizontally with top-bottom margin */
    border-radius:8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

        form label{
            display:block;
            margin-top:15px;
            font-weight:bold;
            color:#555;
        }
        form input[type="text"], form select, form button{
            width:100%;
            padding:10px;
            margin-top:5px;
            border-radius:4px;
            border:1px solid #ccc;
            box-sizing: border-box;
        }
        form button{
            background:#28a745;
            color:#fff;
            border:none;
            cursor:pointer;
            margin-top:20px;
            font-weight:bold;
            transition: background 0.3s;
        }
        form button:hover{
            background:#218838;
        }

        /* Table Styling */
        table{border-collapse:collapse; width:100%; background:#fff; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
        th,td{border:1px solid #ddd; padding:10px; text-align:center;}
        th{background:#333; color:#fff;}
        table input[type="text"], table select{
            width:100%;
            padding:6px;
            border-radius:4px;
            border:1px solid #ccc;
            box-sizing:border-box;
        }
        table button{
            padding:5px 12px;
            border:none;
            border-radius:4px;
            background:#008080;
            color:#fff;
	    font-weight:bold;
            cursor:pointer;
            margin-bottom:3px;
        }
        table button:hover{
            background:#0069d9;
        }
        a{color:red; text-decoration:none;}
        .navbar { background-color: #333; overflow: hidden; width: 100%; }
        .navbar a {
            float: left; display: block; color: white;
            text-align: center; padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover { background-color: #575757; }
	.content { padding: 20px; }
    </style>
</head>
<body>
    <!-- ✅ Admin Menu Bar -->
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_routes.php">Manage Routes</a>
        <a href="add_vehicle.php">Manage Vehicles</a>
        <a href="bus_schedule.php">Bus Schedule</a>   <!-- নতুন -->
        <a href="ticket_pricing.php">Ticket Pricing</a> <!-- নতুন -->
        <a href="view_bookings.php">View Bookings</a>
        <a href="view_messages.php">View Messages</a>
        <a href="logout.php" style="float:right;">Logout</a>
    </div>
    <div class="content">
    <h2>Ticket Pricing Management</h2>

    <!-- Add Form -->
    <form method="POST">
        <label>Route</label>
        <select name="route">
            <?php foreach($routes as $route_option) { ?>
                <option value="<?php echo $route_option; ?>"><?php echo $route_option; ?></option>
            <?php } ?>
        </select>

        <label>Price</label>
        <input type="text" name="price" required>

        <label>Bus Type</label>
        <select name="bus_type" required>
            <option value="AC">AC</option>
            <option value="Non-AC">Non-AC</option>
        </select>

        <button style = "background-color: #008080; color: white; border: none; padding: 6px 12px; border-radius: 5px;font-weight:bold;" type="submit" name="add">Add Ticket</button>
    </form>

    <!-- Show Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Route</th>
            <th>Price</th>
            <th>Bus Type</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <form method="POST">
                <td><?php echo $row['id']; ?></td>
                <td>
                    <select name="route">
                        <?php foreach($routes as $route_option) { ?>
                            <option value="<?php echo $route_option; ?>" <?php if($row['route']==$route_option) echo 'selected'; ?>>
                                <?php echo $route_option; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="text" name="price" value="<?php echo $row['price']; ?>"></td>
                <td>
                    <select name="bus_type">
                        <option value="AC" <?php if($row['bus_type']=='AC') echo 'selected'; ?>>AC</option>
                        <option value="Non-AC" <?php if($row['bus_type']=='Non-AC') echo 'selected'; ?>>Non-AC</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="update">Update</button>
                    <a href="?delete=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
