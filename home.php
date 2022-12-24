<?php

session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteka</title>
    <link rel="stylesheet" href="css/stylehome.css">

</head>

<body>
    <div class="home">
        <nav class="navMenu">
            <a href="autori.php">Autori</a>
            <a href="knjige.php">Knjige</a>
            <div class="dot"></div>
        </nav>
    </div>
</body>