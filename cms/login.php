<?php
include_once "../include/config.php";
include_once "../classes/Database.php";
include_once "../classes/User.php";

$db = new Database();
$user = new User($db->getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user->setUsername($username);
    $user->setPassword($password);
    $user->login();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Login</title>
</head>
<body>

    <!-- do not change the action attr of form, the name, value and type attr of all input and button in this form-->
    <form method="post">
        <label>username:</label>
        <input type="text" name="username" placeholder="username" required><br>
        <label>password:</label>
        <input type="password" name="password" placeholder="password" required><br>
        <button type="submit">login</button>
    </form>

</body>
</html>
