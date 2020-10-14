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
    
        public function Index($message = "")
        {
            $movies = $this->daoMovie->getAll();
            require_once(VIEWS_PATH."home.php");
        }        
    }
?>