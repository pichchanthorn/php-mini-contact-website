<?php
session_start();
require "config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = trim($_POST["name"]);
    $email   = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: index.php");
        exit;
    }

    $sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Message sent successfully. Thank you!";
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Database error.";
    }

    mysqli_close($conn);
    header("Location: index.php");
    exit;
}
