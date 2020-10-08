<?php
  namespace Controllers;
  define("F_RR", "/TP-MoviePass/");
  define("F_V", "Views/");

  use DAO\DAOCinema as DAOCinema;
  use Models\Cinema as Cinema;

  class CinemaController
  {
      private $DAOCinema;

      public function __construct()
      {
          $this->DAOCinema = new DAOCinema;
      }

      public function showCinemas()
      {
          //include dirname(__FILE__).'/../Views/login-view.php';
          $cinemasList = $this->DAOCinema->getAll();
          include VIEWS . 'cinemasList.php';
      }


      public function ShowAddView($message = "")
      {
          //require_once(VIEWS_PATH."student-add.php");
          //echo FROaNT_ROOTUser/showLogin"
          include F_V. 'adminView.php';
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
      foreach($list as $l){
        if($l == $cinema){
          $flag = true;
        }
      }

      //$key = array_search($cinema, $this->list);
      //print_r($key);
      if ($cinema->getName() != "" && $flag == false ) {
              $this->DAOCinema->Add($cinema);
              $message = "Cinema successfully added";
          } else {
              $message = "Cinema already added";
      }
      $this->ShowAddView($message);
    }

    public function validateData($name,$address,$openTime,$closing){
      $error = false;
      $tempName = '';
      $tempAddress = '';
      $tempOpenTime = 0;
      $tempclosing = 0;

      /**Quiero discutir sobre las condiciones de fallo */
      
      if($flag == true){
        $tempCinema = new Cinema($tempName,$tempAddress);
        $this->createCinema($tempCinema,$message);
      }else{
        $this->add($name,$address,$openTime,$closing);
      }
    }
/*
    public function add($name,$address,$openTime,$closing){
      $newCinema = new Cinema($name,$address,$openTime,$closing);
      $this->cinemaDAO->add($newCinema);
      $this->showCienamas();
    }
*/
    public function modifyCinema($cinema){
      $placeholderName = $cinema->getName();
      $placeholderAddress = $cinema->getAddress();
      $placeholderOpenTime = $cinema->getOpenTime();
      $placeholderclosing = $cinema->getclosing();
      $valueId = $cinema->getId();
      
      include VIEWS . 'cinemaModifyForm.php';
    }

    public function update($name,$address,$openTime,$closing,$cinema){
      if(empty($name)){
        $name = $cinema->getName();;    
      }

      if(empty($address)){
        $address = $cinema->getAddress();    
      }

      if(empty($openTime)){
        $openTime = $cinema->getOpenTime();    
      }
     
      if(empty($closing)){
        $closing = $cinema->getclosing();    
      }

      $cinemaModified = new Cinema($name,$address,$openTime,$closing,$id);

      $this->cinemaDAO->update($cinemaModified);
      $this->showCinemas();
    }
  }
?>