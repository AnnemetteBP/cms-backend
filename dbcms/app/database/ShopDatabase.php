<?php
require_once('models/Vat.php');
require_once('models/User.php');
require_once('models/Admin.php');
require_once('models/Product.php');
require_once('models/HtmlElementClass.php');
require_once('models/NewsPost.php');
require_once('models/Order.php');
require_once('models/Adress.php');

class ShopDatabase
{
    protected $connection;

    function __construct()
    {
        $this->connection = mysqli_connect('localhost', 'root', '', 'dbcms');
        if(mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    }
    
    function readCategory($name)
    {
        $statement = $this->connection->prepare("SELECT * FROM Product JOIN Category ON Product.ProductID = Category.ProductID WHERE CategoryName = ?");
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    function readBrands()
    {
        $statement = $this->connection->prepare("SELECT * FROM Brand");
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Product
    function readProduct(int $id)
    {
        $statement = $this->connection->prepare("SELECT * FROM Product WHERE ProductID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function readProducts()
    {
        $statement = $this->connection->prepare("SELECT * FROM Product");
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function addProductToCart(int $productID, int $userID, $orderID)
    {
        if(isset($orderID) === false)
        {
            $order = new Order(date('Y-m-d'), date("Y-m-d", strtotime("0000-00-00")), 100, $userID);
            $orderID = $this->createOrder($order)['OrderID'];
        }
        $statement = $this->connection->prepare("INSERT INTO ShoppingCart (OrderID, ProductID) VALUES(?, ?)");
        $statement->bind_param("ii", $orderID, $productID);
        $statement->execute();
        $statement->close();
        return $orderID;
    }

    function removeProductfromCart(int $productID, $orderID)
    {
        $statement = $this->connection->prepare("DELETE FROM ShoppingCart WHERE ProductID = ? AND OrderID = ?");
        $statement->bind_param("ii", $productID, $orderID);
        $statement->execute();
        $statement->close();
        return $orderID;
    }

    function readCart($orderID)
    {
        $statement = $this->connection->prepare("SELECT * FROM ShoppingCart WHERE OrderID = ?");
        $statement->bind_param("i", $orderID);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function readTopSeller()
    {
        $limit = 1;
        $statement = $this->connection->prepare("SELECT * FROM Product ORDER BY Sold ASC LIMIT ?");
        $statement->bind_param("i", $limit);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function readHighestRated()
    {
        $limit = 1;
        $statement = $this->connection->prepare("SELECT u.*
        FROM product as u INNER JOIN
             rating as p
             ON u.ProductID = p.ProductID
        GROUP BY u.ProductName
        ORDER BY count(*) desc
        LIMIT ?");
        $statement->bind_param("i", $limit);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function readNewInStock()
    {
        $limit = 1;
        $statement = $this->connection->prepare("SELECT * FROM Product ORDER BY Stock DESC LIMIT ?");
        $statement->bind_param("i", $limit);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Order
    function createOrder(Order $order)
    {
        $statement = $this->connection->prepare("INSERT INTO Orders (OrderDate, ShipDate, TotalCost, UserID) VALUES(?, ?, ?, ?)");
        $statement->bind_param("ssii", $order->OrderDate, $order->ShipDate, $order->TotalCost, $order->UserID);
        $statement->execute();
        $statement->close();
        $statement = $this->connection->prepare("SELECT * FROM Orders ORDER BY OrderID DESC LIMIT 1");
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    function updateOrder($id, $cost)
    {
        $statement = $this->connection->prepare("UPDATE Orders SET TotalCost = ? WHERE OrderID = ?");
        $statement->bind_param("ii", $cost, $id);
        $statement->execute();
        $statement->close();
    }
    
    function readOrder(int $id)
    {
        $statement = $this->connection->prepare("SELECT * FROM Orders WHERE OrderID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    function payOrder(int $orderID)
    {
        $date = date("Y-m-d", strtotime("+4 day"));
        $statement = $this->connection->prepare("UPDATE Orders SET ShipDate = ? WHERE OrderID = ?");
        $statement->bind_param("si", $date, $orderID);
        $statement->execute();
        $statement->close();
    }
    
    function removeOrder(int $id)
    {
        $statement = $this->connection->prepare("DELETE FROM ShoppingCart WHERE OrderID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
        $statement = $this->connection->prepare("DELETE FROM Orders WHERE OrderID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
    }

    //Pages
    function readPage(int $id)
    {
        $statement = $this->connection->prepare("SELECT * FROM PageContent WHERE SectionID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    //Adress
    function createAdress(Adress $adress)
    {
        $statement = $this->connection->prepare("INSERT INTO Adress (Phone, StreetName, StreetNumber, FloorNumber, PostalCode, Country) VALUES(?, ?, ?, ?, ?, ?)");
        $statement->bind_param("ssssss", $adress->Phone, $adress->StreetName, $adress->StreetNumber, $adress->FloorNumber, $adress->PostalCode, $adress->Country);
        $statement->execute();
        $statement->close();
        $statement = $this->connection->prepare("SELECT * FROM Adress ORDER BY AdressID DESC LIMIT 1");
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    function updateAdress(Adress $adress)
    {
        $statement = $this->connection->prepare("UPDATE Adress SET Phone = ?, StreetName = ?, StreetNumber = ?, FloorNumber = ?, PostalCode = ?, Country = ? WHERE AdressID = ?");
        $statement->bind_param("ssssssi", $adress->Phone, $adress->StreetName, $adress->StreetNumber, $adress->FloorNumber, $adress->PostalCode, $adress->Country, $adress->AdressID);
        $statement->execute();
        $statement->close();
    }

    //User
    function createUser(User $user)
    {
        $pass = md5($user->UserPassword);
        $statement = $this->connection->prepare("INSERT INTO User (Email, UserPassword, FirstName, LastName, AdressID) VALUES(?, ?, ?, ?, ?)");
        $statement->bind_param("ssssi", $user->Email, $pass, $user->FirstName, $user->LastName, $user->AdressID);
        $statement->execute();
        $statement->close();
    }

    function readUser(int $id)
    {
        $statement = $this->connection->prepare("SELECT * FROM User WHERE UserID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    function updateUser(User $user)
    {
        $statement = $this->connection->prepare("UPDATE User SET Email = ?, UserPassword = ?, FirstName = ?, LastName = ?, AdressID = ? WHERE UserID = ?");
        $statement->bind_param("ssssii", $user->Email, $user->UserPassword, $user->FirstName, $user->LastName, $user->AdressID, $user->UserID);
        $statement->execute();
        $statement->close();
    }

    function deleteUser(int $id)
    {
        $statement = $this->connection->prepare("DELETE FROM User WHERE UserID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
    }

    //Search
    function search(string $search)
    {
        $param = "%$search%";
        $statement = $this->connection->prepare("SELECT * FROM Product WHERE ProductName LIKE ?");
        $statement->bind_param("s", $param);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Login
    function findUser($email, $pass)
    {
        $md5 = md5($pass);
        $statement = $this->connection->prepare("SELECT * FROM User WHERE Email = ? AND UserPassword = ?");
        $statement->bind_param("ss", $email, $md5);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    //Site
    function readSiteTitle()
    {
        $name = "SiteTitle";
        $statement = $this->connection->prepare("SELECT * FROM pagesettings WHERE PageSettingName = ?");
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }
    
    function readPageLogo()
    {
        $name = "PageLogo";
        $statement = $this->connection->prepare("SELECT * FROM pagesettings WHERE PageSettingName = ?");
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }
    
    function readContact()
    {
        $name = "Contact";
        $statement = $this->connection->prepare("SELECT * FROM pagecontent WHERE SectionName = ?");
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }
    
    function readAbout()
    {
        $name = "About";
        $statement = $this->connection->prepare("SELECT * FROM pagecontent WHERE SectionName = ?");
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }
    
    function readOffer($offerName)
    {
        $statement = $this->connection->prepare("SELECT * FROM offer WHERE OfferName = ?");
        $statement->bind_param("s", $offerName);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    function __destruct()
    {
        $this->connection->close();
    }
}
?>