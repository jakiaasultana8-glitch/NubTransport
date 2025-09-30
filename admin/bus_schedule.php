<?php
session_start();
include("../db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

// Add Schedule
if (isset($_POST['add'])) {
    $route = $_POST['route'];
    $time = $_POST['time'];
    $bus_no = $_POST['bus_no'];

    $sql = "INSERT INTO bus_schedule (route, time, bus_no) VALUES ('$route','$time','$bus_no')";
    $conn->query($sql);
}

// Delete Schedule
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM bus_schedule WHERE id=$id");
}

// Update Schedule
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $route = $_POST['route'];
    $time = $_POST['time'];
    $bus_no = $_POST['bus_no'];

    $sql = "UPDATE bus_schedule SET route='$route', time='$time', bus_no='$bus_no' WHERE id=$id";
    $conn->query($sql);
}

// Fetch bus schedule
$result = $conn->query("SELECT * FROM bus_schedule");

// Fetch vehicles
$vehicle_result = $conn->query("SELECT vehicle_no FROM vehicles");
$vehicles = [];
while($v = $vehicle_result->fetch_assoc()){
    $vehicles[] = $v['vehicle_no'];
}

// Fetch routes
$route_result = $conn->query("SELECT route_name FROM routes");
$routes = [];
while($r = $route_result->fetch_assoc()){
    $routes[] = $r['route_name'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bus Schedule Management</title>
    <style>
        body{font-family: Arial; margin:0; padding:0; background:#f5f5f5;}
        h2{color:#333; margin-top:0;}

        /* Navbar */
        .navbar { background-color: #333; overflow: hidden; width: 100%; }
        .navbar a {
            float: left; display: block; color: white;
            text-align: center; padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover { background-color: #575757; }
        .navbar a.logout { float:right; }

        .content { padding: 20px; }

        /* Form Styling */
        form { 
            background:#fff; 
            padding:20px; 
            border:1px solid #ddd; 
            width:400px; 
            margin:30px auto; /* center horizontally */
            border-radius:8px;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }
        form label{
            display:block;
            margin-top:15px;
            font-weight:bold;
            color:#555;
        }
        form input[type="text"], form select, form input[type="time"], form button{
            width:100%;
            padding:10px;
            margin-top:5px;
            border-radius:4px;
            border:1px solid #ccc;
            box-sizing:border-box;
        }
        form button{
            background:#008080;
            color:#fff;
            border:none;
            padding:10px;
            cursor:pointer;
            border-radius:4px;
            margin-top:20px;
            font-weight:bold;
        }
        form button:hover{
            background:#218838;
        }

        /* Table Styling */
        table{border-collapse:collapse; width:100%; background:#fff; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
        th,td{border:1px solid #ddd; padding:10px; text-align:center;}
        th{background:#333; color:#fff;}
        table input[type="text"], table input[type="time"], table select{
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
            cursor:pointer;
        }
        table button:hover{
            background:#0069d9;
        }
        a{color:red; text-decoration:none;}
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
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <h2 >Bus Schedule Management</h2>

        <!-- Add Form -->
        <form method="POST" action="bus_schedule.php">
            <label>Route</label>
            <select name="route" required>
                <?php foreach($routes as $r){ ?>
                    <option value="<?php echo $r; ?>"><?php echo $r; ?></option>
                <?php } ?>
            </select>

            <label>Bus No</label>
            <select name="bus_no" required>
                <?php foreach($vehicles as $v){ ?>
                    <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                <?php } ?>
            </select>

            <label>Time</label>
            <input type="time" name="time" required>

            <button type="submit" name="add">Add Schedule</button>
        </form>

        <!-- Show Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Route</th>
                <th>Time</th>
                <th>Bus No</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <form method="POST">
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <select name="route">
                            <?php foreach($routes as $r){ ?>
                                <option value="<?php echo $r; ?>" <?php if($row['route']==$r) echo 'selected'; ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="time" name="time" value="<?php echo $row['time']; ?>"></td>
                    <td>
                        <select name="bus_no">
                            <?php foreach($vehicles as $v){ ?>
                                <option value="<?php echo $v; ?>" <?php if($row['bus_no']==$v) echo 'selected'; ?>><?php echo $v; ?></option>
                            <?php } ?>
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
