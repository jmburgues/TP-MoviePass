<?php
  namespace Controllers;
  
  use DAO\PDO\PDOCinema as DAOCinema;
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


    //Primer método luego del borón Cines
    public function showCinemas(){
      $cinemas = array();
      $aux = $this->DAOCinema->getActiveCinemas();
      if (is_array($aux)){
        $cinemas = $aux;
      } else{
        $cinemas[0] = $aux;
      }
      //adminCinemas muestra el form para agregar un cine y el listado de cines activos
      include VIEWS_PATH.'adminCinemas.php';
    }

    //Dirige a la vista cine-modify mostrando el cine con los datos anteriores
    public function modifyCinemaView($idCinema)      {
        //echo "id". $idCinema;
          $currentCinema = $this->DAOCinema->placeholderCinemaDAO($idCinema);
          //print_r ($currentCinema);
          $cinemas = $this->DAOCinema->getActiveCinemas();  
          $movies=$this->DAOMovie->GetAll();
          include VIEWS_PATH.'cine-modify.php';
      }
        
  //Cambia el valor boolean de los cines isActive
    public function deleteCinema($idCinema){
      //echo $idCinema;
      $this->DAOCinema->removeCinema($idCinema);
      $cinemas = $this->DAOCinema->getActiveCinemas();  
      $movies=$this->DAOMovie->GetAll();
      include VIEWS_PATH.'adminCinemas.php';// CAMBIAR LOS INCLUDE POR INCLUDE_ONCE/REQUIERE_ONCE
    }

    //Modifica los valores de los
    public function modifyCinema($id, $name, $address, $number, $openning, $closing){
      echo $id, $name, $address, $number, $openning, $closing;
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
      $this->showCinemas();
    }

    //Agrega un nuevo cinema
    public function AddCinema($name, $address, $number, $openning, $closing ){
        if ($name != "") { // validaciones de nombre
            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setAddress($address);
            $cinema->setNumber($number);
            $cinema->setOpenning($openning);
            $cinema->setClosing($closing);
            $cinema->setActive(true);
            $list=$this->DAOCinema->getAll();
           // print_r($list);
            $cinemaExist = false;
            $message ="";
            //echo $cinema->getName();
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
                $this->DAOCinema->add($cinema);
                $message = "Cinema successfully added";
            }
        }
        if($message){
            echo "<script type='text/javascript'>alert('$message');</script>";  //Sacar del controlador
        }
        $cinemas = $this->DAOCinema->getActiveCinemas();
        $movies=$this->DAOMovie->GetAll();
        $this->showCinemas();
        //include VIEWS_PATH.'adminCinemas.php';
    }

  }
?>