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
$errors = [];
$success = false;
 
// Обработка данных формы и обновление информации о пользователе в базе данных
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birth_year = $_POST['birth_year'];
    $gender = $_POST['gender'];
    $limbs = $_POST['limbs'];
    $bio = $_POST['bio'];
    $contract = isset($_POST['contract']) ? 1 : 0;
 
    // Валидация данных
    if (!preg_match('/^[\p{L}\s]+$/u', $name)) {
    $errors[] = "Field name contains forbidden symbols";
}
 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*\.ru$/', $email)) {
        $errors[] = "E-mail should be in format example@example.ru";
    }
 
    if ($birth_year < 1900 || $birth_year > 2023) {
        $errors[] = "Bith year should be in range 1900-2023";
    }
 
    if ($limbs < 1 || $limbs > 4) {
        $errors[] = "Num of libs can be in range 1-4";
    }
 
    if (empty($errors)) {
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, birth_year = ?, gender = ?, limbs = ?, bio = ?, contract = ? WHERE id = ?");
        $stmt->execute([$name, $email, $birth_year, $gender, $limbs, $bio, $contract, $user_id]);
        $success = true;
    }
}
 
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <h1>Edit info</h1>
 
       <?php if (!empty($errors)) {
    echo '<div class="error-container">';
    foreach ($errors as $error) {
        echo '<p class="error"> ' . $error . '</p>';
    }
    echo '</div>';
} ?>

 
        <?php if (empty($errors)) {
    echo '<div class="success-container">';
    echo '<p class="success"> Saved Successfully </p>';
    echo '</div>';
} ?>
 
        <form action="userinfo.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= $user['name'] ?>" required> <br/>
 
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" value="<?= $user['email'] ?>" required> <br/>
 
            <label for="birth_year">Birth year:</label>
            <input type="number" name="birth_year" id="birth_year" value="<?= $user['birth_year'] ?>" min="1900" max="2023" required> <br/>
 
            <label>Gender:</label>
            <label><input type="radio" name="gender" value="male" <?= $user['gender'] == 'male' ? 'checked' : '' ?> required> Male</label>
            <label><input type="radio" name="gender" value="female" <?= $user['gender'] == 'female' ? 'checked' : '' ?> required> Female</label> <br/>
 
            <label>Num of limbs:</label>
            <input type="number" name="limbs" id="limbs" value="<?= $user['limbs'] ?>" min="1" max="4" required> <br/>
 
            <label for="bio">Biography:</label>
            <textarea name="bio" id="bio" required><?= $user['bio'] ?></textarea> <br/>

 
            <input type="submit" value="Save changes">
        </form>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>