<?php

class Knjiga
{
    public $id;
    public $naziv;
    public $datumIzdavanja;
    public $autor;

    public function __construct($id = null, $naziv = null, $datumIzdavanja = null, $autor = null)
    {
        $this->id = $id;
        $this->naziv = $naziv;
        $this->datumIzdavanja = $datumIzdavanja;
        $this->autor = $autor;
    }

    public static function getAll(mysqli $connection)
    {
        return $connection->query("SELECT k.id,k.naziv, k.datumIzdavanja, CONCAT(a.ime,' ', a.prezime) AS autor FROM knjiga k INNER JOIN autor a ON k.autor_id=a.id");
    }

    public static function add($naziv, $datumIzdavanja, $autor, mysqli $connection)
    {
        return $connection->query("INSERT INTO knjiga(naziv, datumIzdavanja, autor_id) values ('$naziv','$datumIzdavanja','$autor')");
    }
    public static function update($id, $naziv, $datumIzdavanja, $autor, mysqli $connection)
    {
        return $connection->query("UPDATE knjiga SET naziv = '$naziv', datumIzdavanja = '$datumIzdavanja', autor_id = '$autor' WHERE id = $id");
    }

    public function delete(mysqli $connection)
    {
        return $connection->query("DELETE FROM knjiga WHERE id = '$this->id'");
    }
}
