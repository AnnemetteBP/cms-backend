INSERT INTO NewsPost (NewsPostID, Title, Content, PostDate) VALUES(1, 'News post Title', 'Some content in this news post.', '2018-12-31');

INSERT INTO PageContent (SectionID, SectionName, ContentValue) VALUES(1, 'About', '
                            <h4 class="card-text">Welcome to the Rubba Duck Webshop</h4>
                            <hp class="card-text">This is a complete fake webshop with very poor service.</hp>
                        ');
INSERT INTO PageContent (SectionID, SectionName, ContentValue) VALUES(2, 'Contact', '
                        <adress>
                            <h4 class="card-text">Adress</h4>
                            <p class="card-text">Some street Name 1, 0000 .Nowhere</p>
                            <h4 class="card-text">Phone</h4>
                            <p class="card-text">+00 00 00 00 00</p>
                            <h4 class="card-text">Email</h4>
                            <p class="card-text">email@email.com</p>
                            <h5 class="card-text">CVR</h5>
                            <p class="card-text">??00000000??</p>
                        </adress>
                    ');
INSERT INTO PageContent (SectionID, SectionName, ContentValue) VALUES(3, 'Terms', 'Some content for the terms section.');
INSERT INTO PageContent (SectionID, SectionName, ContentValue) VALUES(4, 'Privacy', 'Some content for the privacy section.');

INSERT INTO Department (DepartmentID, DepartmentName) VALUES(1, 'Shop department');

INSERT INTO Adress (AdressID, Phone, StreetName, StreetNumber, FloorNumber, PostalCode, Country) VALUES(1, '004531400042', 'Some str.', '100', 'K', '9999', 'DK');

INSERT INTO User (UserID, Email, UserPassword, FirstName, LastName, AdressID) VALUES(1, 'user@place.com', '26a6036ad77728fa6758787622add9a2', 'kode', 'ord', 1);

INSERT INTO AdminUser (AdminUserID, Title, DepartmentID, UserID) VALUES (1, 'Owner', 1, 1);

INSERT INTO Orders (OrderID, OrderDate, ShipDate, TotalCost, UserID) VALUES (1, '2018-12-31', '2019-01-02', 100, 1);

INSERT INTO Brand (BrandID, BrandName, BrandDescription, BrandLogo) VALUES (1, 'That Brand', 'The brand', 'default-brand.png');

INSERT INTO Product (ProductID, ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES (1, 'Top mordern', 'The best is the most popular!', 1, 'Shiny', 100, 1, 14, 8, 'imgs/rubber-ducks/white/duck1.jpg');
INSERT INTO Product (ProductID, ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES (2, 'The classic', 'True cult status.', 1, 'White', 85, 1, 16, 0, 'imgs/rubber-ducks/white/duck22.jpg');
INSERT INTO Product (ProductID, ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES (3, 'Old school', 'School is out 4 ever!', 1, 'White-widdow', 65, 1, 30, 4, 'imgs/rubber-ducks/white/duck28.png');
INSERT INTO Product (ProductID, ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES (4, 'New age', 'The new age has dawned.', 1, 'White-darkened', 105, 1, 21, 12, 'imgs/rubber-ducks/white/duck30.jpg');
INSERT INTO Product (ProductID, ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES (5, 'Black', 'Dark duck', 1, 'Black', 15, 1, 10, 0, 'imgs/rubber-ducks/black/duck10.jpg');
INSERT INTO Product (ProductID, ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES (6, 'Creeper', 'Weird and small', 1, 'Blacker', 95, 1, 54, 65, 'imgs/rubber-ducks/black/duck19.jpg');
INSERT INTO Product (ProductID, ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES (7, 'Regular', 'The normal one', 1, 'Yellow', 105, 1, 3, 43, 'imgs/rubber-ducks/yellow/duck3.jpg');
INSERT INTO Product (ProductID, ProductName, ProductDescription, Size, Color, Prize, BrandID, Stock, Sold, ProductImage) VALUES (8, 'Cute', 'The cutest duck there have ever been', 1, 'Yellow-ish', 105, 1, 1, 10, 'imgs/rubber-ducks/yellow/duck6.jpg');

INSERT INTO ShoppingCart (ShoppingCartID, OrderID, ProductID) VALUES (1, 1, 1);

INSERT INTO Rating (RatingID, Score, ProductID, UserID) VALUES (1, 5, 8, 1);

INSERT INTO Category (CategoryID, ProductID, CategoryName) VALUES (1, 1, 'Misc');

INSERT INTO Offer (OfferID, ProductID, OfferName, Discount, FromDate, ToDate) VALUES (1, 4, 'Discount', 10, '2018-12-29', '2018-12-30');
INSERT INTO Offer (OfferID, ProductID, OfferName, Discount, FromDate, ToDate) VALUES (2, 3, 'Wholesale', 50, '2018-12-29', '2018-12-30');
INSERT INTO Offer (OfferID, ProductID, OfferName, Discount, FromDate, ToDate) VALUES (3, 2, 'Seasonal', 25, '2018-12-29', '2018-12-30');

INSERT INTO NewsLetter (NewsLetterID, Title, Content, NewsDate, AdminID) VALUES (1, 'The news letter is here', 'Good luck!', '2018-12-24', 1);
INSERT INTO NewsLetter (Title, Content, NewsDate, AdminID) VALUES ('The news letter is here 2', 'Good luck 2 u!', '2018-12-25', 1);

INSERT INTO PageSettings (PageSettingName, PageSettingValue) VALUES ('SiteTitle', 'Rubba Duck Shop');
INSERT INTO PageSettings (PageSettingName, PageSettingValue) VALUES ('PageLogo', 'imgs/cms-logo.png');
INSERT INTO PageSettings (PageSettingName, PageSettingValue) VALUES ('FavIcon', 'favico.svg');