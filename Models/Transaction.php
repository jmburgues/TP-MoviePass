<?php

namespace Models;

class Transaction
{
    private $idTransaction;
    private $userName;
    private $date;
/*
    function __construct($idTransaction, $userName, $date)
    {
        $this->idTransaction = $idTransaction;
        $this->userName = $userName;
        $this->date = $date;
    }
*/
    public function getIdTransaction()
    {
        return $this->idTransaction;
    }
    public function getUserName()
    {
        return $this->userName;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function setIdTransaction($idTransaction)
    {
        $this->$idTransaction = $idTransaction;
    }
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }
  
}
?>