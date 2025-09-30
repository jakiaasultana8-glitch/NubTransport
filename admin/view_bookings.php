<?php
session_start();
include '../db.php';
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

// Vehicle wise booking summary
$sql = "SELECT v.id, v.vehicle_name, v.vehicle_no, r.source, r.destination, 
               COUNT(b.id) AS total_bookings
        FROM vehicles v
        LEFT JOIN routes r ON v.route = r.id
        LEFT JOIN bookings b ON v.id = b.vehicle_id
        GROUP BY v.id, v.vehicle_name, v.vehicle_no, r.source, r.destination
        ORDER BY total_bookings DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Wise Bookings</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        .details { display: none; margin: 10px 0; }
        .toggle-btn {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
    </style>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        .navbar { background-color: #333; overflow: hidden; width: 100%; }
        .navbar a {
            float: left; display: block; color: white;
            text-align: center; padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover { background-color: #575757; }
        .content { padding: 20px; }
    </style>
    <script>
        

	function toggleDetails(id) {
    var x = document.getElementById("details-" + id);
    var current = window.getComputedStyle(x).display;

    if (current === "none") {
        x.style.display = "table-row"; // table row visible হবে
    } else {
        x.style.display = "none";
    }
}
    </script>
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
    <h2>Vehicle Wise Bookings</h2>
    <br><br>

    <table>
        <tr>
            <th>SL</th>
            <th>Vehicle</th>
            <th>Route</th>
            <th>Total Bookings</th>
            <th>Action</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $sl = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $sl++ . "</td>";
                echo "<td>" . $row['vehicle_name'] . " (" . $row['vehicle_no'] . ")</td>";
                echo "<td>" . $row['source'] . " → " . $row['destination'] . "</td>";
                echo "<td>" . $row['total_bookings'] . "</td>";
                echo "<td><button style='text-decoration:none;background-color: #008080; color: white; border: none; padding: 6px 12px; border-radius: 5px;font-weight:bold;' class='toggle-btn' onclick='toggleDetails(" . $row['id'] . ")'>View Details</span></button>";
                echo "</tr>";

                // ✅ Fetch bookings of this vehicle
                $vehicle_id = $row['id'];
                $details_sql = "SELECT b.id, u.username, b.booking_date 
                                FROM bookings b 
                                LEFT JOIN users u ON b.user_id = u.id 
                                WHERE b.vehicle_id = '$vehicle_id'
                                ORDER BY b.booking_date ASC";
                $details_result = mysqli_query($conn, $details_sql);

                echo "<tr id='details-" . $row['id'] . "' class='details'><td colspan='5'>";
                if (mysqli_num_rows($details_result) > 0) {
                    echo "<table>
                            <tr>
                                <th>Booking ID</th>
                                <th>User</th>
                                <th>Booking Date</th>
                            </tr>";
                    while ($d = mysqli_fetch_assoc($details_result)) {
                        echo "<tr>
                                <td>" . $d['id'] . "</td>
                                <td>" . $d['username'] . "</td>
                                <td>" . $d['booking_date'] . "</td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No bookings for this vehicle.";
                }
                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No vehicles or bookings found</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
