<?php
  namespace Controllers;
  
  use DB\PDO\DAOCinema as DAOCinema;
  use DB\PDO\DAOMovie as DAOMovie;
  use Models\Cinema as Cinema;
  use PDOException;

class CinemaController{
    private $DAOCinema;
    private $DAOMovie;
    
    public function __construct(){
      $this->DAOCinema = new DAOCinema;
      $this->DAOMovie = new DAOMovie;
    }


    //Primer método luego del botón Cines, retorna los cines activos
    public function manageCinemas(){
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

    //Dirige a la vista cine-modify mostrando el cine con los datos anteriores
    public function modifyCinemaForm($idCinema){
      try {
          $currentCinema = $this->DAOCinema->placeholderCinemaDAO($idCinema);
          $cinemas = $this->DAOCinema->getActiveCinemas();  
          $movies=$this->DAOMovie->getAll();
          ViewController::navView($genreList=null,$moviesYearList=null,null,null);
          include VIEWS_PATH.'cine-modify.php';
        } 
        catch (PDOException $ex){
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
        }
      }
        
    //Cambia el valor boolean de los cines isActive
    public function deleteCinema($idCinema){
      try {
        $this->DAOCinema->removeCinema($idCinema);
        $cinemas = array();
        $aux = $this->DAOCinema->getActiveCinemas();
        if (is_array($aux)){
          $cinemas = $aux;
        } else{
          $cinemas[0] = $aux;
        }        
        $this->manageCinemas();
      } 

      catch (PDOException $ex){
        $arrayOfErrors [] = $ex->getMessage();
        ViewController::errorView($arrayOfErrors);
      }
    }

    //Modifica los valores de los cines
    public function modifyCinema($id, $name, $address, $number, $openning, $closing){
      try {
        $cinemasList = $this->DAOCinema->getActiveCinemas();
        foreach($cinemasList as $cinemas){
          if ($cinemas->getId() == $id) {
              $newCinema = new Cinema();
              $newCinema->setId($id);
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

    //Agrega un nuevo cinema
    //Verifica el nombre del cine y el borrado lógico
    public function AddCinema($name, $address, $number, $openning, $closing ){
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
    }
  } 

?>