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


$result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Messages</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table {
            border-collapse: collapse; width: 100%;
        }
        th, td {
            border: 1px solid #ccc; padding: 10px; text-align: left;
        }
        th { background: #333; color: white; }
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
    <h2>User Messages</h2>
    <br><br>

    <table>
    <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
        <th>Action</th> <!-- New column for delete -->
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['message'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <a href="delete_message.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this message?');" style="color:red; text-decoration:none; font-weight:bold;">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

</div>
</body>
</html>



