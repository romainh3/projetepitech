<?php
//models

class Meal {
    private $bdd;
    private $dataBase;
    
    public function __construct() {
        $this -> dataBase = new Database();
        $this -> bdd = $this -> dataBase -> getBdd();
    }
    
    public function getMeal() {
        $query = $this -> bdd -> prepare('SELECT id, name, description, prix, photo FROM meal');
        $query -> execute();
    
        $response = $query -> fetchAll();
    
        return $response;
    }
    
    public function getMealById($id) {
        $query = $this -> bdd -> prepare('SELECT id, name, description, prix, photo FROM meal WHERE id= ?');
        
        $query -> execute(array($id));
        
        $response = $query -> fetch();
        
        return $response;
    }
    
    public function insertMeal($name, $description, $prix, $photo) {
        $insert = $this -> bdd -> prepare('INSERT INTO meal (name, description, prix, photo) VALUES (?, ?, ?, ?)');
        $test = $insert -> execute(array($name, $description, $prix, $photo));
        
        return $test;
    }
    
    public function updateMeal($name, $description, $prix, $photo, $id) {
        $update = $this -> bdd -> prepare('UPDATE meal SET name = ?, description = ?, prix = ?, photo = ? WHERE id = ?');
        
        $test = $update -> execute(array($name, $description, $prix, $photo, $id));
        
        return $test;
    }
    
    public function updateMealNoPhoto($name, $description, $prix, $id) {
        $update = $this -> bdd -> prepare('UPDATE meal SET name = ?, description = ?, prix = ? WHERE id = ?');
        
        $test = $update -> execute(array($name, $description, $prix, $id));
        var_dump($update -> errorInfo());
        return $test;
    }
    
    public function removeMeal($id) {
        $remove = $this -> bdd -> prepare('DELETE FROM meal WHERE id = ?');
        
        $test = $remove -> execute(array($id));
        
        return $test;
    }
}