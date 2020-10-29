<?php
    namespace Controllers;

    use DAO\PDO\PDORoom as DAORoom;
    use Models\Room as Room;

    class RoomController{
    private $DAORoom;
    
    public function __construct(){
        $this->DAORoom = new DAORoom;
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

        include VIEWS_PATH.'addRoomView.php';
    }

    public function addRoomView($idCinema){
        $rooms = array();
        $rooms = $this->DAORoom->getByCinema($idCinema);
        
        include VIEWS_PATH.'addRoomView.php';
    }

    public function addRoom($idCinema, $name, $capacity, $price){
        if ($name != "") {
            //echo $idCinema, $name, $capacity, $price;
            $room = new Room();
            $room->setIDCinema($idCinema);
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setprice($price);
            $listRoom = $this->DAORoom->getAll();
            $roomExist = false;
            $message ="";
            foreach ($listRoom as $list) {
                if ($list->getName() == $name) {
                    $roomExist = true;
                }
                if($roomExist == false){
                    $message = "The room is already exist.";
                    
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
        
        $rooms = $this->DAORoom->getAll();
        include VIEWS_PATH.'addRoomView.php';
    }

    // public function deleteRoom($idRoom){
    //     $rooms = $this->DAORoom->getAll();
    //     $this->DAORoom->removeRoom($idRoom);
    //     include VIEWS_PATH.'adminCinemas.php';// CAMBIAR LOS INCLUDE POR INCLUDE_ONCE/REQUIERE_ONCE
    // }


}

    ?>