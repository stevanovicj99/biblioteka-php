<?php
class Bibliotekar{
    public $id;
    public $username;
    public $password;

    public function __construct($id=null,$username=null,$password=null)
    {
        $this->id=$id;
        $this->username=$username;
        $this->password=$password;
    }

    public static function getUserByUsername($username, mysqli $conn){
        $q = "select * from bibliotekar where username= '".$username."' limit 1;";
        
        return $conn->query($q);
    }
}
?>