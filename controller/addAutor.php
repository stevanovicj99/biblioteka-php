<?php
require "../database/dbBroker.php";
require "../model/autor.php";


if (
    isset($_POST['ime']) && isset($_POST['prezime'])
    && isset($_POST['datumRodjenja'])
) {
    $autor = new Autor(null, $_POST['ime'], $_POST['prezime'], $_POST['datumRodjenja']);
    $status = Autor::add($autor, $connection);

    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Faild';
    }
}
