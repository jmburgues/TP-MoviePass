<?php namespace Models;

    use DAO\DAOCinema as DAOCinema;

Class Cinema
{
    private $id; 
    private $name;
    private $address;
    private $number;
    private $openning;
    private $closing;
    private $ticketValue;
    private $active;

    
    public function getName()
    {
        return $this->name;
    }
    
    public function getAddress()
    {
        return $this->address;
    }
    
        public function getNumber(){
            return $this->number;
        }

    public function getTicketValue()
    {
        return $this->ticketValue;
    }

    public function setName($name)
    {
        $this->name=$name;
    }

    public function setAddress($address)
    {
        $this->address=$address;
    }

    public function setNumber($number)
    {
        $this->number=$number;
    }

    public function setTicketValue($ticketValue)
    {
        $this->ticketValue=$ticketValue;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getOpenning()
    {
        return $this->openning;
    }

    public function setOpenning($openning)
    {
        $this->openning = $openning;

        return $this;
    }

    public function getClosing()
    {
        return $this->closing;
    }

    public function setClosing($closing)
    {
        $this->closing = $closing;

        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}
