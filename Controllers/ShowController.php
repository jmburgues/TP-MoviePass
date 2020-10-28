<?php
    namespace Controllers;

    use DAO\DAOMovie as DAOMovie;
    use DAO\PDO\PDORoom as DAORoom;
    use DAO\PDO\PDOMovie as PDOMovie;
    use DAO\PDO\PDOShow as DAOShow;
    use Models\Show as Show;

    class ShowController{
        private $DAOMovie;
        private $DAORoom;
        private $DAOShow;
        private $PDOMovie;


        public function __construct(){
            $this->DAOMovie = new DAOMovie();   
            $this->DAORoom = new DAORoom(); 
            $this->DAOShow = new DAOShow();    
            $this->PDOMovie = new PDOMovie();        
        }
        
    public function showShows(){
        $shows = array();
        $aux =$this->DAOShow->getAll();
        if (is_array($aux)){
            $shows = $aux;
        }else{
            $shows[0] = $aux;
        }

      //  include VIEWS_PATH.'showAddView.php';
        include VIEWS_PATH.'adminShows.php';
    }
    
    public function addShowView(){
        $shows=$this->DAOShow->getAll();
        include VIEWS_PATH.'adminShows.php';
        include VIEWS_PATH.'showAddView.php';
    }

    public function addShow($date, $start, $end, $spectators){
        $shows=$this->DAOShow->getAll();
        $movies=$this->DAOMovie->GetAll();
        $moviesDB = $this->PDOMovie->getAll();
       // print_r($moviesDB);
        include VIEWS_PATH.'listMoviesAdmin.php';
    }

    public function addCurrentShow( $date, $start, $end, $spectators, $selectedMovieId, $roomId ){
        $show = new Show();
        $show->setDate($date);
        $show->setStart($start);
        $show->setEnd($end);
        $show->setSpectators($spectators);
        $show->setIdMovie($selectedMovieId);
        $show->setIdRoom($roomId);
        echo "<pre>";
        print_r($show);
        echo $show->getIdMovie();
        echo "</pre>";

        $rooms = $this->DAORoom->getAll(); 
        $movies=$this->DAOMovie->GetAll();
        
        foreach($rooms as $room){
            if($room->getRoomID() == $roomId){
                $selectedRoom = $room;
            }
        } 

        foreach($movies as $movie){
            if($movie->getMovieId() == $selectedMovieId){
                $selectedMovie = $movie;
            }
        } 

        $shows=$this->DAOShow->getAll();
        //COMPROBACION DE LOS 15 MINUTOS ETC ETC

        $this->DAOShow->add($show);
        //$movies->setIdShow();


        include VIEWS_PATH.'adminShows.php';
    }

    public function selectMovie($date, $start, $end, $spectators, $movieId){
       // echo $movieId;
        $movies=$this->DAOMovie->GetAll();
        foreach($movies as $movie){
            if($movie->getMovieId() == $movieId){
                $selectedMovie = $movie;
            }
        } 
        $rooms = $this->DAORoom->getAll(); 
      //  print_r($rooms);

        include VIEWS_PATH.'listCinemasAdmin.php';
    }
}

    ?>