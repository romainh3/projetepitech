<?php
//controller

require('models/admin.php');

class AdminController {
    private $admin;
    
    public function __construct() {
        $this -> admin = new Admin();
    }
    
    public function homeAdmin() {
   
        if(isset($_POST['mail']) and isset($_POST['password'])) {
           
           $infos = $this -> admin -> getAdminByEmail($_POST['mail']);
           
            if($infos) {
                if(password_verify($_POST['password'], $infos['password'])) {
                    
                    $_SESSION['admin']['id'] = $infos['id'];
                    $_SESSION['admin']['nom']  = $infos['nom'];
                    $_SESSION['admin']['prenom']  = $infos['prenom'];
                    
                    $template = 'admin/home.phtml';
                } else {
                    $alert = 'invalid password';
                    $template = 'admin/home.phtml';
                }
            } else {
                $alert = 'something went terribly wrong';
                $template = 'admin/home.phtml';    
            }
        } else {
           $template = 'admin/home.phtml';
        }
        require('www/layout.phtml');
    }



    public function isAdmin() {
        if(isset($_SESSION['admin'])) {
            return true;
        } else {
            return false;
        }
    }
}