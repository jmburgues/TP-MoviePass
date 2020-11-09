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
      

    //Botón de la visa de agregar películas a la base de datos. Agregar más películas de la API
    public function addToSelectMoviesView($page = 1)
    {
      $this->JSONMovie->addMoreLatestMovies();
      $movies = $this->JSONMovie->getAll();
      #usort($movies, function($a, $b) {return strcmp($a->getTitle(), $b->getTitle());});
      ViewController::navView($genreList=null,$moviesYearList=null,null,null);
      include(VIEWS_PATH.'selectMoviesView.php');
    }

    //Muestra las películas del JSON que pueden ser cargadas en la base de datos.
    public function selectMoviesView($page = 1)
    {
      $movies = $this->JSONMovie->getAll();
      #usort($movies, function($a, $b) {return strcmp($a->getTitle(), $b->getTitle());});
      ViewController::navView($genreList=null,$moviesYearList=null,null,null);
      include(VIEWS_PATH.'selectMoviesView.php');
    }

    //Devuelve las palículas cargadas en la base de datos. Paginación.
    public function selectMoviesFromBDD($page = 1)
    {
      $moviesBDD = $this->DAOMovie->getAll();
      usort($moviesBDD, function($a, $b) {return strcmp($a->getTitle(), $b->getTitle());});
      ViewController::navView($genreList=null,$moviesYearList=null,null,null);
      include(VIEWS_PATH.'listMoviesBDD.php');
    }

    //Muestra el listado de las películas en la base de datos
    //Recibe un id de la movie seleccionada y valida el id con la DB
    public function selectIdMovie($idMovie, $page = 1){
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
            $message = "Movie added i database";
        } else {
            $message = "Movie already on database";
            
        }
        $moviesBDD = $this->DAOMovie->getAll();
        usort($moviesBDD, function($a, $b) {return strcmp($a->getTitle(), $b->getTitle());});

        ViewController::navView($genreList=null,$moviesYearList=null,null,null);        
        include(VIEWS_PATH.'listMoviesBDD.php');
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

    ViewController::navView($genreList,$moviesYearList,null,null); // falta implementar SESSION
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
    ViewController::navView($genreList=null,$moviesYearList=null,null,null);
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
    ViewController::navView($genreList=null,$moviesYearList=null,null,null);
    include(VIEWS_PATH.'listRoomsAdmin.php');
  }
  

}
?>