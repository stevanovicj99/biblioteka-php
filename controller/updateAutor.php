<?php
require "../database/dbBroker.php";
require "../model/autor.php";


if (
    isset($_POST['id']) && isset($_POST['ime']) && isset($_POST['prezime']) && isset($_POST['datumRodjenja'])
) {
    $status = Autor::update($_POST['id'], $_POST['ime'], $_POST['prezime'], $_POST['datumRodjenja'], $connection);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Faild';
    }
}
