<?php
require "database/dbBroker.php";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="index">
        <div class="logo"></div>
        <div class="login-block">
            <form method="POST" action="#" class="login">
                <h1>Login</h1>
                <input type="text" value="" placeholder="Username" id="username" name="username" require/>
                <input type="password" value="" placeholder="Password" id="password" name="password" require/>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>