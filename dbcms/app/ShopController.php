<?php
require_once('database/ShopDatabase.php');

class ShopController
{
    protected $database;
    protected $action;
    protected $method;
    protected $userID;
    protected $orderID;
    
    function __construct(string $action, string $method, $userID, $orderID)
    {
        $this->database = new ShopDatabase();
        $this->action = $action;
        $this->method = $method;
        $this->userID = $userID;
        $this->orderID = $orderID;
    }

    function route()
    {
        if($this->action === 'ViewProduct')
        {
            if($this->method === 'get')
            {
                return $this->database->readProduct($_GET['parameter']);
            }
        }
        else if($this->action === 'ViewPage')
        {
            if($this->method === 'get')
            {
                return $this->database->readPage($_GET['parameter']);
            }
        }
        else if($this->action === 'AddProductToCart')
        {
            if($this->method === 'post')
            {
                if(isset($_SESSION['ORDER']) === false)
                {
                    $now = date("Y-m-d H:i:s");
                    $order = new Order($now, $now, 0, $_SESSION['AUTH_USER']);
                    $_SESSION['ORDER'] = $this->database->createOrder($order)['OrderID'];
                }
                $totalCost = 0;
                $shopCart = $this->database->readCart($_SESSION['ORDER']);
                $products = [];
                foreach($shopCart as $index => $p){
                    $totalCost = $totalCost + $this->database->readProduct($p['ProductID'])[0]['Prize'];
                }
                $productPrice = $this->database->readProduct(intval($_POST['productID']))[0]['Prize'];
                for($amount = 0; $amount < intval($_POST['amount']); $amount++){
                    $_SESSION['ORDER'] = $this->database->addProductToCart($_POST['productID'], $this->userID, $_SESSION['ORDER']);
                    $totalCost = $totalCost + $productPrice;
                }
                $this->database->updateOrder($_SESSION['ORDER'], $totalCost);
                return ['response' => $_SESSION['ORDER'], 'message' => 'order'];
            }
        }
        else if($this->action === 'ViewOrder')
        {
            if($this->method === 'get')
            {   
                if(isset($this->userID))
                {
                    $order = $this->database->readOrder($_SESSION['ORDER']);
                    $shopCart = $this->database->readCart($_SESSION['ORDER']);
                    $products = [];
                    foreach($shopCart as $index => $product){
                        $products[] = $this->database->readProduct($product['ProductID']);
                    }
                    $result = [
                        'order' => $order,
                        'products' => $products
                    ];
                    return ['response' => $result, 'message' => 'shopCartUpdate'];
                }
            }
        }
        else if($this->action === 'PayOrder')
        {
            if($this->method === 'post')
            {
                if(isset($this->userID))
                {
                    $_SESSION['ORDER'] = NULL;
                    return $this->database->payOrder($_POST['orderID']);
                }
            }
        }else if($this->action === 'RemoveFromCart'){
            if($this->method === 'post'){
                $shopCart = $this->database->readCart($_SESSION['ORDER']);
                $products = [];
                $order = $this->database->readOrder($_SESSION['ORDER']);
                foreach($shopCart as $index => $product){
                    $products[] = $this->database->readProduct($product['ProductID']);
                    $this->database->removeProductfromCart($product['ProductID'], $_SESSION['ORDER']);
                }
                $this->database->updateOrder($_SESSION['ORDER'], 0);
                $order = $this->database->readOrder($_SESSION['ORDER']);
                $result = [
                    'order' => $order,
                    'products' => $products
                ];
                return ['response' => $result, 'message' => 'removeFromCart'];
            }
        }
        else if($this->action === 'SearchableContent')
        {
            if($this->method === 'post')
            {
                return ['response' => $this->database->search($_POST['parameter']), 'search'];
            }
        }
        else if($this->action === 'CreateUser')
        {
            if($this->method === 'post')
            {
                $adress = new Adress($_POST['phone'], $_POST['streetName'], $_POST['streetNumber'], $_POST['floorNumber'], $_POST['postalCode'], $_POST['country']);
                $adress->AdressID = $this->database->createAdress($adress)['AdressID'];
                $user = new User($_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $adress->AdressID);
                return ['response' => $this->database->createUser($user), 'message' => 'signup'];
            }
        }
        else if($this->action === 'StoreUser')
        {
            if($this->method === 'post')
            {
                $adress = new Adress($_POST['phone'], $_POST['streetName'], $_POST['streetNumber'], $_POST['floorNumber'], $_POST['postalCode'], $_POST['country']);
                $adress->AdressID = $_POST['adressID'];
                $this->database->updateAdress($adress);
                $user = new User($_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $adress->AdressID);
                $user->UserID = $_POST['userID'];
                return $this->database->updateUser($user);
            }
        }
        else if($this->action === 'ViewUser')
        {
            if($this->method === 'get')
            {
                if(isset($this->userID))
                {
                    return $this->database->readUser($_GET['parameter']);
                }
                else
                {
                    return ['status' => 'error', 'message' => 'not logged in'];
                }
            }
        }
        else if($this->action === 'ViewList')
        {
            if($this->method === 'get')
            {
                return ['response' => $this->database->readCategory($_GET['parameter']), 'message' => 'list'];
            }
        }
        else if($this->action === 'Login')
        {
            if($this->method === 'post')
            {
                $user = $this->database->findUser($_POST['email'], $_POST['password']);
                $userID = NULL;
                if(isset($user))
                {
                    $userID = $user['UserID'];
                }
                $_SESSION['AUTH_USER'] = $userID;
                return ['response' => $_SESSION['AUTH_USER'], 'message' => 'login'];
            }
        }
        else if($this->action === 'Logout')
        {
            if($this->method === 'post')
            {
                $_SESSION['AUTH_USER'] = NULL;
                if(isset($_SESSION['ORDER'])){
                    $this->database->removeOrder($_SESSION['ORDER']);
                    unset($_SESSION['ORDER']);
                }
                session_destroy();
                return ['response' => NULL, 'message' => 'logout'];
            }
        }
        else if($this->action === 'ReadSiteTitle')
        {
            if($this->method === 'get')
            {
                return ['response' => $this->database->readSiteTitle(), 'message' => 'siteTitle'];
            }
        }
        else if($this->action === 'ReadSiteLogo')
        {
            if($this->method === 'get')
            {
                return ['response' => $this->database->readPageLogo(), 'message' => 'siteLogo'];
            }
        }
        else if($this->action === 'ReadContact')
        {
            if($this->method === 'get')
            {
                return ['response' => $this->database->readContact(), 'message' => 'contact'];
            }
        }
        else if($this->action === 'ReadAbout')
        {
            if($this->method === 'get')
            {
                return ['response' => $this->database->readAbout(), 'message' => 'about'];
            }
        }
        else if($this->action === 'ReadOffer')
        {
            if($this->method === 'get')
            {
                $offer = $this->database->readOffer($_GET['parameter']);
                $response = [
                    'Offer' => $offer,
                    'Product' => $this->database->readProduct($offer['ProductID'])
                ];
                return ['response' => $response, 'message' => 'offer'];
            }
        }
        else if($this->action === 'ReadFeaturedProduct')
        {
            if($this->method === 'get')
            {
                if($_GET['parameter'] === 'topseller')
                {
                    return ['response' => $this->database->readTopSeller()[0], 'message' => 'topseller'];
                }
                else if($_GET['parameter'] === 'highestrated')
                {
                    return ['response' => $this->database->readHighestRated()[0], 'message' => 'highestrated'];
                }
                else if($_GET['parameter'] === 'newinstock')
                {
                    return ['response' => $this->database->readNewInStock()[0], 'message' => 'newinstock'];
                }
            }
        }
        else if($this->action === 'ReadFavIcon')
        {
            if($this->method === 'get')
            {
                return $this->database->updateFavIcon();
            }
        }
        return false;
    }
}