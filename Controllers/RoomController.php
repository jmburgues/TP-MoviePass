<?php
    namespace Controllers;

    use DB\PDO\DAORoom as DAORoom;
    use DB\PDO\DAOCinema as DAOCinema;
    use Models\Room as Room;
    use Models\Cinema as Cinema;

    class RoomController{
    private $DAORoom;
    private $DAOCinema;

    public function __construct(){
        $this->DAORoom = new DAORoom();
        $this->DAOCinema = new DAOCinema();
    }

    public function showRooms(){
        $rooms = $this->DAORoom->getAll();
        /*$shows = array();
        $aux =$this->DAOShow->getAll();
        if (is_array($aux)){
            $shows = $aux;
        }else{
            $shows[0] = $aux;
        }
        include VIEWS_PATH.'showAddView.php';
        include VIEWS_PATH.'adminShows.php';*/

        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'addRoomView.php';
    }

    public function addRoomView($idCinema){
        $rooms = array();
        $rooms = $this->DAORoom->getActiveRoomsByCinema($idCinema);
        $cinema = $this->DAOCinema->getById($idCinema);
       ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'addRoomView.php';
    }

    public function modifyRoomView($idRoom){
        $currentRoom = $this->DAORoom->getById($idRoom);
        $rooms = $this->DAORoom->getActiveRooms();
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'room-modify.php';
    }

    public function modifyRoom($roomID, $IDCinema, $active, $name, $capacity, $price, $roomType){
        $roomsList = $this->DAORoom->getActiveRooms();
        $modifyRoom = new Room($name, $capacity, $IDCinema, $price, $roomType, $active, $roomID);
        foreach($roomsList as $rooms){
            if ($rooms->getRoomID() == $roomID) {
                $this->DAORoom->modify($modifyRoom);
            }  
        }
      $this->addRoomView($IDCinema);
    }

    public function addRoom($idCinema, $name, $capacity, $price, $roomType){
        if ($name != "") {
            //echo $idCinema, $name, $capacity, $price;
            $room = new Room();
            $room->setIDCinema($idCinema);
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setprice($price);
            $room->setRoomType($roomType);
            $listRoom = $this->DAORoom->getAll();
            $roomExist = false;
            $message ="";
            foreach ($listRoom as $list) {
                if ($list->getIDCinema() == $idCinema){
                    if ($list->getName() == $name) {
                        if($list->getActive() == true){
                            $message = "The room already exists.";
                            $roomExist=true;
                        } else {
                            $room->setActive(true);
                            $room->setRoomID($list->getRoomID());
                            $this->DAORoom->modify($room);
                            $message = "The room is active again.";
                            $roomExist=true;
                        }
                    }
                }
            }
            if ($roomExist == false) { 
                $this->DAORoom->add($room);
                $message = "Room successfully added";
            }
        }
        if($message){
            echo "<script type='text/javascript'>alert('$message');</script>";  
        }  
        
        //$rooms = $this->DAORoom->getAll();
        $rooms = $this->DAORoom->getByCinema($idCinema);
        $cinema = $this->DAOCinema->getById($idCinema);
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        include VIEWS_PATH.'addRoomView.php';
    }

    public function deleteRoom($idRoom){
    
        $this->DAORoom->removeRoom($idRoom);
        
        ViewController::navView($genreList=null,$moviesYearList=null,null);
        $this->addRoomView($this->DAORoom->getById($idRoom)->getIDCinema());
    }


}

    ?>