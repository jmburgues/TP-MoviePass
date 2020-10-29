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
        $this->showShows();
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
        
        $lookingForShows=$this->DAOShow->getAll();
        $flag = 0; 
        foreach ($lookingForShows as $show) {
            if ($show->getDate() == $date) {
                if ($show->getIdRoom() == $roomId) {
                    $extremoInferior = new DateTime($show->getStart());
                    $extremoSuperior = new DateTime($show->getEnd());
                    $inicio = new DateTime($start);
                    $fin = new DateTime($end);

                    if ($inicio>=$extremoInferior && $inicio<=$extremoSuperior) {
                        $flag = 1;
                    } else {
                        if ($fin>=$extremoInferior && $fin<=$extremoSuperior) {
                            $flag = 1;
                        }
                    }
                }
            }
        }    
            if ($flag != 1) {
                $this->DAOShow->add($show);
            } else {
                $message = "Horario ocupado";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        

        
        $shows=$this->DAOShow->getAll();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        $this->showShows();
    }

    public function selectMovie($date, $start, $spectators, $movieId){
        $dateTime = new DateTime();
        $movies=$this->DAOMovie->GetAll();
        
        foreach($movies as $movie){
            if($movie->getMovieId() == $movieId){
        
                $auxDate = $start;
                $dateToInsert = new DateTime($auxDate.'M');

                $auxEnd = ($movie->getDuration() +15 );
                
                $interval = new DateInterval('PT'.$auxEnd.'M');         

                $dateToInsertEnd = new DateTime($auxDate);
                $dateToInsertEnd->add($interval);
            
                $dateToInsert = $dateToInsert->format('Y-m-d H:i:s');
                $dateToInsertEnd = $dateToInsertEnd->format('Y-m-d  H:i:s');

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