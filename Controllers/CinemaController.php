<?php
  namespace Controllers;
  
  use DAO\DAOCinema as DAOCinema;
  use Models\Cinema as Cinema;

  class CinemaController{
    private $DAOCinema;
    
    public function __construct(){
      $this->DAOCinema = new DAOCinema;
    }

    
    public function showCinemas(){
      $cinemasList = $this->DAOCinema->getActiveCinemas();
    }

    /**action
    * Trae el valor del botón para redireccionar al método de eliminar o modificar.
    */
    public function action()      {
      if (isset($_POST)) {
        $option = current($_POST);
        if(isset($_POST["idCinemaM"])){
          $currentCinema = $this->DAOCinema->placeholderCinemaDAO($option);
         // print_r($currentCinema);
          $cinemas = $this->DAOCinema->getActiveCinemas();  
          include VIEWS_PATH.'cine-modify.php';
        }else{
            if (isset($_POST["idCinemaD"])) {
              $this->DAOCinema->removeCinema($option);
              $cinemas = $this->DAOCinema->getActiveCinemas();  
              include VIEWS_PATH.'adminView.php';
            }
        }
      }
    }
    
    /**modifyCinema
     * Método llamado desde el form de cine-modify
     */
    public function modifyCinema(){
      $id = $_POST["id"];
      $cinemasList = $this->DAOCinema->getAll();
      foreach($cinemasList as $cinema){
        if($cinema->getId() == $id){
          //$cinema = $_POST;
          $newCinema = new Cinema();
          $newCinema->setId($_POST["id"]);
          $newCinema->setName($_POST["name"]);
          $newCinema->setAddress($_POST["address"]);
          $newCinema->setNumber($_POST["number"]);
          $newCinema->setOpenning($_POST["openning"]);
          $newCinema->setClosing($_POST["closing"]);
          $newCinema->setTicketValue($_POST["ticketValue"]);
          $newCinema->setActive(true);          
          $this->DAOCinema->modify($newCinema);
          $cinemas = $this->DAOCinema->getActiveCinemas();  
          include VIEWS_PATH.'adminView.php';
        }
      }
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
        
            //Control del refresh del form
            foreach ($list as $l) {
                if ($l->getName() == $name) {
                    $cinemaExist = true;
                    if (!$l->getActive()) { // verifico borrado logico
                      echo $l->getId();
                      $cinema->setActive(true);
                      $cinema->setId($l->getId()); 
                      $this->DAOCinema->modify($cinema);
                      $message = "The cinema is now active again.";
                    }
                }
            }
            if ($cinemaExist == false) { // si no hay cines con mismo nombre, agrego.
                $this->DAOCinema->Add($cinema);
                $message = "Cinema successfully added";
            }
        }
        echo "<script type='text/javascript'>alert('$message');</script>";
        $cinemas = $this->DAOCinema->getActiveCinemas();
        include VIEWS_PATH.'adminView.php';
    }

  }
?>