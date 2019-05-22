DROP PROCEDURE IF EXISTS SelectProducts;
DELIMITER $$
CREATE PROCEDURE SelectProducts()
BEGIN
SELECT * FROM Product;
END$$
DELIMITER ;
CALL SelectProducts();

DROP PROCEDURE IF EXISTS ViewOrder;
DELIMITER $$
CREATE PROCEDURE ViewOrder(IN id int)
BEGIN
SELECT * FROM Orders WHERE OrderID=id;
END$$
DELIMITER ;
CALL ViewOrder(1);

DROP VIEW IF EXISTS Admins;
CREATE VIEW Admins AS
SELECT User.Email, User.FirstName, User.LastName, AdminUser.Title
FROM User
INNER JOIN AdminUser
WHERE AdminUser.UserID=User.UserID; 

SELECT * FROM Admins;

DROP VIEW IF EXISTS ProductInfo;
CREATE VIEW ProductInfo AS
SELECT Product.ProductName, Product.ProductDescription, Product.Size, Product.Color, Brand.BrandName, Brand.BrandDescription, Brand.BrandLogo
FROM Product
INNER JOIN Brand
WHERE Product.BrandID=Brand.BrandID; 

SELECT * FROM ProductInfo;