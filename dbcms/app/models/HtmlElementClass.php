<?php
class HtmlElementClass
{
    public $HtmlElementClassID;
    public $ElementName;
    public $ClassValue;

    function __construct(string $ElementName, string $ClassValue)
    {
        $this->ElementName = $ElementName;
        $this->ClassValue = $ClassValue;
    }
}

?>