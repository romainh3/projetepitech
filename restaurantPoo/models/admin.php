<?php
//model
class Admin {
    private $bdd;
    private $database;
    
    public function __construct() {
        $this -> database = new Database();
        $this -> bdd = $this -> database -> getBdd(); 
    }
    
    public function getAdminByEmail($email) {
    
        $bdd = $this -> bdd;
        
        $query = $bdd -> prepare('SELECT * FROM admin WHERE email = ?');
    
        $query -> execute(array($email));
        
        $info = $query -> fetch();
        
        return $info;
        
    }
}