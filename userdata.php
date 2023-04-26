<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'submit.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['password'])) {
    header("Location: index.php");
    exit();
}

$login = $_SESSION['login'];
$password = $_SESSION['password'];
$user_id = $_SESSION['user_id'];

try {

    unset($_SESSION['login']);
    unset($_SESSION['password']);
} catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome!</h1>
        <p>Login: <?php echo htmlspecialchars($login); ?></p>
        <p>Password: <?php echo htmlspecialchars($password); ?></p>
        <p><a href="index.php">To index</a></p>
    </div>
</body>
</html>
