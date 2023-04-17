<?php
//models

class Order {
    private $bdd;
    private $database;
    
    public function __construct() {
        $this -> database = new Database();
        $this -> bdd = $this -> database -> getBdd();
    }
    
    
    public function addOrder($idUser, $date, $total) {
        $bdd = $this -> bdd;
        $insert = $bdd-> prepare('INSERT INTO commandes (id_user, date, prix_total) VALUES (?, ?, ?)');
        
        $test = $insert -> execute(array($idUser, $date, $total));
        
        return $bdd -> lastInsertId();
    }

    public function addDetailsOrder($idCmd, $cmd) {
        $insert = $this -> bdd -> prepare('INSERT INTO lignes_cmd (id_cmd, id_meal, quantite, prix_unit) VALUES (?, ?, ?, ?)');
        
        foreach($cmd as $ligne) {
            $insert -> execute(array($idCmd, $ligne[0] -> id, $ligne[1], $ligne[0] -> prix));
        }
    }

    public function getOrder() {
        $query = $this -> bdd -> prepare("SELECT commandes.id, DATE_FORMAT(commandes.date, '%Y-%m-%d') DATEONLY, commandes.prix_total, user.nom, user.prenom FROM commandes INNER JOIN user ON commandes.id_user = user.id");
        
        $query -> execute();
        
        $orders = $query -> fetchAll();
        
        return $orders;
    }

    public function getDetailsOrder($id) {
        $query = $this -> bdd -> prepare("SELECT * FROM lignes_cmd INNER JOIN meal ON id_meal = id WHERE id_cmd = ?");
        $query -> execute(array($id));
        
        $details = $query -> fetchAll();
       
        return $details;
    } 

    public function getUserFromCmd($id) {
        $query = $this -> bdd -> prepare('SELECT id_user FROM commandes WHERE id = ?');
        
        $query -> execute(array($id));
        
        $idUser = $query -> fetch();
        
        return $idUser;
    }


    public function getOrderFromCustomer($id) {
        $query = $this -> bdd -> prepare("SELECT * FROM commandes WHERE id_user = ?");
        
        $query -> execute(array($id));
        
        $orders = $query -> fetchALL();
        
        return $orders;
    }
}