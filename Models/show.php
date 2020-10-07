<?php

namespace Models;

class Show
{
    private $hour;
    private $spectators;

    function __construct($hour, $spectators)
    {
        $this->hour = $hour;
        $this->spectators = $spectators;
    }

    public function getHour()
    {
        return $this->hour;
    }

    public function getSpectators()
    {
        return $this->spectators;
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
