<?php

namespace Controllers;

use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\DAOMovie as DAOMovie;
use DAO\DAOGenre as DAOGenre;
use \DateInterval as DateInterval;
use \DateTime as DateTime;
class MovieController{

  private $daoMovie;
  private $daoGenre;
  
  public function __construct(){
    $this->daoMovie = new DAOMovie();
    $this->daoGenre = new DAOGenre();
  }

  /*Función que trae de la API e invoca funciones del DAO para guardar en archivo JSON */
  function getLatestMoviesFromApi(){  
    //Llamada a la API
    $data = file_get_contents("http://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a");
  
    //Convierte el JSON a un arreglo
    $array = ($data) ? json_decode($data, true) : array();

    //Accede a la clave 'results'
    $result = $array["results"];
    
    //Recorre el arreglo con los resultados
    foreach ($result as $value){
      if(is_array($value)){
        
        //Trae toda la información de cada película
        $movieData = file_get_contents("https://api.themoviedb.org/3/movie/".$value["id"]."?language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a");
        $movie = ($movieData) ? json_decode($movieData, true) : array();
        $genre = array();

        //De cada película se obtienen los generos y se crea un objeto de éste
        foreach ($movie["genres"] as $genreData) {
          $aux = new Genre($genreData["id"], $genreData["name"]);
          array_push($genre, $aux);
          $this->daoGenre->add($aux);
        }
        //Se crea el objeto Movie y se agrega al arrelgo
        $newMovie = new Movie($movie["runtime"],$movie["title"],$genre,$movie["poster_path"],$movie["release_date"],$movie["overview"],$movie["id"]);
        $this->daoMovie->add($newMovie);
      }
  
    }
  
  }
  
  function listMovies(){
    $movies = $this->daoMovie->getAll();
  }
  
  function getArrayOfYears(){// returns an array of years where different movies where created
      $moviesList = $this->daoMovie->getAll();

      $years = array();

      foreach ($moviesList as $oneMovie) {
          $releaseDate = $oneMovie->getReleaseDate();
          
          $releaseYear = DateTime::createFromFormat('Y-m-d', $releaseDate)->format('Y'); 
          
          if (!in_array($releaseYear, $years)) {
            array_push($years, $releaseYear);
          }
        }
        return $years;
       // var_dump($years);
  }

  function getMoviesByDate($year){ // returns an array of movies (Object) created on a given date (1st revision)
    
    if ($year > 1900 && $year <= 2020) {
        $moviesList = $this->daoMovie->getAll();

        $movies = array();

        foreach ($moviesList as $oneMovie) {
            $releaseDate = $oneMovie->getReleaseDate();
            $releaseYear = DateTime::createFromFormat('Y-m-d', $releaseDate)->format('Y');

            if ($releaseYear == $year && !in_array( $oneMovie, $movies)) {
                array_push($movies, $oneMovie);
            }
        }
    }
        include (VIEWS_PATH.'year-list.php'); 
  }

  function listByGenre($genreId){
    
    $genreName = $this->daoGenre->GetById($genreId)->getName();
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