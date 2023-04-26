<?php
session_start();
 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
 
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
 
$user_id = $_SESSION['user_id'];
 
// Обработка данных формы и обновление информации о пользователе в базе данных
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birth_year = $_POST['birth_year'];
    $gender = $_POST['gender'];
    $limbs = $_POST['limbs'];
    $bio = $_POST['bio'];
    $contract = isset($_POST['contract']) ? 1 : 0;
 
    $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, birth_year = ?, gender = ?, limbs = ?, bio = ?, contract = ? WHERE id = ?");
    $stmt->execute([$name, $email, $birth_year, $gender, $limbs, $bio, $contract, $user_id]);
 
    header("Location: userinfo.php");
    exit();
}
?>