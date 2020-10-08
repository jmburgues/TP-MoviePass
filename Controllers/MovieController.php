<?php

namespace Controllers;

use DAO\DAOShows as DAOShows;
use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\DAOMovie as DAOMovie;
use DAO\DAOGenre as DAOGenre;
use DateTime;

class MovieController{
  
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
        }
        $newMovie = new Movie($movie["runtime"],$movie["title"],$genre,$movie["poster_path"],$movie["id"]);
      }
    }
  }

  function getShowsGenres(){ // returns an array of strings with all movie show's genres.
    
    $genresList = array();
    $daoShow = new DAOShows;
    $showsList = $daoShow->getAll();
    
    foreach($showsList as $oneShow){
      $movieGenre = $oneShow->getMovie()->getGenre();
      if(!in_array($genresList,$movieGenre))
        array_push($genresList,$movieGenre);
    }

    return $genresList;
  }

  function getShowsByDate($date){ // returns an array of movie shows to be projected on a given date 
    
    if($date instanceof DateTime){
      $today = date("Y-m-d");

      if($date >= $today){

        $daoShow = new DAOShows();
        $showsList = $daoShow->getAll();

        $moviesToBeProjected = array();

        foreach($showsList as $oneShow){
/**
 * IMPORTANTE - REVISAR
 */
          $movie = $oneShow->getMovie(); // Como obtengo esto, si un Show no tiene como atributo a Movie???

          if($oneShow->getDate >= $today && !in_array($moviesToBeProjected,$movie)){
            array_push($moviesToBeProjected,$oneShow->getMovie());
          }
        }

        return $moviesToBeProjected;
      }
    }
    return false;
  }
}
?>