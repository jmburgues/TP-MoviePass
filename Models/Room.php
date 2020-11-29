<?php

namespace Models;
use Models\Cinema as Cinema;

class Room
{
    private $ID;
    private $name;
    private $capacity;
    private $cinema;
    private $price;
    private $roomType;
    private $active;

    function __construct($name='',$capacity='',Cinema $cinema,$price='',$roomType='',$active=true,$ID=''){
        $this->name = $name;
        $this->capacity = $capacity;
        $this->cinema = $cinema;
        $this->price = $price;
        $this->roomType = $roomType;
        $this->active = $active;
        $this->ID = $ID;
    }

    public function getId()
    {
        return $this->ID;
    }

    public function getCapacity(){
        return $this->capacity;
    }

    public function getCinema(){
        return $this->cinema;
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
    public function getActive()
    {
        return $this->active;
    }
    
    public function setActive($active)
    {
        $this->active = $active;
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

    public function setCinema($cinema){
        $this->cinema = $cinema;
    }



}
