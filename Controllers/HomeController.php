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

                $movies = array();
                #pasar luego a una QUERY del pdo
                $aux = array();
                foreach ($shows as $show) {
                    if(!(in_array($show->getIdMovie(),$aux))){
                        array_push($aux,$show->getIdMovie());
                        array_push($movies, $this->DAOMovie->getById($show->getIdMovie()));
                    }
                }
                $page = $message;
                $title = "LATEST MOVIES IN PROJECTION";
                
                ViewController::homeView($movies,$page,$title);
            }catch(Exception $ex)
            {
                throw $ex;
            }
        }        
    }
?>