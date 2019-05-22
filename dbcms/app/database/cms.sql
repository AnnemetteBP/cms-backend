DROP DATABASE IF EXISTS dbcms;
CREATE DATABASE dbcms;
USE dbcms;

CREATE TABLE NewsPost(
    NewsPostID int NOT NULL AUTO_INCREMENT,
    Title varchar(255) NOT NULL,
    Content TEXT NOT NULL,
    PostDate DATETIME NOT NULL,
    PRIMARY KEY (NewsPostID)
);

CREATE TABLE PageContent(
    SectionID int NOT NULL AUTO_INCREMENT,
    SectionName varchar(255) NOT NULL,
    ContentValue TEXT NOT NULL,
    PRIMARY KEY (SectionID)
);

CREATE TABLE Department(
    DepartmentID int NOT NULL AUTO_INCREMENT,
    DepartmentName varchar(255) NOT NULL,
    PRIMARY KEY (DepartmentID)
);

CREATE TABLE Adress(
    AdressID int NOT NULL AUTO_INCREMENT,
    Phone varchar(32) NOT NULL,
    StreetName varchar(64) NOT NULL,
    StreetNumber varchar(16) NOT NULL,
    FloorNumber varchar(8) NOT NULL,
    PostalCode varchar(16) NOT NULL,
    Country varchar(64) NOT NULL,
    PRIMARY KEY (AdressID)
);

CREATE TABLE User(
    UserID int NOT NULL AUTO_INCREMENT,
    Email varchar(255) NOT NULL,
    UserPassword varchar(255) NOT NULL,
    FirstName varchar(128) NOT NULL,
    LastName varchar(255) NOT NULL,
    AdressID int NOT NULL,
    PRIMARY KEY (UserID),
    FOREIGN KEY (AdressID) REFERENCES Adress(AdressID)
);

CREATE TABLE AdminUser(
    AdminUserID int NOT NULL AUTO_INCREMENT,
    Title varchar(64) NOT NULL,
    DepartmentID int NOT NULL,
    UserID int NOT NULL,
    PRIMARY KEY (AdminUserID),
    FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID),
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);

CREATE TABLE Orders(
    OrderID int NOT NULL AUTO_INCREMENT,
    OrderDate DATETIME NOT NULL,
    ShipDate DATETIME NOT NULL,
    TotalCost int NOT NULL,
    UserID int NOT NULL,
    PRIMARY KEY (OrderID),
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);

CREATE TABLE Brand(
    BrandID int NOT NULL AUTO_INCREMENT,
    BrandName varchar(64) NOT NULL,
    BrandDescription TEXT NOT NULL,
    BrandLogo varchar(255) NOT NULL,
    PRIMARY KEY (BrandID)
);

CREATE TABLE Product(
    ProductID int NOT NULL AUTO_INCREMENT,
    ProductName varchar(128) NOT NULL,
    ProductDescription TEXT NOT NULL,
    Size int NOT NULL,
    Color varchar(64) NOT NULL,
    Prize int NOT NULL,
    BrandID int NOT NULL,
    Stock int NOT NULL,
    Sold int NOT NULL,
    ProductImage varchar(255) NOT NULL,
    PRIMARY KEY (ProductID),
    FOREIGN KEY (BrandID) REFERENCES Brand(BrandID)
);

CREATE TABLE ShoppingCart(
    ShoppingCartID int NOT NULL AUTO_INCREMENT,
    OrderID int NOT NULL,
    ProductID int NOT NULL,
    PRIMARY KEY (ShoppingCartID),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

CREATE TABLE Rating(
    RatingID int NOT NULL AUTO_INCREMENT,
    Score int NOT NULL,
    ProductID int NOT NULL,
    UserID int NOT NULL,
    PRIMARY KEY (RatingID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID),
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);

CREATE TABLE Category(
    CategoryID int NOT NULL AUTO_INCREMENT,
    ProductID int NOT NULL,
    CategoryName varchar(64) NOT NULL,
    PRIMARY KEY(CategoryID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

CREATE TABLE Offer(
    OfferID int NOT NULL AUTO_INCREMENT,
    ProductID int NOT NULL,
    OfferName varchar(64) NOT NULL,
    Discount int NOT NULL,
    FromDate DATETIME NOT NULL,
    ToDate DATETIME NOT NULL,
    PRIMARY KEY(OfferID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

CREATE TABLE NewsLetter(
    NewsLetterID int NOT NULL AUTO_INCREMENT,
    Title varchar(64) NOT NULL,
    Content TEXT NOT NULL,
    NewsDate DATETIME NOT NULL,
    AdminID int NOT NULL,
    PRIMARY KEY (NewsLetterID),
    FOREIGN KEY (AdminID) REFERENCES AdminUser(AdminUserID)
);

CREATE TABLE PageSettings(
    PageSettingName varchar(255) NOT NULL,
    PageSettingValue TEXT NOT NULL
);