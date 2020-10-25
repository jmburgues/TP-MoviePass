<?php
namespace DAO;
use Models\Room as Room;

class DAORoom{
    private $roomList;
    private $fileName = ROOT."Data/rooms.json";

  
    public function add(Room $room){
        $this->retrieveData();
        $room->setRoomId($this->generateID());
       // $exist = $this->GetById($room->getRoomID());
       // if (!isset($exist)) {
        array_push($this->roomList, $room);
        $this->saveData();
       // }
    }

    public function generateID(){
      $this->RetrieveData();
      return count($this->roomList) + 1;
  }

    public function getAll(){
        $this->retrieveData();
        return $this->roomList;
    }

    private function RetrieveData(){
        $this->roomList = array();
        if (file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                $room = new Room();
                $room->setRoomID($valuesArray["ID"]);
                $room->setName($valuesArray["name"]);
                $room->setCapacity($valuesArray["capacity"]);
                $room->setIDCinema($valuesArray["IDCinema"]);
                $room->setPrice($valuesArray["price"]);
                array_push($this->roomList, $room);
            }
        }
    }

    public function removeRoom($idRoom)
    {
        $this->RetrieveData();
        $toDelete = null;
        foreach($this->roomList as $list){
            if($list->getRoomID() == $idRoom){
                unset($this->roomList, $list);
            }
        } 
        $this->SaveData();
    }

    public function SaveData(){
        $arrayToEncode = array();
        foreach ($this->roomList as $room) {
            $valuesArray["ID"] = $room->getRoomID();
            $valuesArray["name"] = $room->getName();
            $valuesArray["capacity"] = $room->getCapacity();
            $valuesArray["IDCinema"] = $room->getIDCinema();
            $valuesArray["price"] = $room->getPrice();
            array_push($arrayToEncode, $valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

  public function GetById($id){
    $this->RetrieveData();
    foreach ($this->roomList as $room){
      if ($room->getRoomID() == $id) {
        return $room;
      }
    }
    return null;
  }

}
?>