<?php
class Admin
{
    public $AdminUserID;
    public $Title;
    public $DepartmentID;
    public $UserID;

    function __construct(string $Title, int $DepartmentID, int $UserID)
    {
        $this->Title = $Title;
        $this->DepartmentID = $DepartmentID;
        $this->UserID = $UserID; 
    }
}
?>