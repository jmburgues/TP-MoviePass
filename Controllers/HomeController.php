<?php
    namespace Controllers;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    use DB\PDO\DAOGenre as DAOGenre;
    use PDOException;

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

                $genreList = $this->DAOGenre->getGenresListFromShows();
                $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
                
                $DAOShow = new DAOShow();
                $shows = array();     
                
                $billboardMovieIDs = $DAOShow->getBillBoard(); //Get de la cartelera, trae los shows isActive = 1

                if (is_array($billboardMovieIDs)){
                    $shows = $billboardMovieIDs;
                }else{
                    $shows[0] = $billboardMovieIDs;
                }

                $movies = array();
                #pasar luego a una QUERY del DAO
                foreach ($billboardMovieIDs as $key => $value) {
                    array_push($movies, $this->DAOMovie->getById($value['idMovie']));
                }
                $page = $message;
                $title = "LATEST MOVIES";
                
                ViewController::navView($genreList,$moviesYearList,null,null); 
                ViewController::homeView($movies,$page,$title);
                
            
            }catch(PDOException $ex)
            {
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::errorView($arrayOfErrors);
            }
        }        
    }
?>