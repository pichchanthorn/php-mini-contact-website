<?php
session_start();
require "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, username, password FROM admins WHERE username = ? LIMIT 1"
);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin  = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$admin) {
    $_SESSION['error'] = "Invalid username or password.";
    header("Location: login.php");
    exit;
}

if (!password_verify($password, $admin['password'])) {
    $_SESSION['error'] = "Invalid username or password.";
    header("Location: login.php");
    exit;
}

/* ✅ SUCCESS */
$_SESSION['admin'] = $admin['username'];

header("Location: dashboard.php");
exit;
