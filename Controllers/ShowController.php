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
    use PDOException;

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
    public function showShows($message = ''){
      if(AuthController::validate('admin')){
        try{
          $this->validateActiveShows();
          #Esto es para que no se puedan agregar shows el mismo dia que se esta
          $today = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
          $oneDayAhead = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
          $oneDayAhead->add(new DateInterval('P1D'));
          $shows = $this->DAOShow->getAll();
          $activeShows = $this->DAOShow->getActiveShows();
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          include VIEWS_PATH.'adminShows.php';
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    //Crea un nuevo show
    public function addShow($date, $start){
      if(AuthController::validate('admin')){
        try{
          $moviesDB = $this->DAOMovie->getAll();
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          include VIEWS_PATH.'listMoviesAdmin.php';
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    public function manageShows($date, $start, $end, $selectedMovieId, $roomId){
      if(AuthController::validate('admin')){
        try{
          $newShow = new Show($date,$start, $end,$this->DAORoom->getById($roomId), $this->DAOMovie->getById($selectedMovieId),0);    
          $startAux = new DateTime ($start);
          $endAux = new DateTime ($end);

          $flag = 0; 
          
          $lookingForShows = $this->DAOShow->getActiveShows();

          /*
          **  ESTO ESTA MAL, CAMBIAR EL FOREACH POR UN QUERY AL PDO.
          */

          foreach ($lookingForShows as $show) {
              if ($newShow->getDate() == $show->getDate()) {
                  if ($show->getRoom()->getId() == $roomId) {
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
              }        
          $shows=$this->DAOShow->getAll();
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          $this->showShows();

        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    function getMoviesByDate($year){ // returns an array of movies (Object) created on a given date (1st revision)
      try {
        $genreList = $this->DAOGenre->getGenresListFromShows();
        $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
        $movies = $this->DAOMovie->getByYearFromShows($year);
        ViewController::navView($genreList,$moviesYearList,null,null); 
        ViewController::homeView($movies,1,"Year: ".$year);
        
      } 
      catch (PDOException $ex){
        $arrayOfErrors [] = $ex->getMessage();
        ViewController::errorView($arrayOfErrors);
      }      
    }

    //Método luego de seleccionar la película para el show
    //Muestra la información hasta el momento de la función y elige la sala
    public function selectMovie($date, $start, $movieId){
      if(AuthController::validate('admin')){
        try{
          #Validacion de que en un dia que ya se esta dando una pelicula en una funcion solo puede darse en ese mismo cine y sala
          $aux = $this->DAOShow->getByDateAndMovieId($date, $movieId);
          if ($aux == null){
            $rooms = $this->DAORoom->getActiveRooms(); 
          }else{
            #Se que no esta del todo bien pero hay un error que no estaria encontrando
            $rooms = array($aux[0]->getRoom());
          }
          #==============================#
          $selectedMovie=$this->DAOMovie->getById($movieId);
          //se toma la película y se calcula la duración para devolver el final de la función + los 15 minutos 
          $dateToInsert = new DateTime($date." ".$start.'M');

          $dateToInsert = $dateToInsert->format('Y-m-d H:i:s');
          $dateToInsertEnd = $this->addInterval($date." ".$start, ($selectedMovie->getDuration() +15 ));
          $ends = substr($dateToInsertEnd, -9, -3);
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          include VIEWS_PATH.'listCinemasAdmin.php';
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    function listByGenre($genreId){
      try{
        $genreList = $this->DAOGenre->getGenresListFromShows(); 
        $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
        ViewController::navView($genreList,$moviesYearList,null,null); 
    
        $movies = $this->DAOMovie->getMoviesByGenre($genreId);
        $genreName = $this->DAOGenre->getById($genreId)->getName();


        ViewController::homeView($movies,1,"Genre: ".$genreName);
      } 
      catch (PDOException $ex){
        $arrayOfErrors [] = $ex->getMessage();
        ViewController::errorView($arrayOfErrors);
      }
    }

    //Redirige a la vista para modificar el show seleccionado con todos sus datos
    public function modifyShowView($showID){
      if(AuthController::validate('admin')){
        try {
          $oneDayAhead = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
          $oneDayAhead->add(new DateInterval('P1D'));
          $currentShow = $this->DAOShow->getById($showID);
          $rooms = $this->DAORoom->getActiveRoomsByCinema($currentShow->getRoom()->getCinema()->getId());
          $movies = $this->DAOMovie->getAll();
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          include VIEWS_PATH.'show-modify.php';
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    public function modifyShow($idShow, $idRoom, $idMovie, $date, $start){
      if(AuthController::validate('admin')){
        try{
          //Calculo el nuevo fin de la funcion
          $movie = $this->DAOMovie->getById($idMovie);
          $dateToInsert = new DateTime($date." ".$start.'M');
          $dateToInsert = $dateToInsert->format('Y-m-d H:i:s');
          $dateToInsertEnd = $this->addInterval($date." ".$start, ($movie->getDuration() +15 ));
          #----------------------------------------#
          //Creo el objeto show a modificar y por verificar
          $modifyShow = new Show($date, $dateToInsert, $dateToInsertEnd, $this->DAORoom->getByID($idRoom), $this->DAOMovie->getByID($idMovie), 0, 1, $idShow);
          #----------------------------------------#
          //realizo las validaciones
          $msg;
          #Validacion de fecha y hora
          $startAux = new DateTime ($date." ".$start);
          $endAux = new DateTime ($dateToInsertEnd);
          $showsList = $this->DAOShow->getActiveShows();
          foreach ($showsList as $show) {
            if ($modifyShow->getDate() == $show->getDate()) {
              if ($show->getRoom()->getId() == $idRoom) {
                $extremoInferior = new DateTime($show->getDate().' '.$show->getStart());
                if ($startAux->format('Y-m-d') == $endAux->format('Y-m-d')){
                  $extremoSuperior = new DateTime($show->getDate().' '.$show->getEnd());
                }else{
                  $extremoSuperior = new DateTime($endAux->format('Y-m-d').' '.$show->getEnd());
                }
                if (!($startAux>=$extremoSuperior) && !($endAux<=$extremoInferior)) {
                  $msg = 'Horario ocupado';
                }
              }
            }
          }
          
          $aux = $this->DAOShow->getByDateAndMovieId($date, $idMovie);
          if ($aux != null){
            if (($aux[0]->getRoom()->getId() != $idRoom) && ($aux[0]->getIdShow() != $idShow)){
              $msg = 'Esa pelicula se esta trasmitiendo en otra sala o cine este dia';
            }
          }
            
          if (isset($msg)){
            throw new Exception($msg);
          }else{
            $this->DAOShow->modify($modifyShow);
          }
          
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          $this->showShows();
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
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
      if(AuthController::validate('admin')){
        #Podria agregar alguna comprobacion ? yo creo que no ya se hace en el view.
        try {
          $this->DAOShow->removeShowFromActive($idShow);
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    public function addInterval ($start ,$duration){
      $interval = new DateInterval('PT'.$duration.'M');         
      $dateToInsertEnd = new DateTime($start);
      $dateToInsertEnd->add($interval);
      return $dateToInsertEnd->format('Y-m-d H:i:s');
    }
  }
?>
