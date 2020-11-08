<?php
    namespace Controllers;

    use \DateTime as DateTime;
    use \DateInterval as DateInterval;
    use \DateTimeZone as DateTimeZone;
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
        #$this->validateActiveShows();
        #Esto es para que no se puedan agregar shows el mismo dia que se esta
        $oneDayAhead = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
        $oneDayAhead->add(new DateInterval('P1D'));
        $shows = $this->DAOShow->getAll();
        $activeShows = $this->DAOShow->getActiveShows();
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
        $newShow = new Show($date,$start, $end,$this->DAORoom->getById($roomId), $this->DAOMovie->getById($selectedMovieId),0);
        
        $startAux = new DateTime ($start);
        $endAux = new DateTime ($end);

        #$rooms = $this->DAORoom->getAll(); 
        #$movies=$this->DAOMovie->getAll();
        
        $flag = 0; 
        
        $lookingForShows = $this->DAOShow->getActiveShows();

        foreach ($lookingForShows as $show) {
          //  echo "Entra";
            if ($newShow->getDate() == $show->getDate()) {

                if ($show->getRoom()->getRoomID() == $roomId) {
                  //  echo "id";
                    $extremoInferior = new DateTime($show->getDate().' '.$show->getStart());
                    if ($startAux->format('Y-m-d') == $endAux->format('Y-m-d')){
                      $extremoSuperior = new DateTime($show->getDate().' '.$show->getEnd());
                    }else{
                      $extremoSuperior = new DateTime($endAux->format('Y-m-d').' '.$show->getEnd());
                    }
                    $inicio = new DateTime($start);
                    $fin = new DateTime($end);
                    if (!($inicio>=$extremoSuperior) && !($fin<=$extremoInferior)) {
                        $flag = 1;
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
        #Validacion de que en un dia que ya se esta dando una pelicula en una funcion solo puede darse en ese mismo cine y sala
        $aux = $this->DAOShow->getByDateAndMovieId($date, $movieId);
        if ($aux == null){
          $rooms = $this->DAORoom->getAll(); 
        }else{
          #Se que no esta del todo bien pero hay un error que no estaria encontrando
          $rooms = array($aux[0]->getRoom());
        }
        #==============================#
        $selectedMovie=$this->DAOMovie->getById($movieId);
        //se toma la película y se calcula la duración para devolver el final de la función + los 15 minutos 
        $auxDate = $start;
        $dateToInsert = new DateTime($auxDate.'M');

        $auxEnd = ($selectedMovie->getDuration() +15 );
        
        $interval = new DateInterval('PT'.$auxEnd.'M');         

        $dateToInsertEnd = new DateTime($auxDate);
        $dateToInsertEnd->add($interval);
    
        $dateToInsert = $dateToInsert->format('Y-m-d H:i:s');
        $dateToInsertEnd = $dateToInsertEnd->format('Y-m-d H:i:s');

        echo '<pre>';
        print_r($dateToInsert);
        echo '</pre>';
        echo '<pre>';
        print_r($dateToInsertEnd);
        echo '</pre>';
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
        $auxRoom = $this->DAORoom->getById($currentShow->getRoom()->getRoomID());
        $auxCinema = $this->DAOCinema->getById($auxRoom->getCinema()->getId());
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
        $this->showShows();
    }


    public function validateActiveShows(){
      $CurrentActiveShows = $this->DAOShow->getActiveShows();
      
      $dateTimeNow = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
        foreach ($CurrentActiveShows as $CurrentActiveShow){
          $dateTimeShow = new DateTime($CurrentActiveShow->getDate().' '.$CurrentActiveShow->getStart());
          if ($CurrentActiveShow->getSpectators() == $CurrentActiveShow->getRoom()->getCapacity()){
            $this->DAOShow->removeShowFromActive($CurrentActiveShow->getIdShow());
          }
          if ($dateTimeShow < $dateTimeNow){
            $this->DAOShow->removeShowFromActive($CurrentActiveShow->getIdShow());
        }
      }
    }

    public function removeShow ($idShow){
      #Podria agregar alguna comprobacion ? yo creo que no ya se hace en el view.
      $this->DAOShow->removeShowFromActive($idShow);
      $this->showShows();
    }

  }
?>