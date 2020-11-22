<?php

namespace Controllers;

use DB\PDO\DAOMovie as DAOMovie;
use DB\PDO\DAOGenre as DAOGenre;
use DB\PDO\DAOCinema as DAOCinema;
use DB\JSON\DAOMovie as JSONMovie;
use PDOException;

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

    // Muestra peliculas de la API (Json) que no se encuentren en la base de datos (PDO)
    public function listAPIMovies($page = 1,$message = null){
      try {
        $movies = array();
        $apiMovies = $this->JSONMovie->getAll();

        foreach($apiMovies as $oneMovie){
          if($this->DAOMovie->getById($oneMovie->getMovieID()) == null){
            array_push($movies,$oneMovie);
          }
        }

        usort($movies, function($a, $b) {return strcmp($a->getTitle(), $b->getTitle());});

        ViewController::navView($genreList=null,$moviesYearList=null,null,null);
        include(VIEWS_PATH.'APIMoviesList.php');
      } 
      catch (PDOException $ex){
        $arrayOfErrors [] = $ex->getMessage();
        ViewController::errorView($arrayOfErrors);
      }
    }

    //Devuelve las palículas cargadas en la base de datos. Paginación.
    public function selectMoviesFromBDD($page = 1){
      try {
        $moviesBDD = $this->DAOMovie->getAll();
        usort($moviesBDD, function($a, $b) {return strcmp($a->getTitle(), $b->getTitle());});
        ViewController::navView($genreList=null,$moviesYearList=null,null,null);
        include(VIEWS_PATH.'listMoviesBDD.php');
      } 
      catch (PDOException $ex){
        $arrayOfErrors [] = $ex->getMessage();
        ViewController::errorView($arrayOfErrors);
      }
    }

    //Muestra el listado de las películas en la base de datos
    //Recibe un id de la movie seleccionada y valida el id con la DB
    public function addSelectedMovie($idMovie){
      try {
        $existentMovie_onDB = $this->DAOMovie->getById($idMovie);

        if (!$existentMovie_onDB) {
            $this->DAOMovie->add($this->JSONMovie->GetById($idMovie));
            $message = "Movie added to database";
        } else {
            $message = "Movie already on database"; 
        }
        $page = 1;
        $this->listAPIMovies($page,$message);
      } 

      catch (PDOException $ex){
        $arrayOfErrors [] = $ex->getMessage();
        ViewController::errorView($arrayOfErrors);
      }
    }

  function listByGenre($genreId){
    try {
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

    catch (PDOException $ex){
      $arrayOfErrors [] = $ex->getMessage();
      ViewController::errorView($arrayOfErrors);
    }
  }

  public function addMoreMovies($page = 1){
    try {
      $this->JSONMovie->addMoreLatestMovies();
      $this->listAPIMovies();
    } 

    catch (PDOException $ex){
      $arrayOfErrors [] = $ex->getMessage();
      ViewController::errorView($arrayOfErrors);
    }
  }

  # ------- COMENTADO PARA SER BORRADO --------------

  // public function selectMovie($selectedId){
  //   try {
  //     $cinemas = $this->DAOCinema->getActiveCinemas();  
  //     $movies=$this->DAOMovie->getAll();
  //     $listAdminMovies = null;
  //     foreach($movies as $movie){
  //       if($movie->getMovieId() == $selectedId){
  //         $listAdminMovies = $movie;
  //       }
  //     } 
  //     ViewController::navView($genreList=null,$moviesYearList=null,null,null);
  //     include(VIEWS_PATH.'listMoviesAdmin.php');
  //   } 

  //   catch (Exception $ex){
  //     $arrayOfErrors [] = $ex->getMessage();
  //     ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
  //     ViewController::homeView($movies,$page,$title);
  //   }
  // }
  
  // public function selectRoom($selectedCinemaId, $selectedMovieId){
  //   try {
  //     $cinemas = $this->DAOCinema->getActiveCinemas();  
  //     $movies=$this->DAOMovie->getAll();
  //     $currentCinema = null;
  //     $currentMovie = null;
  //     foreach($cinemas as $cinema){
  //       if($cinema->getId() == $selectedCinemaId){
  //         $currentCinema = $cinema;
  //       }
  //     }
  //     foreach($movies as $movie){
  //       if($movie->getMovieID() == $selectedMovieId){
  //         $currentMovie = $movie;
  //       }
  //     }
  //     ViewController::navView($genreList=null,$moviesYearList=null,null,null);
  //     include(VIEWS_PATH.'listRoomsAdmin.php');
  //   } 

  //   catch (Exception $ex){
  //     $arrayOfErrors [] = $ex->getMessage();
  //     ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
  //     ViewController::homeView($movies,$page,$title);
  //   }
  // }
  
}
?>