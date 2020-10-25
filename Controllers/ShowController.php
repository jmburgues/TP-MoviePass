<?php
    namespace Controllers;

    use DAO\DAOMovie as DAOMovie;

    class ShowController{
        private $DAOMovie;


        public function __construct(){
            $this->DAOMovie = new DAOMovie();        
        }
        
    public function showShows(){
        
        include VIEWS_PATH.'adminShows.php';
    }
    
    public function addShowView(){
        include VIEWS_PATH.'adminShows.php';
        include VIEWS_PATH.'showAddView.php';
    }

    public function addShow($date, $time){
        echo $date, $time;
        $movies=$this->DAOMovie->GetAll();

        include VIEWS_PATH.'listMoviesAdmin.php';
    }

    public function selectMovie($selectedId){
        $movies=$this->DAOMovie->GetAll();
        foreach($movies as $movie){
            if($movie->getMovieId() == $selectedId){
                $movieTitle = $movie;
            }
        } 
        print_r($movieTitle);
        include VIEWS_PATH.'listCinemasAdmin.php';
    }
}

    ?>