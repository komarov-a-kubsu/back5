<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Авторизация</h1>
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <form action="login_submit.php" method="POST" id="form">
            <label for="login">Логин:</label>
            <input type="text" name="login" id="login" required>
 
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
 
            <input type="submit" value="Войти"> <br/>
            <a href="index.php" class="auth-button">To index</a>
        </form>
    </div>
</body>
</html>