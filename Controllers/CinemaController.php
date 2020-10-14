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
          $currentCinema = $this->DAOCinema->modifyCinemaDAO($option);
          print_r($currentCinema);
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
          $cinema = $_POST;
          $this->DAOCinema->modify($cinema);
          $cinemas = $this->DAOCinema->getActiveCinemas();  
          include VIEWS_PATH.'adminView.php';
        }
      }
    }

      public function AddCinema($name, $address, $number, $openning, $closing, $ticketValue ){
        $cinema = new Cinema();
        $cinema->setName($name);
        $cinema->setAddress($address);
        $cinema->setNumber($number);
        $cinema->setOpenning($openning);
        $cinema->setClosing($closing);
        $cinema->setTicketValue($ticketValue);
        $list=$this->DAOCinema->GetAll();  
      //  $flag = false;

        //Control del refresh del form
        foreach($list as $l){
          if($l->getName() != $cinema->getName() ){
        //    $flag = true;
        if ($cinema->getName() != ""  ) {
                $this->DAOCinema->Add($cinema);
                $message = "Cinema successfully added";
            } else {
                $message = "Cinema already added";
              }
              echo "<script type='text/javascript'>alert('$message');</script>";
              $cinemas = $this->DAOCinema->getActiveCinemas();  
              include VIEWS_PATH.'adminView.php';
        }
          }
        }

        //Control de un cine ya existente
  }
?>