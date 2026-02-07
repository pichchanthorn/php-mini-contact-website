<?php
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header class="header">
    <h1>Admin Login</h1>
    <p>Secure Access</p>
</header>

<main class="container">
    <div class="card">

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error">
                <?= htmlspecialchars($_SESSION['error']); ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="process_login.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

    </div>
</main>

<footer class="footer">
    © 2026 Pich Chanthorn
</footer>

</body>
</html>
