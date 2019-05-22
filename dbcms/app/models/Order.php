<?php
class Order
{
    public $OrderID;
    public $OrderDate;
    public $ShipDate;
    public $TotalCost;
    public $UserID;

    function __construct(string $OrderDate, string $ShipDate, int $TotalCost, int $UserID)
    {
        $this->OrderDate = $OrderDate;
        $this->ShipDate = $ShipDate;
        $this->TotalCost = $TotalCost;
        $this->UserID = $UserID;
    }
}
?>