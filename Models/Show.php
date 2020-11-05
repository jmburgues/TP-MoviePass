<?php
namespace Models;
use Models\Room as Room;
use Models\Movie as Movie;

class Show
{
    private $idShow;
    private $date;
    private $start;
    private $end;
    private $room;
    private $movie;
    private $spectators;
    private $active;
    
    function __construct($date='', $start='', $end='' ,Room $room, Movie $movie, $spectators='', $active=true, $idShow='')
    {
        $this->date = $date;
        $this->start = $start;
        $this->end = $end;
        $this->room = $room;
        $this->movie = $movie;
        $this->spectators = $spectators;
        $this->active = $active;
        $this->idShow =  $idShow; 
    }

    public function getRoom()
    {
        return $this->room;
    }

    public function getStart()
    {
        return $this->start;
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
    
    public function getMovie()
    {
        return $this->movie;
    }

    public function getActive()
    {
        return $this->active;
    }
    
    public function getEnd()
    {
        return $this->end;
    }
    
    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }
    public function setMovie($movie)
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

    public function setRoom($room)
    {
        $this->room = $room;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function setSpectators($spectators)
    {
        $this->spectators = $spectators;
    }
}
