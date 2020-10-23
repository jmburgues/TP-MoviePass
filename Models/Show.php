<?php

namespace Models;

class Show
{
    private $idRoom;
    private $hour;
    private $spectators;
￼

    function __construct($hour, $spectators)
    {
        $this->hour = $hour;
        $this->spectators = $spectators;
    }

    public function getIdRoom()
    {
        return $this->idRoom;
    }

    public function getHour()
    {
        return $this->hour;
    }

    public function getSpectators()
    {
        return $this->spectators;
    }
    
    public function setIdRoom($idRoom)
    {
        $this->idRoom = $idRoom;
    }

    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    public function setSpectators($spectators)
    {
        $this->spectators = $spectators;
    }
}
