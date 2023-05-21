<?php
require "../database/dbBroker.php";
require "../model/knjiga.php";


if (
    isset($_POST['naziv']) && isset($_POST['datumIzdavanja'])
    && isset($_POST['autor'])
) {
    $status = Knjiga::add($_POST['naziv'], $_POST['datumIzdavanja'], $_POST['autor'], $connection);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Faild';
    }
}
