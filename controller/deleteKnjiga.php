<?php
require "../database/dbBroker.php";
require "../model/knjiga.php";


if (isset($_POST['id'])) {
    $knjiga = new Knjiga($_POST['id']);
    $status = $knjiga->delete($connection);
    if ($status) {
        echo 'Success';
    } else {
        echo $connection->error;
        echo 'Faild';
    }
}
