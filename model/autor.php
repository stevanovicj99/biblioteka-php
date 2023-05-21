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

    public static function getAll(mysqli $connection)
    {
        return $connection->query("SELECT * FROM autor");
    }

    public static function getAllByName(mysqli $connection)
    {
        return $connection->query("SELECT id, CONCAT(ime,' ', prezime) AS autorImePrezime FROM autor");
    }

    public static function add($Autor, mysqli $connection)
    {
        return $connection->query("INSERT INTO autor(ime, prezime, datumRodjenja) values ('$Autor->ime','$Autor->prezime','$Autor->datumRodjenja')");
    }
    public static function update($id, $ime, $prezime, $datumRodjenja, mysqli $connection)
    {
        return $connection->query("UPDATE autor SET ime = '$ime', prezime = '$prezime', datumRodjenja = '$datumRodjenja' WHERE id = $id");
    }

    public function delete(mysqli $connection)
    {
        return $connection->query("DELETE FROM autor WHERE id = '$this->id'");
    }
}
