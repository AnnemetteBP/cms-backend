<?php
class Adress
{
    public $AdressID;
    public $Phone;
    public $StreetName;
    public $StreetNumber;
    public $FloorNumber;
    public $PostalCode;
    public $Country;

    function __construct($Phone, $StreetName, $StreetNumber, $FloorNumber, $PostalCode, $Country)
    {
        $this->Phone = $Phone;
        $this->StreetName = $StreetName;
        $this->StreetNumber = $StreetNumber;
        $this->FloorNumber = $FloorNumber;
        $this->PostalCode = $PostalCode;
        $this->Country = $Country;
    }
}
?>