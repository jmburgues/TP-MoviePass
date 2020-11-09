<?php

namespace Models;
use Models\User as User;
class Transaction
{
    private $idTransaction;
    private $user;
    private $date;
    private $ticketAmount;
    private $costPerTicket;

    function __construct(User $user, $date='', $ticketAmount='',$costPerTicket='', $idTransaction='')
    {
        $this->idTransaction = $idTransaction;
        $this->user = $user;
        $this->date = $date;
        $this->ticketAmount = $ticketAmount;
        $this->costPerTicket = $costPerTicket;
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
    public function getTicketAmount()
    {
        return $this->ticketAmount;
    }
    public function getCostPerTicket()
    {
        return $this->costPerTicket;
    }

    public function setCostPerTicket($costPerTicket)
    {
        $this->costPerTicket = $costPerTicket;
    }

    public function setTicketAmount($ticketAmount)
    {
        $this->ticketAmount = $ticketAmount;
    }
    public function setIdTransaction($idTransaction)
    {
        $this->idTransaction = $idTransaction;
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