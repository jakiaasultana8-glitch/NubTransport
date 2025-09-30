
<?php
session_start();

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

    <?php include '../slideshow.php'; ?>

    <div class="content">
        <h2>Welcome,  <?php echo $_SESSION['name'] ?> !</h2>
        <p>Use the menu above to manage the system.</p>
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
