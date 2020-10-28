<?php
    namespace Controllers;
    use DAO\DAOMovie as DAOMovie;
    use DAO\DAOGenre as DAOGenre;
    
    class HomeController
    {
        private $daoMovie;
        
        public function __construct(){
            $this->DAOMovie = new DAOMovie();
            $this->DAOGenre = new DAOGenre();
        }
    
        public function Index($message = 1)
        {

            $genreList = $this->DAOGenre->getGenresList();
            $moviesYearList = $this->DAOMovie->getArrayOfYears();

            ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION

            $movies = $this->DAOMovie->getAll();
            $page = $message;
            $title = "LATEST MOVIES";
            
            ViewController::homeView($movies,$page,$title);
        }        
    }
?>