<?php
    namespace Controllers;

    use \DateTime as DateTime;
    use \DateInterval as DateInterval;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAORoom as DAORoom;
    use DB\PDO\DAOShow as DAOShow;
    use DB\PDO\DAOCinema as DAOCinema;
    use DB\PDO\DAOGenre as DAOGenre;
    use Models\Show as Show;    

    class ShowController{
        private $DAOMovie;
        private $DAORoom;
        private $DAOShow;
        private $DAOGenre;


        public function __construct(){
            $this->DAOMovie = new DAOMovie();   
            $this->DAORoom = new DAORoom(); 
            $this->DAOShow = new DAOShow();    
            $this->DAOMovie = new DAOMovie();     
            $this->DAOCinema = new DAOCinema();    
            $this->DAOGenre = new DAOGenre();    
        }
        
    //Redirige a vista adminShows donde se listan las funciones y el addShow
    public function showShows(){
        $shows = array();
        $aux =$this->DAOShow->getAll();
        if (is_array($aux)){
            $shows = $aux;
        }else{
            $shows[0] = $aux;
        }

        $auxMovie = new DAOMovie();
        $auxCinema = new DAOCinema();
        $auxRoom = new DAORoom();
        $auxCinemaName = new DAOShow();



      //  include VIEWS_PATH.'showAddView.php';
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'adminShows.php';
    }

    //Crea un nuevo show
    public function addShow($date, $start){
        $moviesDB = $this->DAOMovie->getAll();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'listMoviesAdmin.php';
    }

    public function addCurrentShow($date, $start, $end, $selectedMovieId, $roomId){
        $newShow = new Show();
        $newShow->setDate($date);
        $newShow->setStart($start);
        $newShow->setEnd($end);
        $newShow->setIdMovie($selectedMovieId);
        $newShow->setIdRoom($roomId);
        $newShow->setSpectators(0);
        
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
        
        $flag = 0; 
        
        $lookingForShows = array();
        $aux =$this->DAOShow->getAll();
        if (is_array($aux)){
            $lookingForShows = $aux;
        }else{
            $lookingForShows[0] = $aux;
        }

        foreach ($lookingForShows as $show) {
          //  echo "Entra";
            if ($newShow->getDate() == $date) {
                //echo $newShow->getStart();
                //echo $date;
                if ($show->getIdRoom() == $roomId) {
                  //  echo "id";
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
                $this->DAOShow->add($newShow);
            } else {
                $message = "Horario ocupado";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }        
        $shows=$this->DAOShow->getAll();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        $this->showShows();
    }

    function getMoviesByDate($year){ // returns an array of movies (Object) created on a given date (1st revision)
    
        $genreList = $this->DAOGenre->getGenresListFromShows();
        $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
        ViewController::navView($genreList,$moviesYearList,null); 


        $movies = $this->DAOMovie->getByYearFromShows($year);
    
        ViewController::homeView($movies,1,"Year: ".$year);
    }

    //Método luego de seleccionar la película para el show
    //Muestra la información hasta el momento de la función y elige la sala
    public function selectMovie($date, $start, $movieId){
        $dateTime = new DateTime();
        $movies=$this->DAOMovie->GetAll();
        //se toma la película y se calcula la duración para devolver el final de la función 
        foreach($movies as $movie){
            if($movie->getMovieId() == $movieId){
        
                /*
                *  HACERR UNA GetMovieByID para traer la pelicula buscada en lugar de un FOREACH
                */ 

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

    function listByGenre($genreId){
        $genreList = $this->DAOGenre->getGenresListFromShows(); 
        $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
        ViewController::navView($genreList,$moviesYearList,null); 
    
        $movies = $this->DAOMovie->getMoviesByGenre($genreId);
        $genreName = $this->DAOGenre->getById($genreId)->getName();


        ViewController::homeView($movies,1,"Genre: ".$genreName);
    }

    //Redirige a la vista para modificar el show seleccionado con todos sus datos
    public function modifyShowView($showID){
        $currentShow = $this->DAOShow->getById($showID);
        $auxRoom = $this->DAORoom->getById($currentShow->getIdRoom());
        $auxCinema = $this->DAOCinema->getById($auxRoom->getIDCinema());
        $rooms = $this->DAORoom->getActiveRoomsByCinema($auxCinema->getId());
        $movies = $this->DAOMovie->getAll();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'show-modify.php';
    }

    public function modifyShow($idShow, $idRoom, $idMovie, $spectators, $active, $date, $start){
        $movie = $this->DAOMovie->getById($idMovie);
        $auxDate = $start;
        $dateToInsert = new DateTime($auxDate.'M');

        $auxEnd = ($movie->getDuration() +15 );
        
        $interval = new DateInterval('PT'.$auxEnd.'M');         

        $dateToInsertEnd = new DateTime($auxDate);
        $dateToInsertEnd->add($interval);
    
        $dateToInsert = $dateToInsert->format('Y-m-d H:i:s');
        $dateToInsertEnd = $dateToInsertEnd->format('Y-m-d H:i:s');


        $showsList = $this->DAOShow->getActiveShows();
        $modifyShow = new Show($date, $dateToInsert, $dateToInsertEnd, $idRoom, $idMovie, $spectators, $active, $idShow);
    // var_dump($modifyShow);
        $this->DAOShow->modify($modifyShow);

        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'adminShows.php';
    }
}



    ?>