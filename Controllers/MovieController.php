<?php

namespace Controllers;

use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\DAOMovie as DAOMovie;
use DAO\DAOGenre as DAOGenre;

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

        foreach ($movie["genres"] as $genreData) {
          $aux = new Genre($genreData["id"],$genreData["name"]);
          array_push($genre, $aux);
          $this->daoGenre->add($aux);
        }
        $newMovie = new Movie($movie["runtime"],$movie["title"],$genre,$movie["poster_path"],$movie["release_date"],$movie["overview"],$movie["id"]);
        $this->daoMovie->add($newMovie);
      }
    }
  }
  
  function listMovies(){
    $movies = $this->daoMovie->getAll();
   // include(VIEWS_PATH."home.php");
  }
  
  function getMoviesByDate($year){ // returns an array of movies (Object) created on a given date (1st revision)
    
    if($year > 1900 && $year <= 2020){

        $moviesList = $this->daoMovie->getAll();

        $wantedMovies = array();

        foreach($moviesList as $oneMovie){
          
          $releaseDate = $oneMovie->getReleaseDate();
          $releaseYear = $releaseDate->format('Y');

          if($releaseYear == $year && !in_array($wantedMovies,$oneMovie)){
            array_push($wantedMovies,$oneMovie);
          }
        }

        return $wantedMovies;
      }
    return false;
  }

  function listByGenre($genreId){
      
    $moviesList = $this->daoMovie->getAll();
    $movies = array();

    foreach($moviesList as $oneMovie){
      
      $movieGenres = $oneMovie->getGenre();

      foreach($movieGenres as $oneGenre){
        
        if($oneGenre->getId() == $genreId){
          array_push($movies,$oneMovie);       
        }   
      }
    }
    include(VIEWS_PATH.'genres-list.php');
  }
}
?>