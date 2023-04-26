<?php
session_start();
 
$servername = "localhost";
$username = "u52979";
$password = "2087021";
$dbname = "u52979";
 
// Создание подключения
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
 
$login = $_POST['login'];
$entered_password = $_POST['password'];
 
// Подготовленное выражение
$stmt = $db->prepare("SELECT user_id, password FROM user_auth WHERE login = :login");
$stmt->bindParam(':login', $login);
$stmt->execute();
 
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (password_verify($entered_password, $row['password'])) {
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: userinfo.php");
        exit();
    } else {
        $_SESSION['error'] = "Неверный логин или пароль";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Неверный логин или пароль";
    header("Location: login.php");
    exit();
}
?>