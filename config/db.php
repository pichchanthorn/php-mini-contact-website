<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "mini_contact_site";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
