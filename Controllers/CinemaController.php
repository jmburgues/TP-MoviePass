<?php
  namespace Controllers;
  
  use DB\PDO\DAOCinema as DAOCinema;
  use DB\PDO\DAOMovie as DAOMovie;
  use DB\PDO\DAORoom as DAORoom;
  use Models\Cinema as Cinema;
  use PDOException;

class CinemaController{
    private $DAOCinema;
    private $DAOMovie;
    private $DAORoom;
    
    public function __construct(){
      $this->DAOCinema = new DAOCinema;
      $this->DAOMovie = new DAOMovie;
      $this->DAORoom = new DAORoom;
    }

    //Primer método luego del botón Cines, retorna los cines activos
    public function manageCinemas($message = NULL){
      if(AuthController::validate('admin')){
        try {
          $cinema = array();
          $aux = $this->DAOCinema->getActiveCinemas();
          if (is_array($aux)){
            $cinema = $aux;
          } else{
            $cinema[0] = $aux;
          }
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          include VIEWS_PATH.'manageCinemas.php';
        } 

        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    //Dirige a la vista cine-modify mostrando el cine con los datos anteriores
    public function modifyCinemaForm($idCinema){
      if(AuthController::validate('admin')){
        try {
            $currentCinema = $this->DAOCinema->placeholderCinemaDAO($idCinema);
            ViewController::navView($genreList=null,$moviesYearList=null,null,null);
            include VIEWS_PATH.'cine-modify.php';
          } 
          catch (PDOException $ex){
            $arrayOfErrors [] = $ex->getMessage();
            ViewController::errorView($arrayOfErrors);
          }
        }
      }
        
    //Cambia el valor boolean de los cines isActive
    public function deleteCinema($idCinema){
      if(AuthController::validate('admin')){
        try {
          $activeRooms = $this->DAORoom->getActiveRoomsByCinema($idCinema);
          if(!$activeRooms) {
            $this->DAOCinema->removeCinema($idCinema);
            $message = "Cinema deleted.";
          }
          else{
            $message = "Unable to delete. There are active rooms in the selected cinema.";
          }
            
            $this->manageCinemas($message);
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    //Modifica los valores de los cines
    public function modifyCinema($idCinema, $name, $address, $number, $openning, $closing){
      if(AuthController::validate('admin')){
        try {
          $cinemasList = $this->DAOCinema->getActiveCinemas();
          foreach($cinemasList as $cinemas){
            if ($cinemas->getId() == $idCinema) {
                $newCinema = new Cinema();
                $newCinema->setId($idCinema);
                $newCinema->setName($name);
                $newCinema->setAddress($address);
                $newCinema->setNumber($number);
                $newCinema->setOpenning($openning);
                $newCinema->setClosing($closing);
                $newCinema->setActive(true);
                $this->DAOCinema->modify($newCinema);
              }  
            }
          $this->manageCinemas();  
        } catch (PDOException $ex) {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
    }

    //Agrega un nuevo cinema
    //Verifica el nombre del cine y el borrado lógico
    public function AddCinema($name, $address, $number, $openning, $closing ){
    
    //if(AuthController::validate('admin')){
        try {
          if ($name != "") { 
              $cinema = new Cinema();
              $cinema->setName($name);
              $cinema->setAddress($address);
              $cinema->setNumber($number);
              $cinema->setOpenning($openning);
              $cinema->setClosing($closing);
              $cinema->setActive(true);
              $list=$this->DAOCinema->getAll();
              $cinemaExist = false;
              $message ="";
              foreach ($list as $l) {
                if ($l->getName() == $name) {
                  $cinemaExist = true;
                  if (!$l->getActive()) { 
                    $cinema->setActive(true);
                    $cinema->setId($l->getId()); 
                    $this->DAOCinema->modify($cinema);
                    $message = "The cinema is now active again.";
                  }else{
                    $message = "The cinema already exists.";
                  }
                }
              }
              if ($cinemaExist == false) { 
                  $this->DAOCinema->add($cinema);
                  $message = "Cinema successfully added";
              
              }
          }
          $this->manageCinemas();
        }
        catch (PDOException $ex) {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
     // }
    } 
  }

?>