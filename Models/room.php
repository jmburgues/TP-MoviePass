<?php

namespace Models;

class Room
{
    private $name;
    private $number;
    private $seats;

    function __construct($name, $number, $seats)
    {
        $this->name = $name;
        $this->number = $number;
        $this->seats = $seats;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNumber(){
        return $this->number;
    }

    public function getSeats(){
        return $this->seats;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSeats($seats)
    {
        $this->seats = $seats;
    }
}
