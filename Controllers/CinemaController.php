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
    public function action($idM="",$idD=""){

      if(is_null($idM)){
        $currentCinema = $this->DAOCinema->modifyCinemaDAO($idM);
        print_r($currentCinema);
        include F_V.'cine-modify.php';
      }else{
          if (is_null($idD)) {
            $this->DAOCinema->removeCinema($idD);
            $cinemas = $this->DAOCinema->getActiveCinemas(); 
            include F_V.'adminView.php';
            
          }
      }
    }
    
    /**modifyCinema
     * Método llamado desde el form de cine-modify
     * 
     */
    public function modifyCinema(){
      $id = $_POST["id"];
      $cinemasList = $this->DAOCinema->getAll();
      foreach($cinemasList as $cinema){
        if($cinema->getId() == $id){
          $cinema = $_POST;
          print_r($cinema);
          $this->DAOCinema->modify($cinema);
          $cinemas = $this->DAOCinema->getActiveCinemas();
          include F_V.'adminView.php';
        }
      }
    }

      public function AddCinema($name, $address, $openning, $closing, $ticketValue ){
        $cinema = new Cinema();
        $cinema->setName($name);
        $cinema->setAddress($address);
        $cinema->setOpenning($openning);
        $cinema->setClosing($closing);
        $cinema->setTicketValue($ticketValue);
        $list=$this->DAOCinema->GetAll();  
        $flag = false;

        //Control del refresh del form
        foreach($list as $l){
          if($l->getName() == $cinema->getName()){
            $flag = true;
          }
        }

        //Control de un cine ya existente
        if ($cinema->getName() != "" && $flag == false ) {
                $this->DAOCinema->Add($cinema);
                $message = "Cinema successfully added";
            } else {
                $message = "Cinema already added";
              }
              echo "<script type='text/javascript'>alert('$message');</script>";
              $cinemas = $this->DAOCinema->getActiveCinemas();  
              include F_V.'adminView.php';
        }
  }
?>