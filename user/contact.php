<?php
include '../db.php';

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

if (isset($_POST['send_message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, message) 
            VALUES ('$name', '$email', '$message')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}





?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        .navbar { background-color: #333; overflow: hidden; width: 100%; }
        .navbar a {
            float: left; display: block; color: white;
            padding: 14px 20px; text-decoration: none;
        }
        .navbar a:hover { background-color: #575757; }
        .content { padding: 20px; }
        form { max-width: 500px; margin: auto; }
        input, textarea {
            width: 100%; padding: 10px; margin: 8px 0;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            background: green; color: white; padding: 10px 20px;
            border: none; border-radius: 5px; cursor: pointer;
        }
        button:hover { background: darkgreen; }
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
        <h2>Contact Us</h2>
        <form method="POST" action="contact.php">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Message:</label>
            <textarea name="message" rows="5" required></textarea>
            <button 
    style="background-color:#008080; color:white; border:none; 
           padding:10px 20px; border-radius:5px; font-weight:bold; 
           width:100%; text-align:center;" 
    type="submit" name="send_message">
    Send
</button>
        </form>
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

