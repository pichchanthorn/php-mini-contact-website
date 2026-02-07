<?php
require "config/db.php";
?>

<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact | Pich Chanthorn</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header class="header">
    <h1>Pich Chanthorn</h1>
    <p>IT Student · Web Developer</p>
</header>

<main class="container">
    <div class="card">
        <h2>Contact Me</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success">
                <?= $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>


        <form action="process.php" method="POST">
            <label>Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Message</label>
            <textarea name="message" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
</main>

<footer class="footer">
    © 2026 Pich Chanthorn · Built with PHP & MySQL
</footer>

</body>
</html>
