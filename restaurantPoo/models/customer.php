<?php
//models

class Customer {
    private $bdd;
    private $dataBase;
    
    public function __construct() {
        $this -> dataBase = new Database();
        $this -> bdd = $this -> dataBase -> getBdd();
    }
    
    public function addCustomer($name, $surname, $email, $address, $postcode, $city, $phone, $password, $birthday) {
    
        $add = $this -> bdd -> prepare('INSERT INTO user (nom, prenom, email, adresse, code_postale, ville, tel, password, naissance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');//ici e a codepostale
        
        $test = $add -> execute(array($name, $surname, $email, $address, $postcode, $city, $phone, $password, $birthday));
        
        return $test;
    }
    
    public function getUserByMail($mail) {
        
        $check = $this -> bdd -> prepare('SELECT * FROM user WHERE email = ?');//name
        
        $check -> execute(array($mail));
        
        $user = $check -> fetch();
        
        return $user;
    }
    
    public function getUserByid($id) {
        $query = $this -> bdd -> prepare('SELECT * FROM user WHERE id = ?');
        
        $query -> execute(array($id));
        
        $user = $query -> fetch();
        
        return $user;
    }
}