<?php

namespace Models;

class Ticket
{
    private $ticketNumber;
    private $QRCode;
    private $seatNumber;
/*
    function __construct($QRCode, $seatNumber)
    {
        $this->ticketNumber = 1; //hacer incremental
        $this->QRCode = $QRCode;
        $this->seatNumber = $seatNumber;
    }
*/
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }

    public function getQRCode(){
        return $this->QRCode;
    }

    public function getSeatNumber()
    {
        return $this->seatNumber;
    }

    public function setTicketNumber($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;
    }

    public function setQRCode($QRCode)
    {
        $this->QRCode = $QRCode;
    }
    
    public function setSeatNumber($seatNumber)
    {
        $this->seatNumber = $seatNumber;
    }
}
?>