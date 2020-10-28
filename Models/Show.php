<?php
namespace Models;

class Show
{
    private $idShow;
    private $date;
    private $start;
    private $end;
    private $idRoom;
    private $idMovie;
    private $spectators;
    private $active;
    
    function __construct($date='', $start='', $end='' ,$idRoom='', $idMovie='', $spectators='', $idShow='')
    {
        $this->date = $date;
        $this->start = $start;
        $this->end = $end;
        $this->idRoom = $idRoom;
        $this->idMovie = $idMovie;
        $this->spectators = $spectators;
       // $this->active = $active;
        $this->idShow =  $idShow; //no es incremental porque lo recibe de la API
    }

    public function getIdRoom()
    {
        return $this->idRoom;
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
    
    public function getIdMovie()
    {
        return $this->idMovie;
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

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function setSpectators($spectators)
    {
        $this->spectators = $spectators;
    }
}
