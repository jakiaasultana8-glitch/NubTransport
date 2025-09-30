<?php
session_start();

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

?>

<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; }
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
        <h2>About Us</h2>
        <p>
            Welcome to our Transport Management System! <br>
            Our goal is to make bus ticket booking easier, faster, and more convenient. 
            We provide real-time seat availability, secure booking, and easy cancellation options.
        </p>
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
