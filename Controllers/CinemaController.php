<?php
  namespace Controllers;

  use DAO\DAOCinema as DAOCinema;
  use Models\Cinema as Cinema;

  class CinemaController{
    private $cinemaDAO;

    public function __construct(){
      $this->cinemaDAO = new DAOCinema;
    }

    public function showCinemas(){
      $cinemasList = $this->cinemaDAO->getAll();
      include VIEWS . 'cinemasList.php';
    }

    public function Add($cinema = null, $mensaje= ''){
      $placeholderName = 'Ingrese el nombre del cine';
      $placeholderAddress = 'Ingresar la direccion del cine';
      $placeholderOpenTime = 0;
      $placeholderCloseTime = 0;
      if(!is_null($cinema)){
        if(!empty($cinema->getName())){
          $placeholderName = $cinema->getName();
        }
        if(!empty($cinema->getAddress())){
          $placeholderAddress = $cinema->getAddress();
        }
        if(!empty($cinema->getOpenTime())){
          $placeholderOpenTime = $cinema->getOpenTime();
        }
        if(!empty($cinema->getCloseTime())){
          $placeholderCloseTime = $cinema->getCloseTime();
        }
      }
      include VIEWS . "cinemaForm.php";
    }

    public function validateData($name,$adress,$openTime,$closeTime){
      $error = false;
      $tempName = '';
      $tempAddress = '';
      $tempOpenTime = 0;
      $tempCloseTime = 0;

      /**Quiero discutir sobre las condiciones de fallo */
      
      if($flag == true){
        $tempCinema = new Cinema($tempName,$tempAddress);
        $this->createCinema($tempCinema,$message);
      }else{
        $this->add($name,$address,$openTime,$closeTime);
      }
    }

    public function add($name,$address,$openTime,$closeTime){
      $newCinema = new Cinema($name,$address,$openTime,$closeTime);
      $this->cinemaDAO->add($newCinema);
      $this->showCienamas();
    }

    public function modifyCinema($cinema){
      $placeholderName = $cinema->getName();
      $placeholderAddress = $cinema->getAddress();
      $placeholderOpenTime = $cinema->getOpenTime();
      $placeholderCloseTime = $cinema->getCloseTime();
      $valueId = $cinema->getId();
      
      include VIEWS . 'cinemaModifyForm.php';
    }

    public function update($name,$adress,$openTime,$closeTime,$cinema){
      if(empty($name)){
        $name = $cinema->getName();;    
      }

      if(empty($address)){
        $address = $cinema->getAddress();    
      }

      if(empty($openTime)){
        $openTime = $cinema->getOpenTime();    
      }
     
      if(empty($closeTime)){
        $closeTime = $cinema->getCloseTime();    
      }

      $cinemaModified = new Cinema($name,$address,$openTime,$closeTime,$id);

      $this->cinemaDAO->update($cinemaModified);
      $this->showCinemas();
    }
  }
?>