<?php


class Pagination
{

    private $start;
    private $num;
    private $total;
    private $page;




    public function __construct($page = 1, $num = 25, $count)
    {
        $this->num = $num;



        $this->total = intval(($count - 1) /$num)+1;



        $this->page = intval($page);

        if (empty($this->page) or $this->page < 0) $this->page = 1;
        if ($this->page > $this->total) $this->page = $this->total;

        $this->start = $page * $num - $num;
        $this->num = $num;



    }


    public function getStart()
    {
        return $this->start;
    }
    public function getNum()
    {
        return $this->num;
    }
    public function getTotal()
    {
        return $this->total;
    }
    public function getPage()
    {
        return $this->page;
    }




}