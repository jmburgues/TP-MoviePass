<?php

namespace Models;

class DiscountPolicy
{
    private $discountID;
    private $percentage;
    private $description;
    private $days;

    function __construct($discountID, $percentage, $description, $days)
    {
        $this->discountID = $discountID;
        $this->percentage = $percentage;
        $this->description = $description;
        $this->days = $days;
    }

    public function getDiscountID(){
        return $this->discountID;
    }

    public function getPercentage(){
        return $this->percentage;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getDays(){
        return $this->days;
    }

    public function setDiscountID($discountID)
    {
        $this->discountID = $discountID;
    }

    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function setDays($days)
    {
        $this->days = $days;
    }
}
