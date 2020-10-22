<?php
  namespace Controllers;
  
  use DAO\DAOCinema as DAOCinema;
  use Models\Cinema as Cinema;
  use Models\Movie as Movie;
  use DAO\DAOMovie as DAOMovie;

  class CinemaController{
    private $DAOCinema;
    private $DAOMovie;
    public function __construct(){
      $this->DAOCinema = new DAOCinema;
      $this->DAOMovie = new DAOMovie;
    }

    
    public function showCinemas(){
      $cinemasList = $this->DAOCinema->getActiveCinemas();
    }

    /**action
    * Trae el valor del botón para redireccionar al método de eliminar o modificar.
    */
    //CAMBIAR EL POST A PARAMETRO
    //HACER 2 FUNCIONES, 2 FORMS DELETE Y MODIFY
    public function modifyCinemaView($idCinema)      {
          $currentCinema = $this->DAOCinema->placeholderCinemaDAO($idCinema);
          $cinemas = $this->DAOCinema->getActiveCinemas();  
          $movies=$this->DAOMovie->GetAll();
          include VIEWS_PATH.'cine-modify.php';
      }
        

    public function deleteCinema($idCinema){
      $this->DAOCinema->removeCinema($idCinema);
      $cinemas = $this->DAOCinema->getActiveCinemas();  
      $movies=$this->DAOMovie->GetAll();
      include VIEWS_PATH.'adminView.php'; // CAMBIAR LOS INCLUDE POR INCLUDE_ONCE/REQUIERE_ONCE
    }

    
    public function modifyCinema($id, $name, $address, $number, $openning, $closing, $ticketValue){
      echo $id, $name, $address, $number, $openning, $closing, $ticketValue;
      $cinemasList = $this->DAOCinema->getAll();
      foreach($cinemasList as $cinemas){
        if ($cinemas->getId() == $id) {
            $newCinema = new Cinema();
            $newCinema->setId($id);
            $newCinema->setName($name);
            $newCinema->setAddress($address);
            $newCinema->setNumber($number);
            $newCinema->setOpenning($openning);
            $newCinema->setClosing($closing);
            $newCinema->setTicketValue($ticketValue);
            $newCinema->setActive(true);
            $this->DAOCinema->modify($newCinema);
            $cinemas = $this->DAOCinema->getActiveCinemas();
            $movies=$this->DAOMovie->GetAll();
        }  
      }
      include VIEWS_PATH.'adminView.php';
    }

    public function AddCinema($name, $address, $number, $openning, $closing, $ticketValue ){
        if ($name != "") { // validaciones de nombre
            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setAddress($address);
            $cinema->setNumber($number);
            $cinema->setOpenning($openning);
            $cinema->setClosing($closing);
            $cinema->setTicketValue($ticketValue);
            $list=$this->DAOCinema->GetAll();
            $cinemaExist = false;
            $message ="";
            //Control del refresh del form
            foreach ($list as $l) {
                if ($l->getName() == $name) {
                    $cinemaExist = true;
                    if (!$l->getActive()) { // verifico borrado logico
                      $cinema->setActive(true);
                      $cinema->setId($l->getId()); 
                      $this->DAOCinema->modify($cinema);
                      $message = "The cinema is now active again.";
                    }
                  }
                      if($cinemaExist == false){
                        $message = "The cinema is already exist.";
                  
                }
            }
            if ($cinemaExist == false) { // si no hay cines con mismo nombre, agrego.
                $this->DAOCinema->Add($cinema);
                $message = "Cinema successfully added";
            }
        }
        if($message){
            echo "<script type='text/javascript'>alert('$message');</script>";  //Sacar del controlador
        }
        $cinemas = $this->DAOCinema->getActiveCinemas();
        $movies=$this->DAOMovie->GetAll();
        include VIEWS_PATH.'adminView.php';
    }

  }
?>