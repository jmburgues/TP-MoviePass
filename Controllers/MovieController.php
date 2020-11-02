<?php

namespace Controllers;

use \DateTime as DateTime;
use Models\Movie as Movie;
use Models\Genre as Genre;
use DB\PDO\DAOMovie as DAOMovie;
use DB\PDO\DAOGenre as DAOGenre;
use DB\PDO\DAOCinema as DAOCinema;
use DB\JSON\DAOMovie as JSONMovie;

class MovieController
{
    private $DAOMovie;
    private $DAOGenre;
    private $DAOCinema;
    private $JSONMovie;
    private $currentMovie;


    public function __construct()
    {
        $this->DAOMovie = new DAOMovie();
        $this->DAOGenre = new DAOGenre();
        $this->DAOCinema = new DAOCinema();
        $this->JSONMovie = new JSONMovie();
      }
      

    /* Brings up a list of previously selected movies wich are aviable for creating Shows */
    public function selectMoviesView($page = 1)
    {
      $movies = $this->JSONMovie->getAll();
      usort($movies, function($a, $b) {return strcmp($a->getTitle(), $b->getTitle());});
        
      ViewController::navView($genreList=null,$moviesYearList=null,null);
      
      include(VIEWS_PATH.'selectMoviesView.php');
    }

    public function selectIdMovie($idMovie)
    {
        $movies = $this->JSONMovie->getAll();
        $movieToAdd = null;
        foreach ($movies as $movie) {
            if ($movie->getMovieID() == $idMovie) {
                $movieToAdd = $movie;
            }
        }
        
        $moviesBDD = $this->DAOMovie->getAll();
 

        if (!($this->DAOMovie->getById($idMovie))) {
            $this->DAOMovie->add($movieToAdd);
        } else {
            $message = "Movie already on database";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        $moviesBDD = $this->DAOMovie->getAll();
        usort($moviesBDD, function($a, $b) {return strcmp($a->getTitle(), $b->getTitle());});


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
                        $this->DAOGenre->add($aux);
                    }
                    //Se crea el objeto Movie y se agrega al arrelgo
                    $newMovie = new Movie($movie["runtime"], $movie["title"], $genre, $movie["poster_path"], $movie["release_date"], $movie["overview"], $movie["id"]);
                    $this->DAOMovie->add($newMovie);
                }
            }
        //}
    }
 

  function listByGenre($genreId){
    
    $genreName = $this->DAOGenre->getById($genreId)->getName();
    
    $genreList = $this->DAOGenre->getGenresListFromShows(); 

    $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
    $moviesList = $this->DAOMovie->getAll();
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
    $cinemas = $this->DAOCinema->getActiveCinemas();  
    $movies=$this->DAOMovie->getAll();
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
    $cinemas = $this->DAOCinema->getActiveCinemas();  
    $movies=$this->DAOMovie->getAll();
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