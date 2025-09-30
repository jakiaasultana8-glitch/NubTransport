<?php
session_start();
include '../db.php';

// Check if user is admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

// Validate message ID
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = intval($_GET['id']);
    
    // Delete query
    $query = "DELETE FROM contact_messages WHERE id = $id";
    if(mysqli_query($conn, $query)){
        header("Location: view_messages.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting message: " . mysqli_error($conn);
    }
} else {
    header("Location: view_messages.php");
    exit();
}
?>
