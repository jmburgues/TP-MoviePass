<?php
    namespace Controllers;
    use DAO\DAOMovie as DAOMovie;
    use Modes\Cinema as Cinema;
    
    class HomeController
    {
        private $daoMovie;
        
        public function __construct(){
            $this->daoMovie = new DAOMovie();
        }
    
        public function Index($message = 1)
        {
            $movies = $this->daoMovie->getAll();
            $page = $message;
            $title = "LATEST MOVIES";
            
            ViewController::homeView($movies,$page,$title);
        }        
    }
?>