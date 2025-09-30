
<?php
session_start();
include '../db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user'){
    header("Location: ../index.php");
    exit();
}

if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit();
}

if($_SESSION['role'] != 'user'){
    header("Location: ../admin/dashboard.php");
    exit();
}


// Fetch vehicles with seat availability for selected date
$date = isset($_POST['booking_date']) ? $_POST['booking_date'] : date('Y-m-d');

$sql = "SELECT v.id, v.vehicle_name, v.vehicle_no, r.source, r.destination, v.total_seats,
        (SELECT COUNT(*) FROM bookings b 
         WHERE b.vehicle_id = v.id AND b.booking_date = '$date') AS booked_seats
        FROM vehicles v
        LEFT JOIN routes r ON v.route = r.id";
$result = mysqli_query($conn, $sql);

// Booking Insert
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['book_vehicle'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $user_id = $_SESSION['user_id'];
    $booking_date = $_POST['booking_date'];

    // check seat availability again (for safety)
    $check = "SELECT total_seats, 
                (SELECT COUNT(*) FROM bookings 
                 WHERE vehicle_id='$vehicle_id' AND booking_date='$booking_date') AS booked 
              FROM vehicles WHERE id='$vehicle_id'";
    $check_result = mysqli_query($conn, $check);
    $row = mysqli_fetch_assoc($check_result);

    if ($row['booked'] < $row['total_seats']) {
        $insert = "INSERT INTO bookings (user_id, vehicle_id, booking_date) 
                   VALUES ('$user_id', '$vehicle_id', '$booking_date')";
        if (mysqli_query($conn, $insert)) {
            echo "<script>alert('Booking Successful');window.location='my_bookings.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('No seats available for this bus on selected date!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Ticket</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        button:disabled { background: gray; cursor: not-allowed; }
    </style>
    <style>
        body { font-family: Arial, sans-serif;margin: 0; }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover { background-color: #575757; }
        .content { padding: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="book_ticket.php">Book Ticket</a>
        <a href="my_bookings.php">My Bookings</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
        <a href="logout.php" style="float:right;">Logout</a>
    </div>
    <div class="content">
    <h2>Book Ticket</h2>
    <br><br>

    <form method="POST">
        <label>Select Date: </label>
        <input type="date" name="booking_date" value="<?php echo $date; ?>" required>
        <input style = "background-color: #008080; color: white; border: none; padding: 6px 12px; border-radius: 5px;font-weight:bold;" type="submit" value="Check Availability">
    </form>
    <br>

    <table>
        <tr>
            <th>Vehicle</th>
            <th>Route</th>
            <th>Total Seats</th>
            <th>Booked</th>
            <th>Available</th>
            <th>Action</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $available = $row['total_seats'] - $row['booked_seats'];
                echo "<tr>";
                echo "<td>" . $row['vehicle_name'] . " (" . $row['vehicle_no'] . ")</td>";
                echo "<td>" . $row['source'] . " → " . $row['destination'] . "</td>";
                echo "<td>" . $row['total_seats'] . "</td>";
                echo "<td>" . $row['booked_seats'] . "</td>";
                echo "<td>" . $available . "</td>";
                echo "<td>
                        <form method='POST' actio="book_ticket.php">
                            <input type='hidden' name='vehicle_id' value='" . $row['id'] . "'>
                            <input type='hidden' name='booking_date' value='" . $date . "'>
                            <button style = 'background-color: #008080; color: white; border: none; padding: 6px 12px; border-radius: 5px;font-weight:bold;' type='submit' name='book_vehicle' " . ($available <= 0 ? "disabled" : "") . ">Book Now</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No vehicles found</td></tr>";
        }
        ?>
    </table>
</div>

<!-- Footer Section -->
<footer style="background:#1e2230; color:#ddd; padding:40px 20px; font-family:Arial, sans-serif;">
    <div style="max-width:1200px; margin:auto; display:grid; grid-template-columns: repeat(auto-fit,minmax(220px,1fr)); gap:30px;">

        <!-- Contact -->
        <div>
            <h3 style="color:#fff; margin-bottom:15px; border-bottom:2px solid #5a4fcf; display:inline-block;">CONTACT</h3>
            <p>123 Bus Station Road, Dhaka</p>
            <p>Email: info@buscompany.com</p>
            <p>Tel: 02-987654, Ext-101</p>
            <p>Phone: 01711-123456, 01822-987654</p>
        </div>


        <!-- Services -->
        <div>
            <h3 style="color:#fff; margin-bottom:15px; border-bottom:2px solid #5a4fcf; display:inline-block;">SERVICES</h3>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Online Booking</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Bus Schedule</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Ticket Pricing</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Offers & Discounts</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Cancellation Policy</a></p>
        </div>

        <!-- Administration -->
        <div>
            <h3 style="color:#fff; margin-bottom:15px; border-bottom:2px solid #5a4fcf; display:inline-block;">ADMINISTRATION</h3>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Driver Panel</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Staff Information</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">ERP System</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">HR & Payroll</a></p>
        </div>

        <!-- Important Links -->
        <div>
            <h3 style="color:#fff; margin-bottom:15px; border-bottom:2px solid #5a4fcf; display:inline-block;">IMPORTANT LINKS</h3>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Photo Gallery</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Customer Reviews</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">FAQ</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Terms & Conditions</a></p>
            <p><a href="#" style="color:#ddd; text-decoration:none;">Privacy Policy</a></p>
        </div>
    </div>

    <!-- Bottom -->
    <div style="text-align:center; margin-top:30px; border-top:1px solid #444; padding-top:15px; color:#aaa; font-size:14px;">
        © 2025 NUB Bus Management System. All Rights Reserved.
    </div>
</footer>

</body>
</html>

