<?php
session_start();

/* Protect admin page */
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require "../config/db.php";

/* CSRF Token */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* Fetch messages */
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header class="header">
    <h1>Admin Panel</h1>
    <p>Messages from Contact Form</p>
</header>

<main class="container">
    <div class="card">

        <!-- Admin Actions -->
        <div class="admin-actions">
            <a href="reset_password.php" class="btn">Reset Password</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <h2>Inbox</h2>

        <div class="messages">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php $i = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>

                    <div class="message-card">

                        <div class="message-top">
                            <span>
                                #<?= $i++; ?>
                                <?= htmlspecialchars($row['created_at']); ?>
                            </span>
                        </div>

                        <p>
                            <strong>Name:</strong>
                            <?= htmlspecialchars($row['name']); ?>
                        </p>

                        <p>
                            <strong>Email:</strong>
                            <?= htmlspecialchars($row['email']); ?>
                        </p>

                        <p class="message-text">
                            <strong>Message:</strong><br>
                            <?= nl2br(htmlspecialchars($row['message'])); ?>
                        </p>

                        <!-- Delete Message -->
                        <form
                            action="delete_message.php"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this message?');"
                        >
                            <input type="hidden" name="id" value="<?= (int)$row['id']; ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                            <button type="submit" class="btn btn-danger" style="width:100%;">
                                Delete
                            </button>
                        </form>

                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p class="empty">No messages yet.</p>
            <?php endif; ?>
        </div>

    </div>
</main>

<footer class="footer">
    © 2026 Pich Chanthorn · Admin Panel
</footer>

</body>
</html>
