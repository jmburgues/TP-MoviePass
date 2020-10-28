<?php

namespace Controllers;

use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\DAOMovie as DAOMovie;
use DAO\PDO\PDOMovie as PDOMovie;
use DAO\DAOCinema as DAOCinema;
use Models\Cinema as Cinema;
use DAO\PDO\PDOGenre as DAOGenre;
use \DateInterval as DateInterval;
use \DateTime as DateTime;

class MovieController{

  private $daoMovie;
  private $pdoMovie;
  private $daoGenre;
  private $daoCinema;
  private $currentMovie;


  public function __construct(){
    $this->daoMovie = new DAOMovie();
    $this->daoGenre = new DAOGenre();
    $this->daoCinema = new DAOCinema();
    $this->pdoMovie = new PDOMovie();

  }

    public function selectMoviesView(){
      $movies = $this->daoMovie->getAll();
      
      include(VIEWS_PATH.'selectMoviesView.php');
    }

    public function selectIdMovie($idMovie){
      $movies = $this->daoMovie->getAll();
      $movieToAdd;
      foreach ($movies as $movie) {
          if ($movie->getMovieID() == $idMovie) {
              $movieToAdd = $movie;
          }
      }
        
      $moviesBDD = $this->pdoMovie->getAll();
      foreach($moviesBDD as $movie){
        echo $movie->getTitle();
        echo "<br>";
      }

      if(!($this->pdoMovie->getById($idMovie))){
        $this->pdoMovie->add($movieToAdd);

      }else{
        $message = "Movie already on database";
        echo "<script type='text/javascript'>alert('$message');</script>"; 
      }
      
      $moviesBDD = $this->pdoMovie->getAll();
      include(VIEWS_PATH.'listMoviesBDD.php');
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

  function listByGenre($genreId){
    
    $genreName = $this->DAOGenre->getById($genreId)->getName();
    
    /********* IMPORTANTE: FALTA IMPLEMENTAR ESTA FUNCION EN PDO (ESTO GENERA BUG) */
    $genreList = $this->DAOGenre->getGenresList(); 
    /********* IMPORTANTE: FALTA IMPLEMENTAR ESTA FUNCION EN PDO (ESTO GENERA BUG) */

    $moviesYearList = $this->DAOMovie->getArrayOfYears();
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

    ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION
    ViewController::homeView($movies,1,"Genre: ".$genreName);
  }

  function getMoviesByDate($year){ // returns an array of movies (Object) created on a given date (1st revision)
    
    /********* IMPORTANTE: FALTA IMPLEMENTAR ESTA FUNCION EN PDO (ESTO GENERA BUG) */
    $genreList = $this->DAOGenre->getGenresList();
    /********* IMPORTANTE: FALTA IMPLEMENTAR ESTA FUNCION EN PDO (ESTO GENERA BUG) */

    $moviesYearList = $this->DAOMovie->getArrayOfYears();

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

    ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION
    ViewController::homeView($movies,1,"Year: ".$year);
  }


  public function selectMovie($selectedId){
    $cinemas = $this->daoCinema->getActiveCinemas();  
    $movies=$this->daoMovie->getAll();
    $listAdminMovies = null;
    foreach($movies as $movie){
      if($movie->getMovieId() == $selectedId){
        $listAdminMovies = $movie;
      }
    } 
    include(VIEWS_PATH.'listMoviesAdmin.php');
  }
  
  public function selectRoom($selectedCinemaId, $selectedMovieId){
    $cinemas = $this->daoCinema->getActiveCinemas();  
    $movies=$this->daoMovie->getAll();
    $currentCinema = null;
    $currentMovie = null;
    foreach($cinemas as $cinema){
      if($cinema->getId() == $selectedCinemaId){
        $currentCinema = $cinema;
      }
    }
    foreach($movies as $movie){
      if($movie->getMovieID() == $selectedMovieId){
        $currentMovie = $movie;
      }
    }
    include(VIEWS_PATH.'listRoomsAdmin.php');
  }
  

}
?>