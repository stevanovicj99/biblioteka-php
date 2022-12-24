<?php
require "dbBroker.php";
require "model/bibliotekar.php";

session_start();
if (!empty($_SESSION['id'])) {
    header('Location: home.php');
    exit();
}

$error = false;

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $rs = Bibliotekar::getUserByUsername($username, $connection);

    if ($rs->num_rows == 1) {

        $bibliotekar = $rs->fetch_assoc();
        if (password_verify($password, $bibliotekar['password'])) {
            $_SESSION['id'] = $bibliotekar['id'];
            header('Location: home.php');
            exit();
        }
    }
    $error = true;
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteka</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class = "index">
        <div class="logo"></div>
        <div class="login-block">
            <form method="POST" action="#" class="login">
                <h1>Login</h1>
                <input type="text" value="" placeholder="Username" id="username" name="username" />
                <input type="password" value="" placeholder="Password" id="password" name="password" />
                <button>Submit</button>
                <?php
                if ($error) {
                ?>
                    <div class="invalid-feadback">
                        Nevalidan username ili password!
                    </div>
                <?php
                }
                ?>
            </form>
        </div>
    </div>
</body>

</html>