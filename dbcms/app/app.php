<?php
session_start();
if(strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false)
{
    $ORDER = $_SESSION['ORDER'] ?? NULL;                    //Setting the order id if it is created
    $AUTH_USER = $_SESSION['AUTH_USER'] ?? NULL;    //Setting the user id if a user is logged in.
    $CONTROLLER = 'Shop';
    $ACTION = 'index';
    $METHOD = 'get';
    if(empty($_POST) === false)                     //Check if it is a post request
    {
        $METHOD = 'post';
        if(isset($_POST['action']))
        {
            $ACTION = $_POST['action'];
        }
        if(isset($_POST['controller']))
        {
            $CONTROLLER = $_POST['controller'];
        }
    }
    else                                            //If it is not post it is a get request
    {
        if(isset($_GET['action']))
        {
            $ACTION = $_GET['action'];
        }
        if(isset($_GET['controller']))
        {
            $CONTROLLER = $_GET['controller'];
        }
    }

    $result = NULL;

    if($CONTROLLER === 'Admin')                     //Check which controller are requested
    {
        require_once("AdminController.php");
        $adminController = new AdminController($ACTION, $METHOD, $AUTH_USER, $ORDER);
        $result = $adminController->route();
    }
    else if($CONTROLLER === 'Shop')                 //Requests from the shop
    {
        require_once("ShopController.php");
        $shopController = new ShopController($ACTION, $METHOD, $AUTH_USER, $ORDER);
        $result = $shopController->route();
    }
    //Return the json from the API
    echo json_encode($result);
}
?>