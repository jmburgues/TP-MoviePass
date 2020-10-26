<?php
namespace Models;

class Show
{
    private $idShow;
    private $date;
    private $hour;
    private $idRoom;
    private $idMovie;
    private $spectators;
    
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
    
    public function getIdShow()
    {
        return $this->idShow;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function getIdMovie()
    {
        return $this->movie;
    }
    
    public function setIdMovie($movie)
    {
        $this->movie = $movie;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setIdShow($idShow)
    {
        $this->idShow = $idShow;
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
