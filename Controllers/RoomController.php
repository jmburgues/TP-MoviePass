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

    //Redirige a la vista para agregar una nueva sala
    public function manageRooms($idCinema){
        if(AuthController::validate('admin')){
            try {
                $rooms = array();
                $rooms = $this->DAORoom->getActiveRoomsByCinema($idCinema);
                $cinema = $this->DAOCinema->getById($idCinema);

                ViewController::navView($genreList=null,$moviesYearList=null,null,null);
                include VIEWS_PATH.'manageRooms.php';
            } 
            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                ViewController::adminView();
            }
        }
    }

    //Redirige a la vista para modificar la sala
    public function modifyRoomView($idRoom){
        if(AuthController::validate('admin')){
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
    }

    //Recibe los nuevos valores
    public function modifyRoom($roomID, $IDCinema, $active, $name, $capacity, $price, $roomType){
        if(AuthController::validate('admin')){
            try {
                $roomsList = $this->DAORoom->getActiveRooms();

                $cinema = $this->DAOCinema->getById($IDCinema);
                $modifyRoom = new Room($name, $capacity, $cinema, $price, $roomType, $active, $roomID);
                foreach($roomsList as $rooms){
                    if ($rooms->getId() == $roomID) {
                        $this->DAORoom->modify($modifyRoom);
                    }  
                }
                $this->manageRooms($IDCinema);
            } 
            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                $this->manageRooms($IDCinema);
            }
        }
    }

    //Crea una nueva sala
    public function addRoom($idCinema, $name, $capacity, $price, $roomType){
        if(AuthController::validate('admin')){
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
                include VIEWS_PATH.'manageRooms.php';
            } 
            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                $this->manageRooms($idCinema);
            }
        }
    }

    public function deleteRoom($idRoom){
        if(AuthController::validate('admin')){
            try {
                $this->DAORoom->removeRoom($idRoom);
                
                ViewController::navView($genreList=null,$moviesYearList=null,null,null);
                $this->manageRooms($this->DAORoom->getById($idRoom)->getCinema()->getId());
            } 

            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                $this->manageRooms($this->DAORoom->getById($idRoom)->getCinema()->getId());
            }
        }
    }

}
?>