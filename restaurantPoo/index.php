<?php

session_start();
    
require('config/database.php');
require('controllers/meal.php');
require('controllers/customer.php');
require('controllers/booking.php');
require('controllers/order.php');
require('controllers/admin.php');

$mealController = new MealController();
$cutomerController = new CustomerControler();
$bookingController = new BookingController();
$orderController = new OrderController();
$adminController = new AdminController();

if(isset($_GET['name'])) {
    switch($_GET['name']) {
        case "create":
            $cutomerController -> createAcount();
            break;
        case "connect":
            $cutomerController -> makeConn();
            break;
        case "disconnect":
            $cutomerController -> disconnect();
            break;
        case "booking":
            $bookingController -> booking();
            break;
        case "order":
            $orderController -> order();
            break;
        case "cmdAjax":
            $orderController -> cmdAjax();
            break;
        case "admin":
            $adminController -> homeAdmin();
            break;
        case "dispResa":
            $bookingController -> dispResa();
            break;
        case "dispOrder";
            $orderController -> dispOrder();
            break;
        case "dispDetails":
            $orderController -> dispDetails();
            break;
        case "addMeal":
            $mealController -> addMeal();
            break;
        case "update":
            $mealController -> update();
            break;
        case "removeMeal":
            $mealController -> remove();
            break;
        /*case "account":
            acountHome();
            break;
        case "myOrder":
            accountOrder();
            break;
        case "myBook":
            accountResa();
            break;*/
    }
} else {
    $mealController -> listMeal();
}