<?php

namespace Models;
use Models\Genre as Genre;
class Movie
{
    private $duration;
    private $title;
    private $genre = array();
    private $poster;
    private $releaseDate;
    private $description;
    private $movieID;

    function __construct($duration='', $title='',Genre $genre ,$poster='', $releaseDate='', $description='', $movieID='')
    {
        $this->duration = $duration;
        $this->title = $title;
        $this->genre = $genre;
        $this->poster = $poster;
        $this->releaseDate = $releaseDate;
        $this->description = $description;
        $this->movieID =  $movieID; //no es incremental porque lo recibe de la API
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getGenre(){
        return $this->genre;
    }

    public function getMovieID()
    {
        return $this->movieID;
    }

    public function getPoster()
    {
        return $this->poster;
    }

    public function setPoster($poster)
    {
        $this->poster = $poster;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle(){
        return $this->title;
    }


    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function setReleaseDate($date)
    {
        $this->releaseDate = $date;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }


}
