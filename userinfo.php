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
 
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>User INFO</h1>
        <form action="update_user.php" method="POST">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
 
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user_data['name']) ?>">
            <br/>
 
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" value="<?= htmlspecialchars($user_data['email']) ?>">
            <br/>
 
            <label for="birth_year">Birth year:</label>
            <input type="text" name="birth_year" id="birth_year" value="<?= htmlspecialchars($user_data['birth_year']) ?>">
            <br/>
 
            <label>Gender:</label>
            <label><input type="radio" name="gender" value="male" <?= $user_data['gender'] == 'male' ? 'checked' : '' ?>> Male</label>
            <label><input type="radio" name="gender" value="female" <?= $user_data['gender'] == 'female' ? 'checked' : '' ?>> Female</label>
            <br/>
 
            <label>Num of limbs:</label>
            <input type="text" name="limbs" id="limbs" value="<?= htmlspecialchars($user_data['limbs']) ?>">
            <br/>
 
            <label for="bio">Bio:</label>
            <textarea name="bio" id="bio"><?= htmlspecialchars($user_data['bio']) ?></textarea>
            <br/>
 
            <label>
                <input type="checkbox" name="contract" value="accepted" <?= $user_data['contract'] ? 'checked' : '' ?>> Agree
            </label>
            <br/>
 
            <input type="submit" value="Save">
        </form>
        <p><a href="logout.php">Logout</a></p>
</div>
 
</body>
</html>