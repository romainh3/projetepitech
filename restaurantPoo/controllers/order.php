<?php
//controller

require('models/order.php');

class OrderController {
    private $order;
    private $customer;
    private $meal;
    private $admin;
    
    public function __construct() {
        $this -> order = new Order();
        $this -> customer = new Customer();
        $this -> meal = new Meal();
        $this -> admin = new AdminController();
    }
    
    
    
    public function order() {
        //appel a la fonction getmeals()
        //appel au template order.phtml
        $meals = $this -> meal -> getMeal();
        $template = 'order/order.phtml';
        require('www/layout.phtml');
    }

    public function cmdAjax() {
        //soit elle récupére un repas selon son id
        //soit elle fait l'insertion de la commande
        if(isset($_GET['id'])) {
            $meal = $this -> meal -> getMealById($_GET['id']);
            echo json_encode($meal);
            
        } else if(isset($_GET['commande'])) {
            
            $cmd = json_decode($_GET['commande']);
            $total = $_GET['total'];
            
            $idCmd = $this -> order -> addOrder($_SESSION['user']['id'], date('Y-m-d'), $total);
            
            $this -> order -> addDetailsOrder($idCmd, $cmd);
            
            $alert = 'Votre commande a bien était enregistrée';
            header('Location: index.php');
        }
    }

    public function dispOrder() {
        if($this -> admin -> isAdmin()) {
            $orders = $this -> order -> getOrder();
        
            $template = 'admin/order.phtml';
            require('www/layout.phtml');
            
        } else {
            header('location: index.php');
        }
    }


    public function dispDetails() {
        if($this -> admin -> isAdmin()) {
            $idCmd = $_GET['id'];
            $details = $this -> order -> getDetailsOrder($idCmd);
            $idUser = $this -> order -> getUserFromCmd($idCmd);
            $userInfo = $this -> customer -> getUserById($idUser['id_user']);
           
            $template = 'admin/details.phtml';
            require('www/layout.phtml');
        } else {
            header('Location: index.php');
        }
    }
}