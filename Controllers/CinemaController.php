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
      $cinemasList = $this->DAOCinema->GetActiveCinemas();
    }

    /**action
     * Trae el valor del botón para redireccionar al método de eliminar o modificar.
    */
    public function action()      {
      if (isset($_POST)) {
        $option = current($_POST);
        if(isset($_POST["idCinemaM"])){
          echo"Modificaar";
          echo $option;
          $currentCinema = $this->DAOCinema->modifyCinemaDAO($option);
          print_r($currentCinema);
          
          include F_V.'cine-modify.php';
        }else{
            if (isset($_POST["idCinemaD"])) {
                $this->DAOCinema->removeCinema($option);
                include F_V.'adminView.php';
            }
        }
      }
    }
    
    /**modifyCinema
     * Método llamado desde el form de cine-modify
     * 
     */
    public function modifyCinema(){
      echo "<br>";
      echo "Post del modifyCinema";
      echo "<br>";
      print_r($_POST);
      $id = $_POST["id"];
      $cinemasList = $this->DAOCinema->getAll();
      foreach($cinemasList as $cinema){
        if($cinema->getId() == $id){
          echo "<br>";
          echo "id igual encontrado de modifyCinema";
          echo "<br>";
          print_r($cinema);
          echo "<br>";
          $cinema = $_POST;
          echo "<br>";
          echo "<Print luego de la asignacion de post a cinemA>";
          print_r($cinema);
          $this->DAOCinema->modify($cinema);
          include F_V.'adminView.php';
        }
      }
      //$cinemasList = $this->DAOCinema->SaveData();

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
              include F_V.'adminView.php';
        }
  }
?>