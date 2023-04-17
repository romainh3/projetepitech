<?php
//controllers
require('models/customer.php');

class CustomerControler {
    private $customer;
    
    public function __construct() {
        $this -> customer = new Customer();
    }
    
    public function createAcount() {
        $template = 'user/customer.phtml'; 
        
        if(isset($_POST['name'])) {
            $email = htmlspecialchars($_POST['email']);
            $test = $this -> customer -> getUserByMail($email);
            
            if(!$test) {
                
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $date = ''.$_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'].'';
               
                $result = $this -> customer -> addCustomer($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['address'], $_POST['postcode'], $_POST['city'], $_POST['phone'], $hash, $date);
                 
                if($result) {
                    $alert = 'votre compte a bien été créé';
                    $template='user/connect.phtml';
                }
                
            } else {
                $alert = 'user already exist';
            }
        }
        require('www/layout.phtml');
    }
    
    
    
    
    public function makeConn() {
    
        if(isset($_POST['mail']) and isset($_POST['password'])) {
            
            $info = $this -> customer -> getUserByMail($_POST['mail']);
            
            if($info) {
                
                if(password_verify($_POST['password'], $info['password'])) {
                  
                    $_SESSION['user']['id'] = $info['id'];
                    $_SESSION['user']['nom'] = $info['nom'];
                    $_SESSION['user']['prenom'] = $info['prenom'];
                    
                    header ('location: index.php');
                } else {
                    $alert = 'invalid password';
                    $template='user/connect.phtml';
                }
                
            } else {
                $alert = 'Email unknown';
                $template='user/connect.phtml';
            }
            
        } else {
        
            $template='user/connect.phtml';
        }
        
        require('www/layout.phtml');
    }
    
    public function isConnected() {
        if(isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
    
    public function disconnect() {
    
        if (isset($_POST['yes'])) {
            
            $_SESSION = array();
            session_unset();
            session_destroy();
            
            header('Location: index.php');
        } else if(isset($_POST['no'])) {
            header('Location: index.php');
        } else {
            $template = 'user/disconnect.phtml';
        }
        require('www/layout.phtml');
    }
}