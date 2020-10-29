<?php
    namespace Controllers;

    use \DateTime as DateTime;
    use \DateInterval as DateInterval;
    use DAO\PDO\PDOMovie as DAOMovie;
    use DAO\PDO\PDORoom as DAORoom;
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
            $this->PDOMovie = new DAOMovie();        
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
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'adminShows.php';
    }
    
    public function addShowView(){
        $shows=$this->DAOShow->getAll();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'adminShows.php';
        include VIEWS_PATH.'showAddView.php';
    }

    public function addShow($date, $start, $spectators){
        $shows=$this->DAOShow->getAll();
        $movies=$this->DAOMovie->GetAll();
        $moviesDB = $this->PDOMovie->getAll();
       
        ViewController::navView($genreList=null,$moviesYearList=null,null);
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

        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'adminShows.php';
    }

    public function selectMovie($date, $start, $spectators, $movieId){
        $dateTime = new DateTime();
        $movies=$this->DAOMovie->GetAll();
        echo "<br> start: "; 
        echo $start;
        foreach($movies as $movie){
            if($movie->getMovieId() == $movieId){
                /*              $end = $dateTime->add($start, $movie->getDuration());
                $end = $dateTime->add($end, DateInteval());
                */
                $auxDate = $start;
                $dateToInsert = new DateTime($auxDate.'M');
                
                echo "<br> auxDate: ";
                echo $auxDate;
                
                echo "<br> duration: ";
                echo $movie->getDuration();
                
                $auxEnd = ($movie->getDuration() +15 );
                
                echo "<br> aux: ";
                echo $auxEnd;
                

                $interval = new DateInterval('PT'.$auxEnd.'M');
                
                

                $dateToInsertEnd = new DateTime($auxDate);
                $dateToInsertEnd->add($interval);
                
                echo "<br> intervalo: ";
                echo "<pre>";
                print_r($interval);
                echo "</pre>";


                //$showList = $this->daoShow->getByIdTheaterDate($theaterId,$date);

                $selectedMovie = $movie;
            }
        } 
        $rooms = $this->DAORoom->getAll(); 
      //  print_r($rooms);

        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'listCinemasAdmin.php';
    }
}

    ?>