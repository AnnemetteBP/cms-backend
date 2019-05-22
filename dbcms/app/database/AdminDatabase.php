<?php
require_once('ShopDatabase.php');
require_once('models/Vat.php');
require_once('models/User.php');
require_once('models/Admin.php');
require_once('models/Product.php');
require_once('models/HtmlElementClass.php');
require_once('models/NewsPost.php');
require_once('models/Order.php');
require_once('models/Adress.php');

class AdminDatabase extends ShopDatabase
{
    function __construct()
    {
        parent::__construct();          //Connects to database
    }

    //NewsPost
    function createNewsPost(NewsPost $NewsPost)
    {
        $date = date("Y-m-d");
        $statement = $this->connection->prepare("INSERT INTO NewsPost (Title, Content, PostDate) VALUES(?, ?, ?)");
        $statement->bind_param("sss", $NewsPost->Title, $NewsPost->Content, $date);
        $statement->execute();
        $statement->close();
    }

    function readNewsPosts()
    {
        $statement = $this->connection->prepare("SELECT * FROM NewsPost");
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function updateNewsPost(NewsPost $NewsPost)
    {
        $date = date("Y-m-d");
        $statement = $this->connection->prepare("UPDATE NewsPost SET Title = ?, Content = ?, PostDate = ? WHERE NewsPostID = ?");
        $statement->bind_param("sssi", $NewsPost->Title, $NewsPost->Content, $date, $NewsPost->NewsPostID);
        $statement->execute();
        $statement->close();
    }

    function deleteNewsPost(int $id)
    {
        $statement = $this->connection->prepare("DELETE FROM NewsPost WHERE NewsPostID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
    }

    //HtmlElementClass
    function createHtmlElementClass(HtmlElementClass $HtmlElementClass)
    {
        $statement = $this->connection->prepare("INSERT INTO HtmlElementClass (ElementName, ClassValue) VALUES(?, ?)");
        $statement->bind_param("ss", $HtmlElementClass->ElementName, $HtmlElementClass->ClassValue);
        $statement->execute();
        $statement->close();
    }

    function updateHtmlElementClass(HtmlElementClass $HtmlElementClass)
    {
        $statement = $this->connection->prepare("UPDATE HtmlElementClass SET ElementName = ?, ClassValue = ? WHERE HtmlElementClassID = ?");
        $statement->bind_param("ssi", $HtmlElementClass->ElementName, $HtmlElementClass->ClassValue, $HtmlElementClass->HtmlElementClassID);
        $statement->execute();
        $statement->close();
    }

    function deleteHtmlElementClass(int $id)
    {
        $statement = $this->connection->prepare("DELETE FROM HtmlElementClass WHERE HtmlElementClassID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
    }

    //Product
    function createProduct(Product $product)
    {
        $statement = $this->connection->prepare("INSERT INTO Product (ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param("ssisiiiis", $product->ProductName, $product->ProductDescription, $product->Size, $product->Color, $product->Prize, $product->BrandID, $product->Stock, $product->Sold, $product->ProductImage);
        $statement->execute();
        $statement->close();
    }

    function readProduct(int $id)
    {
        $statement = $this->connection->prepare("SELECT * FROM Product WHERE ProductID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    function updateProduct(Product $product)
    {
        $statement = $this->connection->prepare("UPDATE Product SET ProductName = ?, ProductDescription = ?, Size = ?, Color = ?, Prize = ?, BrandID = ?, Stock = ?, Sold = ?, ProductImage = ? WHERE ProductID = ?");
        $statement->bind_param("ssisiiiisi", $product->ProductName, $product->ProductDescription, $product->Size, $product->Color, $product->Prize, $product->BrandID, $product->Stock, $product->Sold, $product->ProductImage, $product->ProductID);
        $statement->execute();
        $statement->close();
    }

    function deleteProduct(int $id)
    {
        $statement = $this->connection->prepare("DELETE FROM Product WHERE ProductID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
    }

    //Admin
    function createAdmin(Admin $admin)
    {
        $statement = $this->connection->prepare("INSERT INTO AdminUser (Title, DepartmentID, UserID) VALUES(?, ?, ?)");
        $statement->bind_param("sii", $admin->Title, $admin->DepartmentID, $admin->UserID);
        $statement->execute();
        $statement->close();
    }

    function readAdmin(int $id)
    {
        $statement = $this->connection->prepare("SELECT * FROM AdminUser WHERE AdminUserID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result->fetch_assoc();
    }

    function updateAdmin(Admin $admin)
    {
        $statement = $this->connection->prepare("UPDATE AdminUser SET Title = ?, DepartmentID = ?, UserID = ? WHERE AdminUserID = ?");
        $statement->bind_param("siii", $admin->Title, $admin->DepartmentID, $admin->UserID, $admin->AdminUserID);
        $statement->execute();
        $statement->close();
    }

    function deleteAdmin(int $id)
    {
        $statement = $this->connection->prepare("DELETE FROM AdminUser WHERE UserID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
    }

    function deleteAdminByID(int $id)
    {
        $statement = $this->connection->prepare("DELETE FROM AdminUser WHERE AdminUserID = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
    }

    //Updates
    function updateSiteTitle(string $Title)
    {
        $statement = $this->connection->prepare("UPDATE PageSettings SET PageSettingValue = ? WHERE PageSettingName = 'SiteTitle'");
        $statement->bind_param("s", $Title);
        $statement->execute();
        $statement->close();
    }

    function updatePageLogo(string $Logo)
    {
        $statement = $this->connection->prepare("UPDATE PageSettings SET PageSettingValue = ? WHERE PageSettingName = 'PageLogo'");
        $statement->bind_param("s", $Logo);
        $statement->execute();
        $statement->close();
    }

    function updateFavIcon(string $FavIcon)
    {
        $statement = $this->connection->prepare("UPDATE PageSettings SET PageSettingValue = ? WHERE PageSettingName = 'FavIcon'");
        $statement->bind_param("s", $FavIcon);
        $statement->execute();
        $statement->close();
    }
    
    //PageContent
    function updateAbout(string $About)
    {
        $statement = $this->connection->prepare("UPDATE PageContent SET ContentValue = ? WHERE SectionName = 'About'");
        $statement->bind_param("s", $About);
        $statement->execute();
        $statement->close();
    }

    function updateContact(string $Contact)
    {
        $statement = $this->connection->prepare("UPDATE PageContent SET ContentValue = ? WHERE SectionName = 'Contact'");
        $statement->bind_param("s", $Contact);
        $statement->execute();
        $statement->close();
    }

    function updateTerms(string $Terms)
    {
        $statement = $this->connection->prepare("UPDATE PageContent SET ContentValue = ? WHERE SectionName = 'Terms'");
        $statement->bind_param("s", $Terms);
        $statement->execute();
        $statement->close();
    }

    function updatePrivacy(string $Privacy)
    {
        $statement = $this->connection->prepare("UPDATE PageContent SET ContentValue = ? WHERE SectionName = 'Privacy'");
        $statement->bind_param("s", $Privacy);
        $statement->execute();
        $statement->close();
    }

    function __destruct()
    {
        parent::__destruct();
    }
}
?>