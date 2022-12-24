<?php

class Autor
{
    public $id;
    public $ime;
    public $prezime;
    public $datumRodjenja;

    public function __construct($id = null, $ime = null, $prezime = null, $datumRodjenja = null)
    {
        $this->id = $id;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->datumRodjenja = $datumRodjenja;
    }

    public static function getAll(mysqli $connection){
        return $connection->query("SELECT * FROM autor");
    }
}
