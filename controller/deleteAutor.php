<?php
require "../database/dbBroker.php";
require "../model/autor.php";


if (isset($_POST['id'])) {
    $autor = new Autor($_POST['id']);
    $status = $autor->delete($connection);
    if ($status) {
        echo 'Success';
    } else {
        echo $connection->error;
        echo 'Faild';
    }
}
