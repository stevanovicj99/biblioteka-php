<?php
require "../database/dbBroker.php";
require "../model/knjiga.php";

if (
    isset($_POST['id']) && isset($_POST['naziv']) && isset($_POST['datumIzdavanja']) && isset($_POST['autor'])
) {

    $status = Knjiga::update($_POST['id'], $_POST['naziv'], $_POST['datumIzdavanja'], $_POST['autor'], $connection);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Faild';
    }
}
