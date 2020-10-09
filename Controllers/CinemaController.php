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
        $cinemasList = $this->DAOCinema->getAll();
      }
      //Por el momento compararía con el nombre.
      //Según si es eliminar o modificar llama a sus funciones. 
      public function action()      {
          if (isset($_POST)) {
            $option = current($_POST);
            print_r($_POST);
            if($option == "Eliminar"){
            //$cinemasList = $this->DAOCinema->getAll();
            echo "Elimiar";
            
          }else{
              echo "Modificar";
            }
          }
      }
      
      public function AddCinema($name, $address, $openning, $closing, $ticketValue ){
        $cinema = new Cinema($name, $address, $openning, $closing, $ticketValue);
        $list=$this->DAOCinema->GetAll();  
        $flag = false;
        //Control del refresh del form
        foreach($list as $l){
          if($l == $cinema){
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