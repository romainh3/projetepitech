<?php 
//models

class Booking {
    private $bdd;
    private $dataBase;
    
    public function __construct() {
        $this -> dataBase = new Database();
        $this -> bdd = $this -> dataBase -> getBdd();
    }
    
    
    public function insertBooking($id, $dateTime, $number) {
        $query = $this -> bdd -> prepare('INSERT INTO reservation (id_user, date, nb_couverts) VALUES(?, ?, ?)');
        
        $query -> execute(array($id, $dateTime, $number));
        
        return $query;
    }


    public function getResa() {
        $query = $this -> bdd -> prepare("SELECT DATE_FORMAT(date, '%Y-%m-%d') DATEONLY, DATE_FORMAT(date, '%H:%i:%s') TIMEONLY, reservation.nb_couverts, user.nom, user.prenom FROM reservation INNER JOIN user ON reservation.id_user = user.id");
        $query -> execute();
        
        $resa = $query -> fetchAll();
        
        return $resa;
    }


    public function getBookingFromCustomer($id) {
        $query = $this -> bdd -> prepare("SELECT * FROM reservation WHERE id_user = ?");
        
        $query -> execute(array($id));
        
        $bookings = $query -> fetchAll();
        
        return $bookings;
    }
    
}