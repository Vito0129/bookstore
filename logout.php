<?php session_start();
session_destroy(); // Destroy session on logout
header("location:login.php"); // reroute to login page
?>