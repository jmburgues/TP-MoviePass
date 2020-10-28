<?php
    namespace Controllers;
    use DAO\PDO\PDOMovie as DAOMovie;
    use DAO\PDO\PDOGenre as DAOGenre;
use Exception;

class HomeController
    {
        private $DAOMovie;
        private $DAOGenre;

        public function __construct(){
            $this->DAOMovie = new DAOMovie();
            $this->DAOGenre = new DAOGenre();
        }
    
        public function Index($message = 1)
        {
            try{
                $genreList = $this->DAOGenre->getAll();
                $moviesYearList = $this->DAOMovie->getArrayOfYears();
                
                ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION

                $movies = $this->DAOMovie->getAll();
                $page = $message;
                $title = "LATEST MOVIES";
                
                ViewController::homeView($movies,$page,$title);
            }catch(Exception $ex)
            {
                throw $ex;
            }
        }        
    }
?>