<?php
    namespace Controllers;
    use DAO\PDO\PDOMovie as DAOMovie;
    use DAO\PDO\PDOShow as PDOShow;
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
                $auxShow = new PDOShow();
                $shows = array();
                $aux = $auxShow->getAll();
                if (is_array($aux)){
                    $shows = $aux;
                }else{
                    $shows[0] = $aux;
                }


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