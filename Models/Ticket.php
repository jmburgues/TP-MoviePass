<?php

namespace Models;
use Models\Show as Show;
use Models\Transaction as Transaction;

class Ticket
{
    private $idTicket;
    private $QRCode;
    private $show;
    private $transaction;


    function __construct(Show $show,Transaction $transaction, $QRCode='', $idTicket='')
    {
        $this->QRCode = $QRCode;
        $this->show = $show;
        $this->transaction = $transaction;
        $this->idTicket = $idTicket;
    }

    public function getIdTicket()
    {
        return $this->idTicket;
    }

    public function getQRCode(){
        return $this->QRCode;
    }

    public function getShow()
    {
        return $this->show;
    }

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
    }

    public function setIdTicket($idTicket)
    {
        $this->idTicket = $idTicket;
    }
    

    public function setQRCode($QRCode){
        $this->QRCode = $QRCode;
    }
    
    public function setShow($show)
    {
        $this->show = $show;
    }


}
?>