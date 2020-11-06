<?php

namespace Models;
use Models\User as User;
class Transaction
{
    private $idTransaction;
    private $user;
    private $date;

    function __construct(User $user, $date='', $idTransaction='')
    {
        $this->idTransaction = $idTransaction;
        $this->user = $user;
        $this->date = $date;
    }

    public function getIdTransaction()
    {
        return $this->idTransaction;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function setIdTransaction($idTransaction)
    {
        $this->$idTransaction = $idTransaction;
    }
    public function setUser($user)
    {
        $this->user = $user;
    }
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
    public function setDate($date)
    {
        $this->date= $date;
    }
  
}
?>