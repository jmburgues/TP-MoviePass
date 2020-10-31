<?php

namespace Controllers;

use \DateTime as DateTime;
use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\DAOMovie as DAOMovie;
use DAO\DAOGenre as DAOGenre;
use DAO\PDO\PDOMovie as PDOMovie;
use DAO\PDO\PDOCinema as DAOCinema;
use DAO\PDO\PDOGenre as PDOGenre;

class MovieController
{
    private $daoMovie;
    private $daoGenre;
    private $pdoMovie;
    private $pdoGenre;
    private $daoCinema;
    private $currentMovie;


    public function __construct()
    {
        $this->daoMovie = new DAOMovie();
        $this->daoGenre = new DAOGenre();
        $this->pdoGenre = new PDOGenre();
        $this->daoCinema = new DAOCinema();
        $this->pdoMovie = new PDOMovie();
    }

    public function selectMoviesView()
    {
        $movies = $this->daoMovie->getAll();
      
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include(VIEWS_PATH.'selectMoviesView.php');
    }

    public function selectIdMovie($idMovie)
    {
        $movies = $this->daoMovie->getAll();
        $movieToAdd = null;
        foreach ($movies as $movie) {
            if ($movie->getMovieID() == $idMovie) {
                $movieToAdd = $movie;
            }
        }
        
        $moviesBDD = $this->pdoMovie->getAll();
 

        if (!($this->pdoMovie->getById($idMovie))) {
            $this->pdoMovie->add($movieToAdd);
        } else {
            $message = "Movie already on database";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
      
        $moviesBDD = $this->pdoMovie->getAll();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include(VIEWS_PATH.'listMoviesBDD.php');
    }


    /*Función que trae de la API e invoca funciones del DAO para guardar en archivo JSON */
    public function getLatestMoviesFromApi()
    {
        //Llamada a la API
       // for ($i=1; $i<75 ; $i+1) {
            $data = file_get_contents("http://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a&page=4");
            
            //Convierte el JSON a un arreglo
            $array = ($data) ? json_decode($data, true) : array();

            //Accede a la clave 'results'
            $result = $array["results"];
      
            //Recorre el arreglo con los resultados
            foreach ($result as $value) {
                if (is_array($value)) {
          
          //Trae toda la información de cada película
                    $movieData = file_get_contents("https://api.themoviedb.org/3/movie/".$value["id"]."?language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a");
                    $movie = ($movieData) ? json_decode($movieData, true) : array();
                    $genre = array();

                    //De cada película se obtienen los generos y se crea un objeto de éste
                    foreach ($movie["genres"] as $genreData) {
                        $aux = new Genre($genreData["name"], $genreData["id"]);
                        array_push($genre, $aux);
                        $this->daoGenre->add($aux);
                    }
                    //Se crea el objeto Movie y se agrega al arrelgo
                    $newMovie = new Movie($movie["runtime"], $movie["title"], $genre, $movie["poster_path"], $movie["release_date"], $movie["overview"], $movie["id"]);
                    $this->daoMovie->add($newMovie);
                }
            }
        //}
    }
  function listMovies(){
    $movies = $this->pdoMovie->getAll();
  }

  function listByGenre($genreId){
    
    $genreName = $this->pdoGenre->getById($genreId)->getName();
    
    $genreList = $this->pdoGenre->getGenresListFromShows(); 

    $moviesYearList = $this->pdoMovie->getArrayOfYearsFromShows();
    $moviesList = $this->pdoMovie->getAll();
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




  public function selectMovie($selectedId){
    $cinemas = $this->pdoCinema->getActiveCinemas();  
    $movies=$this->pdoMovie->getAll();
    $listAdminMovies = null;
    foreach($movies as $movie){
      if($movie->getMovieId() == $selectedId){
        $listAdminMovies = $movie;
      }
    } 
    ViewController::navView($genreList=null,$moviesYearList=null,null);
    include(VIEWS_PATH.'listMoviesAdmin.php');
  }
  
  public function selectRoom($selectedCinemaId, $selectedMovieId){
    $cinemas = $this->pdoCinema->getActiveCinemas();  
    $movies=$this->pdoMovie->getAll();
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
    ViewController::navView($genreList=null,$moviesYearList=null,null);
    include(VIEWS_PATH.'listRoomsAdmin.php');
  }
  

}
?>