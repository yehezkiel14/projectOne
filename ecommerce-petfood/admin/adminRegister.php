<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $sql = "INSERT INTO admins (username, password, email) VALUES (:username, :password, :email)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([':username' => $username, ':password' => $password, ':email' => $email])) {
        header("Location: login.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>
</head>
<body>
    <h2>Admin Register</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
