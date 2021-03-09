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
    use DB\PDO\DAOTicket as DAOTicket;
    use Models\Show as Show;    
    use PDOException;

    class ShowController{
        private $DAOMovie;
        private $DAORoom;
        private $DAOShow;
        private $DAOGenre;
        private $DAOTicket;

        public function __construct(){
            $this->DAOMovie = new DAOMovie();   
            $this->DAORoom = new DAORoom(); 
            $this->DAOShow = new DAOShow();    
            $this->DAOMovie = new DAOMovie();     
            $this->DAOCinema = new DAOCinema();    
            $this->DAOGenre = new DAOGenre();   
            $this->DAOTicket = new DAOTicket();    
        }
        
    //Redirige a vista manageShows donde se listan las funciones y el addShow
    public function manageShows($message = ''){
      if(AuthController::validate('admin')){
        try{
          $this->validateActiveShows();
          #Esto es para que no se puedan agregar shows el mismo dia que se esta
          $today = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
          $oneDayAhead = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
          $oneDayAhead->add(new DateInterval('P1D'));
          $shows = $this->DAOShow->getActiveShows();
          $cinemas = $this->DAOCinema->getActiveCinemas();
          $rooms = $this->DAORoom->getActiveRooms();
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          include VIEWS_PATH.'manageShows.php';
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
          include VIEWS_PATH.'listMoviesForShows.php';
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    public function createNewShow($date, $movieStartingDateTime, $movieEndingDateTime, $selectedMovieId, $roomId){
      if(AuthController::validate('admin')){
        try{
          $newShow = new Show($date,$movieStartingDateTime, $movieEndingDateTime,$this->DAORoom->getById($roomId), $this->DAOMovie->getById($selectedMovieId),0);    
          $startAux = new DateTime ($movieStartingDateTime);
          $endAux = new DateTime ($movieEndingDateTime);

          // $flag = 0; 
          
          // $lookingForShows = $this->DAOShow->getActiveShows();

          // /*
          // **  ESTO ESTA MAL, CAMBIAR EL FOREACH POR UN QUERY AL PDO.
          // */

          // foreach ($lookingForShows as $show) {
          //     if ($newShow->getDate() == $show->getDate()) {
          //         if ($show->getRoom()->getId() == $roomId) {
          //             $extremoInferior = new DateTime($show->getDate().' '.$show->getStart());
          //             if ($startAux->format('Y-m-d') == $endAux->format('Y-m-d')){
          //               $extremoSuperior = new DateTime($show->getDate().' '.$show->getEnd());
          //             }else{
          //               $extremoSuperior = new DateTime($endAux->format('Y-m-d').' '.$show->getEnd());
          //             }
          //             $inicio = new DateTime($start);
          //             $fin = new DateTime($end);
          //             if (!($inicio>=$extremoSuperior) && !($fin<=$extremoInferior)) {
          //                 $flag = 1;
          //             }
          //         }
          //     }
          // }    
          //     if ($flag != 1) {
                  $this->DAOShow->add($newShow);
              // } else {
              //     $message = "Horario ocupado";
              // }        
          // $shows=$this->DAOShow->getAll();
          // ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          $this->manageShows();

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

// Metodo llamado para elegir las salas disponibles al crear un nuevo show.
    public function selectRoomForShow($movieStartingDate, $movieStartingHour, $movieId){
      if(AuthController::validate('admin')){
        try{

          $selectedMovie=$this->DAOMovie->getById($movieId);
          $movieStartingDateTimeObject = new DateTime($movieStartingDate." ".$movieStartingHour);
          $movieStartingDateTime = $movieStartingDateTimeObject->format('Y-m-d H:i:s');
          $movieEndingDateTime = $this->addInterval($movieStartingDate." ".$movieStartingHour, ($selectedMovie->getDuration() +15 ));
          $ends = substr($movieEndingDateTime, -9, -3);
          $end = $movieEndingDateTime;
          $cinemas = $this->DAOCinema->getActiveCinemas();

          $message = null;
          
    // FUNCIONES DE FILTRADO DE LAS SALAS QUE SE VAN A MOSTRAR //

        /*
          getOpenRooms: 
            Filtro las salas activas, de los cines activos que se encuentren abiertos a la hora de 
            inicio de la pelicula y que permanezcan abiertos hasta que la pelicula termine.
        */
          $rooms = $this->getOpenRooms($movieStartingDate,$movieStartingDateTimeObject,$movieEndingDateTime);
  
          if($rooms){
            //valido que exista una franja horaria disponible para proyectar la pelicula
            $rooms = $this->getRoomsWithAviableTime($rooms,$movieStartingDate,$movieStartingHour,$ends);
            
            if($rooms){
               //valido que la pelicula no se este proyectando en otra sala el mismo dia.
              $rooms = $this->sameDayRestriction($rooms,$movieStartingDate,$movieId);
            }
            else{
              $message = "All rooms are full at given time.";
            }
          } 
          else{
            $message = "No open cinemas.";
          } 

          //se toma la película y se calcula la duración para devolver el final de la función + los 15 minutos 

          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          include VIEWS_PATH.'selectRoomForShow.php';          
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }
    
    public function listByGenre($genreId){
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
            $tickets = $this->DAOTicket->getTicketsByShow($showID);
            if ($tickets) {
                $msg = 'Tickets for that show have already been sold';
                $this->manageShows($msg);
            } else {
                $oneDayAhead = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
                $oneDayAhead->add(new DateInterval('P1D'));
                $currentShow = $this->DAOShow->getById($showID);
                $rooms = $this->DAORoom->getActiveRoomsByCinema($currentShow->getRoom()->getCinema()->getId());
                $movies = $this->DAOMovie->getAll();
                ViewController::navView($genreList=null, $moviesYearList=null, null, null);
                include VIEWS_PATH.'show-modify.php';
            }
        }catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    public function modifyShow($idShow, $idRoom, $idMovie, $date, $start){
      if(AuthController::validate('admin')){
        try{
          
          $tickets = $this->DAOTicket->getTicketsByShow($idShow); 
          if($tickets){
            $msg = 'Tickets for that show have already been sold';
          }else{

          //Calculo el nuevo fin de la funcion
              $movie = $this->DAOMovie->getById($idMovie);
              $dateToInsert = new DateTime($date." ".$start.'M');
              $dateToInsert = $dateToInsert->format('Y-m-d H:i:s');
              $dateToInsertEnd = $this->addInterval($date." ".$start, ($movie->getDuration() +15));
              #----------------------------------------#
              //Creo el objeto show a modificar y por verificar
              $modifyShow = new Show($date, $dateToInsert, $dateToInsertEnd, $this->DAORoom->getByID($idRoom), $this->DAOMovie->getByID($idMovie), 0, 1, $idShow);
              #----------------------------------------#
              //realizo las validaciones
              $msg;
              #Validacion de fecha y hora
              $startAux = new DateTime($date." ".$start);
              $endAux = new DateTime($dateToInsertEnd);
              $showsList = $this->DAOShow->getActiveShows();
              foreach ($showsList as $show) {
                  if ($modifyShow->getDate() == $show->getDate()) {
                      if ($show->getRoom()->getId() == $idRoom) {
                          $extremoInferior = new DateTime($show->getDate().' '.$show->getStart());
                          if ($startAux->format('Y-m-d') == $endAux->format('Y-m-d')) {
                              $extremoSuperior = new DateTime($show->getDate().' '.$show->getEnd());
                          } else {
                              $extremoSuperior = new DateTime($endAux->format('Y-m-d').' '.$show->getEnd());
                          }
                          if (!($startAux>=$extremoSuperior) && !($endAux<=$extremoInferior) && ($show->getIdShow() != $idShow)) {
                              $msg = 'Schedule is full';
                          }
                      }
                  }
              }
              $aux = $this->DAOShow->getByDateAndMovieId($date, $idMovie);
              if ($aux != null){
                if (($aux[0]->getRoom()->getId() != $idRoom) && ($aux[0]->getIdShow() != $idShow)){
                  $msg = 'Same day restricction.';
                }
              }
            }
            
          if (isset($msg)){
            throw new PDOException($msg);
          }else{
            $this->DAOShow->modify($modifyShow);
          }
          
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          $this->manageShows();
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    public function removeShow ($idShow){
      if(AuthController::validate('admin')){
        try {
        //  $tickets = $this->DAOTicket->getTicketsByShow($idShow); 
        //  if($tickets){
         //   $msg = 'Tickets for that show have already been sold';
          //}else{
              $this->DAOShow->removeShowFromActive($idShow);
              $this->manageShows();
          //}
          if (isset($msg)) {
              throw new PDOException($msg);
          }
              } catch (PDOException $ex) {
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


/*
**
** INTERNAL USE FUNCTIONS
**
*/
    private function validateActiveShows(){
      $CurrentActiveShows = $this->DAOShow->getActiveShows();
      
      $dateTimeNow = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
        foreach ($CurrentActiveShows as $CurrentActiveShow){
          $dateTimeShow = new DateTime($CurrentActiveShow->getDate().' '.$CurrentActiveShow->getStart());
          
          /* Quita de activeShows los shows SoldOut. */
          
          // if ($CurrentActiveShow->getSpectators() == $CurrentActiveShow->getRoom()->getCapacity()){
          //   $this->DAOShow->removeShowFromActive($CurrentActiveShow->getIdShow());
          // }

          /* Quita de activeShows los shows de fechas pasadas */
          if ($dateTimeShow < $dateTimeNow){
            $this->DAOShow->removeShowFromActive($CurrentActiveShow->getIdShow());
        }
      }
    }

    private function getOpenRooms($movieStartingDate,$movieStartingDateTime,$movieEndingDateTimeS){
      
      $activeCinemas = $this->DAOCinema->getActiveCinemas();
      $openRooms = array();   
      
      foreach ($activeCinemas as $oneCinema) {
        
        //FLAGS
        $cinemaTrasnoche = false;
        $movieTrasnoche = false;
        $openCinema = false;
        $postMidnight = false;
      
        //CONVERSIONES A DATE TIME DE TODOS LOS DATOS
        $cinemaStartingDateTime = new DateTime($movieStartingDate." ".$oneCinema->getOpenning());
        $cinemaStartingHour = new DateTime();
        $cinemaEndingHour = new DateTime();
        $cinemaEndingDateTime = new DateTime($movieStartingDate." ".$oneCinema->getClosing());

        $movieStartingHour = new DateTime();
        $movieEndingHour = new DateTime();
        $movieEndingDateTime = new DateTime($movieEndingDateTimeS);

        $movieStartingDate = date_format($movieStartingDateTime, 'Y-m-d');
        $movieStartingHour = date_format($movieStartingDateTime, 'H:i:s');
        $movieEndingHour = date_format($movieEndingDateTime, 'H:i:s');
        $movieEndingDate = date_format($movieEndingDateTime, 'Y-m-d');
        
        $cinemaStartingDate = date_format($movieStartingDateTime, 'Y-m-d');
        $cinemaStartingHour = date_format($cinemaStartingDateTime, 'H:i:s');
        $cinemaEndingHour = date_format($cinemaEndingDateTime, 'H:i:s');
        $cinemaEndingDate = date_format($movieStartingDateTime, 'Y-m-d');

          
        //IF del cine con apertura mañana/tarde, de un solo día ->  de 10 a 20
        if (($cinemaStartingHour < $cinemaEndingHour) && ($cinemaStartingDate == $cinemaEndingDate) && ($movieStartingDate == $movieEndingDate)) {
          if ($cinemaStartingHour <= $movieStartingHour && $cinemaEndingHour >= $movieEndingHour) {
              $openCinema = true;
          }
        }

          //IF de cine trasnoche -> de 20 a 02
          if ($cinemaStartingHour > $cinemaEndingHour) {
              $cinemaEndingDateTime->add(new DateInterval('P1D'));
              $cinemaEndingDate = date_format($cinemaEndingDateTime, 'Y-m-d');  
              $cinemaTrasnoche = true;
          }
          
        //IF de película trasnoche -> de 23 a 01
          if ($movieStartingHour > $movieEndingHour) {
            $movieTrasnoche = true;
          } 

          
        //Si tanto el cine cómo la pelíocula pasan por el horario de las 12 de la noche:
        //Cine de 20 a 04 y película de 23 a 01  
        if($cinemaTrasnoche && $movieTrasnoche){
          echo 'ambos trasnoche';
          if($cinemaStartingDate == $movieStartingDate && $cinemaEndingDate == $movieEndingDate){
            echo 'entre horarios';
            if($cinemaStartingHour <= $movieStartingHour && $cinemaEndingHour >= $movieEndingHour){
              $openCinema = true;
            }
          }
        }
        
        //Si el cine es trasnoche y la película comienza luego de las 12 de la noche
        //Cine de 20 a 05 y película de 02 a 04
          if($cinemaTrasnoche){
            if($movieEndingHour < $cinemaEndingHour){
              if($movieStartingHour < $movieEndingHour){
                $movieEndingDateTime->add(new DateInterval('P1D'));
                $movieEndingDate = date_format($movieEndingDateTime, 'Y-m-d');
                $movieStartingDateTime->add(new DateInterval('P1D'));
                $movieStartingDate = date_format($movieStartingDateTime, 'Y-m-d');
                $postMidnight = true;
                $openCinema = true;
            }
          }
        }
        
          //IF de 24 hs
          if ($oneCinema->getOpenning() == $oneCinema->getClosing()) {
              $cinemaEndingDateTime->add(new DateInterval('P2D'));
              $cinemaEndingDate = date_format($cinemaEndingDateTime, 'Y-m-d');  
          }
      /*   
          echo '<br>';
          echo 'El cine abre el día ' .$cinemaStartingDate. ' a las '.$cinemaStartingHour ;
          echo ' Y cierra el día ' .$cinemaEndingDate. ' a las '.$cinemaEndingHour ;
          echo '<br>';
          echo 'La película empieza el día ' .$movieStartingDate. ' a las '.$movieStartingHour ;
          echo ' Y termina el día ' .$movieEndingDate. ' a las '.$movieEndingHour ;
          echo '<br>'; */
  
        if($openCinema){
          $oneCinemaRooms = $this->DAORoom->getActiveRoomsByCinema($oneCinema->getId());
          
          foreach($oneCinemaRooms as $oneRoom){
            array_push($openRooms,$oneRoom);
          }
        }
      }
      return $openRooms;
    }
    private function getRoomsWithAviableTime($rooms,$date,$startingHour,$endingHour){    
      $filteredRooms = array();

      // agrego dia y segundos al horario (para igualar formato al de la base de datos)
      $startingHour = $date . " " .$startingHour.":00";
      $endingHour = $date." ".$endingHour.":00";
    
      // convierto a formato DateTime 
      $endDateTime = new DateTime($endingHour);
      $startDateTime = new DateTime($startingHour);
    
      // si la hora fin es menor a hora inicio, agrego un dia a la fecha fin.
      if($endDateTime < $startDateTime){ // condicion nuevo dia
        $endDateTime->add(new DateInterval('P1D'));
      }
    
      // agrego 15 minutos a hora final, resto 15 min a inicio (para cumplir restriccion de 15 mins entre funciones)
      $startDateTime->sub(new DateInterval('PT' . 15 . 'M'));
      $endDateTime->add(new DateInterval('PT' . 15 . 'M'));

      $endDateTime = $endDateTime->format('Y-m-d H:i:s');
      $startDateTime = $startDateTime->format('Y-m-d H:i:s');

      foreach($rooms as $oneRoom){
        if(empty($this->DAOShow->getShowsInTimeLapse($oneRoom->getId(),$date,$startDateTime,$endDateTime))){
          array_push($filteredRooms,$oneRoom);
        }
      }
     
      return $filteredRooms;
    }

    private function sameDayRestriction($rooms,$date,$movieId){
      /*
      Recibo un dia, hora y pelicula
      verifico si para ese dia y pelicula existe un show
      si existe, me traigo la sala del show. Unica sala que se puede agregar
      si no existe, me traigo todas las salas abiertas a esa hora
      */
      $showInSameDate = $this->DAOShow->getByDateAndMovieId($date, $movieId);

      if($showInSameDate){ // si existe un show en el mismo dia...

        $onlyAviableRoom = array_shift($showInSameDate)->getRoom();

        if(!in_array($onlyAviableRoom,$rooms)){ // Si la sala de ese show NO esta entre las que quiero mostrar
          $rooms = null;
        }
        else{
          $rooms = $onlyAviableRoom;
        }
      }

      return $rooms;
    }
  }
?>