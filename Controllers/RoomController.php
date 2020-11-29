<?php
    namespace Controllers;

    use DB\PDO\DAORoom as DAORoom;
    use DB\PDO\DAOCinema as DAOCinema;
    use Models\Room as Room;
    use PDOException as Exception;


    class RoomController{
    private $DAORoom;
    private $DAOCinema;

    public function __construct(){
        $this->DAORoom = new DAORoom();
        $this->DAOCinema = new DAOCinema();
    }

    public function showRooms(){
        try {
            $rooms = $this->DAORoom->getAll();
            ViewController::navView($genreList=null,$moviesYearList=null,null,null);
            include VIEWS_PATH.'addRoomView.php';
        } 

        catch (Exception $ex){
            $arrayOfErrors [] = $ex->getMessage();
            ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
            ViewController::adminView();
        }
    }

    //Redirige a la vista para agregar una nueva sala
    public function addRoomView($idCinema){
        try {
            $rooms = array();
            $rooms = $this->DAORoom->getActiveRoomsByCinema($idCinema);
            $cinema = $this->DAOCinema->getById($idCinema);
            ViewController::navView($genreList=null,$moviesYearList=null,null,null);
            $cinemaName = $cinema->getName();
            include VIEWS_PATH.'addRoomView.php';
        } 

        catch (Exception $ex){
            $arrayOfErrors [] = $ex->getMessage();
            ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
            ViewController::adminView();
        }
    }

    //Redirige a la vista para modificar la sala
    public function modifyRoomView($idRoom){
        try {
            $currentRoom = $this->DAORoom->getById($idRoom);
            $rooms = $this->DAORoom->getActiveRooms();
            ViewController::navView($genreList=null,$moviesYearList=null,null,null);
            include VIEWS_PATH.'room-modify.php';
        } 

        catch (Exception $ex){
            $arrayOfErrors [] = $ex->getMessage();
            ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
            ViewController::adminView();
        }
    }

    //Recibe los nuevos valores
    public function modifyRoom($roomID, $IDCinema, $active, $name, $capacity, $price, $roomType){
        try {
            $roomsList = $this->DAORoom->getActiveRooms();

            $cinema = $this->DAOCinema->getById($IDCinema);
            $modifyRoom = new Room($name, $capacity, $cinema, $price, $roomType, $active, $roomID);
            foreach($roomsList as $rooms){
                if ($rooms->getId() == $roomID) {
                    $this->DAORoom->modify($modifyRoom);
                }  
            }
            $this->addRoomView($IDCinema);
        } 

        catch (Exception $ex){
            $arrayOfErrors [] = $ex->getMessage();
            ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
            $this->addRoomView($IDCinema);
        }
    }

    //Crea una nueva sala
    public function addRoom($idCinema, $name, $capacity, $price, $roomType){
        try {
            if ($name != "") {
                $cinema = $this->DAOCinema->getById($idCinema);
                $room = new Room($name, $capacity, $cinema, $price,$roomType, 1 );
                $listRoom = $this->DAORoom->getAll();
                $roomExist = false;
                $message ="";
                foreach ($listRoom as $list) {
                    if ($list->getCinema()->getId() == $idCinema){
                        if ($list->getName() == $name) {
                            if($list->getActive() == true){
                                $message = "The room already exists.";
                                $roomExist=true;
                            } else {
                                $room->setActive(true);
                                $room->setRoomID($list->getId());
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
            if(isset($message)){
                #echo "<script type='text/javascript'>alert('$message');</script>";
                throw new Exception($message);
            }  
            
            
            $rooms = $this->DAORoom->getByCinema($idCinema);
            $cinema = $this->DAOCinema->getById($idCinema);
            ViewController::navView($genreList=null,$moviesYearList=null,null,null);
            include VIEWS_PATH.'addRoomView.php';
        } 

        catch (Exception $ex){
            $arrayOfErrors [] = $ex->getMessage();
            ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
            $this->addRoomView($idCinema);
        }
    }

    public function deleteRoom($idRoom){
        try {
            $this->DAORoom->removeRoom($idRoom);
            
            ViewController::navView($genreList=null,$moviesYearList=null,null,null);
            $this->addRoomView($this->DAORoom->getById($idRoom)->getCinema()->getId());
        } 

        catch (Exception $ex){
            $arrayOfErrors [] = $ex->getMessage();
            ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
            $this->addRoomView($this->DAORoom->getById($idRoom)->getCinema()->getId());
        }
    }


}

    ?>