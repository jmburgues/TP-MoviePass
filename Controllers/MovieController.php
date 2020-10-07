<?php

namespace Controllers;

use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\DAOMovie as DAOMovie;
use DAO\DAOGenre as DAOGenre;

class MovieController{
  
  function getLatestMoviesFromApi(){  
    $data = file_get_contents("http://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a";
    $array = ($data) ? json_decode($data, true) : array();
    $result = $array["results"];
    foreach ($result as $value){
      if(is_array($value)){
        $movieData = file_get_contents("https://api.themoviedb.org/3/movie/".$value["id"]"?language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a");
        $movie = ($movieData) ? json_decode($movieData, true) : array();
        $genre = array();
        foreach ($value["genres"] as $genreData) {
          array_push($genre, new Genre($genreData["id"],$genreData["name"]));
        }
        $newMovie = new Movie($movie["runtime"],$movie["title"],$genre,$movie["poster_path"],$movie["id"])
      }
    }
  }

}
?>