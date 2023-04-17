<?php

class Database {
    private $bdd;
    
    public function __construct() {
        $this -> bdd = new PDO("mysql:host=localhost;dbname=pa-143_williammachi_restaurant; charset=utf8",'williammachi', '0b3ee47fYmI0NGY2YWUyOWZhMDczYmJlOTc0ZGFl839eead5');
    }
    
    public function getBdd() {
        return $this -> bdd;
    }
}

