<?php
require "dbBroker.php";
require "model/knjiga.php";

session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}

$result = Knjiga::getAll($connection);
if (!$result) {
    echo "Greska!<br>";
    exit();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stylehome.css">

</head>

<body>
    <div class="home">
        <nav class="navMenu2">
            <a href="autori.php">Autori</a>
            <a href="knjige.php">Knjige</a>
            <div class="dot"></div>
        </nav>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Datum izdavanja</th>
                <th>Autor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($red = $result->fetch_array()) {
            ?>
                <tr>
                    <td><?php echo $red["id"] ?></td>
                    <td><?php echo $red["naziv"] ?></td>
                    <td><?php echo $red["datumIzdavanja"] ?></td>
                    <td><?php echo $red["autorImePrezime"] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>

    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>