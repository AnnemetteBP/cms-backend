<?php
class Vat
{
    public $VatID;
    public $VatValue;

    function __construct(int $VatValue)
    {
        $this->VatValue = $VatValue;
    }
}
?>