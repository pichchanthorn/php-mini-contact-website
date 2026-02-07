<?php
// Start session
session_start();

/* Protect admin access */
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* Only accept POST request */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: dashboard.php");
    exit;
}

/* CSRF Validation */
if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    // Invalid CSRF token
    header("Location: dashboard.php");
    exit;
}

/* DB connection */
require "../config/db.php";

/* Validate ID */
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: dashboard.php");
    exit;
}

$message_id = (int) $_POST['id'];

/* Prepare delete query (secure) */
$stmt = mysqli_prepare($conn, "DELETE FROM messages WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $message_id);
mysqli_stmt_execute($stmt);

/* Close statement */
mysqli_stmt_close($stmt);

/* Redirect back to dashboard */
header("Location: dashboard.php");
exit;
