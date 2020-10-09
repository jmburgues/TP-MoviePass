<?php

namespace Controllers;

use DAO\DAOShows as DAOShows;
use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\DAOMovie as DAOMovie;
use DAO\DAOGenre as DAOGenre;
use DateTime;

class MovieController{

  private $daoMovie;
  private $daoGenre;
  
  public function __construct(){
    $this->daoMovie = new DAOMovie();
    $this->daoGenre = new DAOGenre();
  }

  function getLatestMoviesFromApi(){  
    $data = file_get_contents("http://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a");
    $array = ($data) ? json_decode($data, true) : array();
    $result = $array["results"];
    foreach ($result as $value){
      if(is_array($value)){
        $movieData = file_get_contents("https://api.themoviedb.org/3/movie/".$value["id"]."?language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a");
        $movie = ($movieData) ? json_decode($movieData, true) : array();
        $genre = array();
        foreach ($value["genres"] as $genreData) {
          array_push($genre, new Genre($genreData["id"],$genreData["name"]));
          $this->daoGenre->add($genre);
        }
        $newMovie = new Movie($movie["runtime"],$movie["title"],$genre,$movie["poster_path"],$movie["relase_date"],$movie["overview"],$movie["id"]);
        $this->daoMovie->add($newMovie);
      }
    }
  }

  function getShowsGenres(){ // returns an array of strings with all movie's genres. (1st revision)
    
    $genresList = array();
    $daoMovie = new DAOMovie();
    $moviesList = $daoMovie->getAll();
    
    foreach($moviesList as $oneMovie){
      $movieGenre = $oneMovie->getGenre();
      if(!in_array($genresList,$movieGenre))
        array_push($genresList,$movieGenre);
    }

    return $genresList;
  }

  function getMoviesByDate($date){ // returns an array of movies (Object) created on a given date (1st revision)
    
    if($date instanceof DateTime){
      $today = date("Y-m-d");

      if($date <= $today){

        $daoMovies = new DAOMovie();
        $moviesList = $daoMovies->getAll();

        $wantedMovies = array();

        foreach($moviesList as $oneMovie){

          if($oneMovie->getReleaseDate == $date && !in_array($wantedMovies,$oneMovie)){
            array_push($wantedMovies,$oneMovie);
          }
        }

        return $wantedMovies;
      }
    }
    return false;
  }
}
?>