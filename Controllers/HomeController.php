<?php
    namespace Controllers;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    use DB\PDO\DAOGenre as DAOGenre;
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
                $auxShow = new DAOShow();
                $shows = array();
                $aux = $auxShow->getAll();
                if (is_array($aux)){
                    $shows = $aux;
                }else{
                    $shows[0] = $aux;
                }



                $genreList = $this->DAOGenre->getGenresListFromShows();
                $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
                
                echo"<pre>";
                var_dump($genreList);
                echo"</pre>";
                echo"<pre>";
                var_dump($moviesYearList);
                echo"</pre>";

         ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION

                $movies = array();
                #pasar luego a una QUERY del DAO
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