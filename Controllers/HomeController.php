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
                $movieIdsShow = new DAOShow();
                $shows = array();
                
                //Get de la cartelera, trae los shows isActive = 1
                $movieIds = $movieIdsShow->getBillBoard();
                if (is_array($movieIds)){
                    $shows = $movieIds;
                }else{
                    $shows[0] = $movieIds;
                }

                $genreList = $this->DAOGenre->getGenresListFromShows();
                $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
                
                ViewController::navView($genreList,$moviesYearList,null,null); 
                
                $movies = array();
                #pasar luego a una QUERY del DAO
                foreach ($movieIds as $key => $value) {
                    array_push($movies, $this->DAOMovie->getById($value['idMovie']));
                }
                $page = $message;
                $title = "LATEST MOVIES IN PROJECTION";
                
                ViewController::homeView($movies,$page,$title);
            }catch(Exception $ex)
            {
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                ViewController::homeView($movies,$page,$title);
            }
        }        
    }
?>