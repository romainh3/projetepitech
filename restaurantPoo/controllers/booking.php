<?php
//controllers

require('models/booking.php');


class BookingController {
    private $booking;
    private $connect;
    private $admin;
    
    public function __construct() {
        $this -> booking = new Booking();
        $this -> connect = new CustomerControler();
        $this -> admin = new AdminController();
    }
    
    public function booking() {
        if(isset($_POST['book'])) {
            $dateTime = date(''.$_POST["date"].' '.$_POST["hour"].':'.$_POST["min"].':0');
            $result = $this -> booking -> insertBooking($_SESSION["user"]["id"], $dateTime, $_POST['guest']);
            
            if($result) {
                $alert = 'votre réservation a été prise en compte';
                header('Location: index.php');
            } else {
                $alert = "La réservation n'a pas pu étre enregistrée";
                $template = 'booking/booking.phtml';
                require('www/layout.phtml');
            }
        }
        if($this -> connect -> isConnected()) {
            $template = 'booking/booking.phtml';
        } else {
            $template = 'user/connect.phtml';
        }
        require('www/layout.phtml');
    }


    public function dispResa() {
        if($this -> admin -> isAdmin()) {
            $resas = $this -> booking -> getResa();
            
            $template = 'admin/resa.phtml';
            
            require('www/layout.phtml');
        } else {
            header('location: index.php');
        }
        
    }
}