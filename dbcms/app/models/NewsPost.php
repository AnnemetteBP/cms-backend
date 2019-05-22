<?php
class NewsPost
{
    public $NewsPostID;
    public $Title;
    public $Content;
    public $PostDate;

    function __construct(string $Title, string $Content)
    {
        $this->Title = $Title;
        $this->Content = $Content;
    }
}

?>