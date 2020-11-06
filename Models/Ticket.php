<?php

namespace Models;

class Ticket
{
    private $idTicket;
    private $QRCode;
    private $idShow;
    private $idTransaction;

    public function getIdTicket()
    {
        return $this->idTicket;
    }

    public function getQRCode(){
        return $this->QRCode;
    }

    public function getIdShow()
    {
        return $this->idShow;
    }

    public function getTdTransaction()
    {
        return $this->idTransaction;
    }
    
    public function setIdTicket($idTicket)
    {
        $this->idTicket = $idTicket;   
    }

    public function setQRCode($QRCode){
        $this->QRCode = $QRCode;
    }

    public function setIdShow($idShow)
    {
        $this->idShow = $idShow;
    }

    public function setTdTransaction($idTransaction)
    {
        $this->idTransaction = $idTransaction;

    }


}
?>