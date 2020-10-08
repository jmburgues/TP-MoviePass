<?php

namespace Models;

class Movie
{
    private $duration;
    private $title;
    private $genre;
    private $movieID;

    function __construct($duration, $title, $genre, $movieID)
    {
        $this->duration = $duration;
        $this->title = $title;
        $this->genre = $genre;
        $this->movieID =  $movieID; //no es incremental porque lo recibe de la API
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getGenre(){
        return $this->genre;
    }

    public function getMovieID()
    {
        return $this->movieID;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }
}
