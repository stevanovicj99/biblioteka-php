<?php

class Knjiga
{
    public $id;
    public $naziv;
    public $datumIzadvanja;
    public $autorImePrezime;

    public function __construct($id = null, $naziv = null, $datumIzadvanja = null, $autorImePrezime = null)
    {
        $this->id = $id;
        $this->ime = $naziv;
        $this->prezime = $datumIzadvanja;
        $this->autorImePrezime = $autorImePrezime;
    }

    public static function getAll(mysqli $connection)
    {
        return $connection->query("SELECT k.id,k.naziv, k.datumIzdavanja, CONCAT(a.ime,' ', a.prezime) AS autorImePrezime FROM knjiga k INNER JOIN autor a ON k.autor_id=a.id");
    }
}
