<?php 
// controllers
require('models/meal.php');

class MealController {
    private $meal;
    private $admin;
    
    public function __construct() {
        $this -> meal = new Meal();
        $this -> admin = new AdminController();
    }
    
    public function listMeal() {
        $meals = $this -> meal -> getMeal();
        
        $template = 'home.phtml';
        require('www/layout.phtml');
    }
    
    public function listOrder() {
        $meals = $this -> meal -> getMeal();
        
        $template = 'order.phtml';
        require('www/layout.phtml');
    }
    
    function addMeal() {
        if($this -> admin -> isAdmin()) {
            if(isset($_POST['submit'])) {
                
                $img = $_FILES['img']['name'];
                $uploaddir = 'www/img/';
                $uploadfile = $uploaddir . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile);
                
                $try = $this -> meal -> insertMeal($_POST['name'], $_POST['desc'], $_POST['price'], $img);
                
                if($try) {
                    $alert = 'insertion succesfull';
                    $template = 'admin/add.phtml';
                } else {
                    $alert = 'something went terribly wrong';
                    $template = 'admin/add.phtml';
                }
            }  else {
                $template = 'admin/add.phtml';
            }
            require('www/layout.phtml');
        } else {
            header('Location: index.php');
        }
    }
    
    public function update() {
        if($this -> admin -> isadmin()) {
            
            if(isset($_POST['submit'])) {
                
                if(!empty($_FILES['img']['name'])) {
                    $img = $_FILES['img']['name'];
                    $uploaddir = 'www/img/';
                    $uploadfile = $uploaddir . basename($img);
                    move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile);
                    
                    $update = $this -> meal -> updateMeal($_POST['name'], $_POST['desc'], $_POST['price'], $img, $_GET['id']);
                } else {
                    $update = $this -> meal -> updateMealNoPhoto($_POST['name'], $_POST['desc'], $_POST['price'], $_GET['id']);
                }
                
                if($update) {
                    $alert = 'Update succesfull';
                    $template = 'admin/home.phtml';
                } else {
                    $meal = $this -> meal -> getMealById($_GET['id']);
                    $alert = 'Update failed';
                    $template = 'admin/update.phtml';
                }
                
            } else {
                if(isset($_GET['id'])) {
                    $meal = $this -> meal -> getMealById($_GET['id']);
                } else {
                    $meals = $this -> meal -> getMeal();
                }
            
                $template = 'admin/update.phtml';
            }
            
            require('www/layout.phtml');
            
        } else {
            header('Location: index.php');
        }
    }
    
    
    function remove() {
        $test = $this -> meal -> removeMeal($_GET['id']);
        if($test) {
            $alert = 'Removal succesfull';
            $template = 'admin/home.phtml';
        } else {
            $meal = $this -> meal -> getMealById($_GET['id']);
            $alert = 'Removal failed';
            $template = 'admin/update.phtml';
        }
        require('www/layout.phtml');
    }

}
