<?php
session_start();
session_unset();   // সব session variable clear করবে
session_destroy(); // session পুরোপুরি ধ্বংস করবে
header("Location: ../index.php"); // লগইন পেজে রিডাইরেক্ট
exit();
?>
