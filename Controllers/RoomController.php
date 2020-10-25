<?php
    namespace Controllers;
    use DAO\DAORoom as DAORoom;
    use Models\Room as Room;

    class RoomController{
    private $DAORoom;
    
    public function __construct(){
        $this->DAORoom = new DAORoom;
    }

    public function showRooms(){
        $rooms = $this->DAORoom->getAll();
        include VIEWS_PATH.'addRoomView.php';
    }

    public function addRoomView($idCinema){
        $rooms = $this->DAORoom->getAll();
        include VIEWS_PATH.'addRoomView.php';
    }

    public function addRoom($idCinema, $name, $capacity, $price){
        $rooms = $this->DAORoom->getAll();
        echo $idCinema, $name, $capacity, $price;
            $rooms = $this->DAORoom->getAll();
            $room = new Room();
            $room->setIDCinema($idCinema);
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setprice($price);
            $this->DAORoom->add($room);
            
            include VIEWS_PATH.'addRoomView.php';
        }
}

    ?>