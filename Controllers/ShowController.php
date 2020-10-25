<?php
    namespace Controllers;

    use DAO\DAOMovie as DAOMovie;
    use DAO\DAORoom as DAORoom;
    use DAO\DAOShow as DAOShow;
    use Models\Show as Show;

    class ShowController{
        private $DAOMovie;
        private $DAORoom;
        private $DAOShow;


        public function __construct(){
            $this->DAOMovie = new DAOMovie();   
            $this->DAORoom = new DAORoom(); 
            $this->DAOShow = new DAOShow();        
        }
        
    public function showShows(){
        $shows=$this->DAOShow->getAll();
        include VIEWS_PATH.'adminShows.php';
    }
    
    public function addShowView(){
        $shows=$this->DAOShow->getAll();
        include VIEWS_PATH.'adminShows.php';
        include VIEWS_PATH.'showAddView.php';
    }

    public function addShow($date, $time, $spectators){
        $shows=$this->DAOShow->getAll();
        $movies=$this->DAOMovie->GetAll();
        include VIEWS_PATH.'listMoviesAdmin.php';
    }

    public function addCurrentShow( $date, $time, $spectators, $selectedMovie, $roomId ){
        $show = new Show();
        $show->setDate($date);
        $show->setHour($time);
        $show->setIdRoom($roomId);
        $show->setSpectators($spectators);
        $rooms = $this->DAORoom->getAll(); 
        foreach($rooms as $room){
            if($room->getRoomID() == $roomId){
                $selectedRoom = $room;
            }
        } 

        $shows=$this->DAOShow->getAll();
        //COMPROBACION DE LOS 15 MINUTOS ETC ETC
        $this->DAOShow->add($show);
        $movies=$this->DAOMovie->GetAll();
        //$movies->setIdShow();


        include VIEWS_PATH.'adminShows.php';
    }

    public function selectMovie($date, $time, $spectators, $selectedId){
        $movies=$this->DAOMovie->GetAll();
        foreach($movies as $movie){
            if($movie->getMovieId() == $selectedId){
                $selectedMovie = $movie;
            }
        } 
        $rooms = $this->DAORoom->getAll(); 
        include VIEWS_PATH.'listCinemasAdmin.php';
    }
}

    ?>