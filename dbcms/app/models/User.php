<?php
class User
{
    public $UserID;
    public $Email;
    public $UserPassword;
    public $FirstName;
    public $LastName;
    public $AdressID;

    function __construct(string $Email, string $UserPassword, string $FirstName, string $LastName, int $AdressID)
    {
        $this->Email = $Email;
        $this->UserPassword = md5($UserPassword);
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->AdressID = $AdressID;
    }
}
?>