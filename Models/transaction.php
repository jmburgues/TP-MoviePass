<?php

namespace Models;

class Transaction
{
    private $transactionID;
    private $percentage;
    private $description;
    private $days;

    function __construct($percentage, $description, $days)
    {
        $this->transactionID = 1;//hacer incremental
        $this->percentage = $percentage;
        $this->description = $description;
        $this->days = $days;
    }

    public function getTransactionID()
    {
        return $this->transactionID;
    }
    public function getPercentage()
    {
        return $this->percentage;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getDays()
    {
        return $this->days;
    }

    public function setTransactionID($transactionID)
    {
        $this->$transactionID = $transactionID;
    }
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setDays($days)
    {
        $this->days= $days;
    }
}
?>