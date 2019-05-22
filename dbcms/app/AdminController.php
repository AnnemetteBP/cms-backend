<?php
require_once('ShopController.php');
require_once('database/AdminDatabase.php');
require_once('models/Vat.php');
require_once('models/User.php');
require_once('models/Admin.php');
require_once('models/Product.php');
require_once('models/HtmlElementClass.php');
require_once('models/NewsPost.php');
require_once('models/Order.php');
require_once('models/Adress.php');

class AdminController extends ShopController
{
    function __construct(string $action, string $method, $userID, $orderID)
    {
        parent::__construct($action, $method, $userID, $orderID);
        $this->database = new AdminDatabase();
    }

    function route()
    {
        
        if(isset($this->userID) === false)
        {
            return ['status' => 'error', 'message' => 'not logged in'];
        }
        else if($this->database->readAdminUser($this->userID) !== NULL)
        {
            return ['status' => 'error', 'message' => 'not an admin'];
        }

        if($this->action === 'CreateProduct')
        {
            if($this->method === 'post')
            {
                $product = new Product($_POST['productName'], $_POST['productDescription'], $_POST['size'], $_POST['color'], $_POST['prize'], $_POST['brandID'], $_POST['stock'], $_POST['sold'], $_POST['productImage']);
                return $this->database->createProduct($product);
            }
        }
        else if($this->action === 'StoreProduct')
        {
            if($this->method === 'post')
            {
                $product = new Product($_POST['productName'], $_POST['productDescription'], $_POST['size'], $_POST['color'], $_POST['prize'], $_POST['brandID'], $_POST['stock'], $_POST['sold'], $_POST['productImage']);
                $product->ProductID = $_POST['productID'];
                return $this->database->updateProduct($product);
            }
        }
        else if($this->action === 'DeleteProduct')
        {
            if($this->method === 'post')
            {
                return $this->database->deleteProduct($_POST['productID']);
            }
        }
        else if($this->action === 'CreateNewsPost')
        {
            if($this->method === 'post')
            {
                $newsPost = new NewsPost($_POST['title'], $_POST['content']);
                return $this->database->createNewsPost($newsPost);
            }
        }
        else if($this->action === 'DeleteNewsPost')
        {
            if($this->method === 'post')
            {
                return $this->database->deleteNewsPost($_POST['newsPostID']);
            }
        }
        else if($this->action === 'UpdatePage')
        {
            if($this->method === 'post')
            {
                if($_POST['pageName'] === 'about')
                {
                    return $this->database->updateAbout($_POST['content']);
                }
                else if($_POST['pageName'] === 'contact')
                {
                    return $this->database->updateContact($_POST['content']);
                }
                else if($_POST['pageName'] === 'terms')
                {
                    return $this->database->updateTerms($_POST['content']);
                }
                else if($_POST['pageName'] === 'privacy')
                {
                    return $this->database->updatePrivacy($_POST['content']);
                }
            }
        }
        else if($this->action === 'UpdateSiteTitle')
        {
            if($this->method === 'post')
            {
                return $this->database->updateSiteTitle($_POST['siteTitle']);
            }
        }
        else if($this->action === 'UpdatePageLogo')
        {
            if($this->method === 'post')
            {
                return $this->database->updatePageLogo($_POST['pageLogo']);
            }
        }
        else if($this->action === 'UpdateFavIcon')
        {
            if($this->method === 'post')
            {
                return $this->database->updateFavIcon($_POST['favIcon']);
            }
        }
        else if($this->action === 'CreateAdmin')
        {
            if($this->method === 'post')
            {
                $admin = new Admin($_POST['title'], $_POST['departmentID'], $_POST['userID']);
                return $this->database->createAdmin($admin);
            }
        }
        else if($this->action === 'UpdateAdmin')
        {
            if($this->method === 'post')
            {
                $admin = new Admin($_POST['title'], $_POST['departmentID'], $_POST['userID']);
                $admin->AdminUserID = $_POST['adminUserID'];
                return $this->database->updateAdmin($admin);
            }
        }
        else if($this->action === 'DeleteUserAccount')
        {
            if($this->method === 'post')
            {
                $this->database->deleteAdmin($_POST['userID']);
                return $this->database->deleteUser($_POST['userID']);
            }
        }
        else
        {
            return parent::route();
        }
    }
}
