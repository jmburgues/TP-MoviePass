<?php

namespace Models;

class Room
{
    private $id;
    private $idCinema;
    private $name;
    private $price;
    private $seats;

    public function getId()
    {
        return $this->id;
    }

    public function getIdCinema()
    {
        return $this->idCinema;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getSeats(){
        return $this->seats;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdCinema($idCinema)
    {
        $this->idCinema = $idCinema;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setSeats($seats)
    {
        $this->seats = $seats;
    }
}
