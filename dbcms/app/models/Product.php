<?php
class Product
{
    public $ProductID;
    public $ProductName;
    public $ProductDescription;
    public $Size;
    public $Color;
    public $Prize;
    public $BrandID;
    public $Stock;
    public $Sold;
    public $ProductImage;

    function __construct(string $ProductName, string $ProductDescription, int $Size, string $Color, int $Prize, int $BrandID, int $Stock, int $Sold, string $ProductImage)
    {
        $this->ProductName = $ProductName;
        $this->ProductDescription = $ProductDescription;
        $this->Size = $Size;
        $this->Color = $Color;
        $this->Prize = $Prize;
        $this->BrandID = $BrandID;
        $this->Stock = $Stock;
        $this->Sold = $Sold;
        $this->ProductImage = $ProductImage;
    }
}
?>