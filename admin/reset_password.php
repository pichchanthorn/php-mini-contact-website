<?php
session_start();
require "../config/db.php";

/* ===== Protect Admin Page ===== */
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ===== CSRF Token ===== */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* ===== Handle Form Submit ===== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* CSRF check */
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die("Invalid CSRF token");
    }

    $oldPassword     = $_POST['old_password'] ?? '';
    $newPassword     = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "New passwords do not match.";
        header("Location: reset_password.php");
        exit;
    }

    if (strlen($newPassword) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters.";
        header("Location: reset_password.php");
        exit;
    }

    /* ===== Get admin from DB ===== */
    $username = $_SESSION['admin'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, password FROM admins WHERE username = ? LIMIT 1"
    );
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin  = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$admin || !password_verify($oldPassword, $admin['password'])) {
        $_SESSION['error'] = "Old password is incorrect.";
        header("Location: reset_password.php");
        exit;
    }

    /* ===== Update Password ===== */
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

    $update = mysqli_prepare(
        $conn,
        "UPDATE admins SET password = ? WHERE id = ?"
    );
    mysqli_stmt_bind_param($update, "si", $hashed, $admin['id']);
    mysqli_stmt_execute($update);
    mysqli_stmt_close($update);

    $_SESSION['success'] = "Password updated successfully.";
    header("Location: reset_password.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | Admin</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header class="header">
    <h1>Reset Password</h1>
    <p>Admin Security</p>
</header>

<main class="container">
    <div class="card">

        <h2>Change Password</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error"><?= htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?= htmlspecialchars($_SESSION['success']); ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <label>Old Password</label>
            <input type="password" name="old_password" required>

            <label>New Password</label>
            <input type="password" name="new_password" required>

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Update Password</button>
        </form>

        <div class="form-actions">
            <a href="dashboard.php" class="btn-secondary">← Back to Dashboard</a>
        </div>

    </div>
</main>

<footer class="footer">
    © 2026 Pich Chanthorn · Admin Panel
</footer>

</body>
</html>
