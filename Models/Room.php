<?php

namespace Models;

class Room
{
    private $ID;
    private $name;
    private $capacity;
    private $IDCinema;
    private $price;
    private $roomType;

    public function getRoomID()
    {
        return $this->ID;
    }

    public function getCapacity(){
        return $this->capacity;
    }

    public function getIDCinema(){
        return $this->IDCinema;
    }
    public function getPrice(){
        return $this->price ;
    }

    public function getName(){
        return $this->name ;
    }

    public function getRoomType(){
        return $this->roomType ;
    }

    public function setRoomType($roomType){
        $this->roomType = $roomType;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setPrice($price){
        $this->price = $price;
    }
    
    public function setRoomID($ID){
        $this->ID = $ID;
    }

    public function setCapacity($capacity){
        $this->capacity = $capacity;
    }

    public function setIDCinema($IDCinema){
        $this->IDCinema = $IDCinema;
    }



}
