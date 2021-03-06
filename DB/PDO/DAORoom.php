<?php
  namespace DB\PDO;

  use \Exception as Exception;
  use Models\Room as Room;
  use Models\Cinema as Cinema;
  use DB\PDO\DAOCinema as DAOCinema;
  use DB\Interfaces\IDAORoom as IDAORoom;
  use DB\PDO\Connection as Connection;


  class DAORoom implements IDAORoom{
    private $connection;
    private $tableNameRooms ='ROOMS';

    //INSERT INTO ROOMS
    public function add(Room $room){
      $query = "INSERT INTO ".$this->tableNameRooms."
      (roomName, capacity, idCinema, price, roomType)
      values
      (:name, :capacity, :IDCinema, :price, :roomType);";

      $parameters['name'] = $room->getName();
      $parameters['capacity'] = $room->getCapacity();
      $parameters['IDCinema'] = $room->getCinema()->getId();
      $parameters['price'] = $room->getPrice();
      $parameters['roomType'] = $room->getRoomType();
      
      $this->connection = Connection::GetInstance();
      $response = $this->connection->ExecuteNonQuery($query, $parameters);
      return $response;
    }

    //SELECT * FROM ROOMS
    public function getAll(){
      $query = "SELECT * FROM ".$this->tableNameRooms;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);
      return $this->toArray($this->parseToObject($resultSet));
    }    

    //UPDATE ROMMS SET isAtive = 0
    public function removeRoom($id){
      $query = "Update ".$this->tableNameRooms. " SET isActive = :active WHERE idRoom = :id;";
      
      $parameters['id'] = $id;
      $parameters['active'] = 0;
      
      $this->connection = Connection::GetInstance();
      return $this->connection ->ExecuteNonQuery($query,$parameters);
    }

    //UPDATE ROOMS
    public function modify(Room $room){
      //print_r($room);
      $query = "UPDATE ".$this->tableNameRooms. " SET roomName = :name, capacity = :capacity, idCinema = :IDCinema ,
      price = :price , roomType = :roomType, isActive = :active 
      WHERE idRoom = :id;";
      
      $parameters['id'] = $room->getId();
      $parameters['name'] = $room->getName();
      $parameters['capacity'] = $room->getCapacity();
      $parameters['IDCinema'] = $room->getCinema()->getId();
      $parameters['price'] = $room->getPrice();
      $parameters['roomType'] = $room->getRoomType();
      $parameters['active'] = $room->getActive();
      $this->connection = Connection::GetInstance(); 
      return $this->connection->ExecuteNonQuery($query, $parameters);
    }
      
  //SELECT * FROM ROOMS WHERE idRoom
    public function getById($id){
      $query= "SELECT * FROM ".$this->tableNameRooms." WHERE idRoom = :ID;";
      $parameters['ID'] = $id;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query,$parameters);
      return $this->parseToObject($resultSet);
    }

    //SELECT * FROM ROOMS WHERE idCinema
    public function getByCinema($roomId){
      $query= "SELECT * FROM ".$this->tableNameRooms." WHERE idCinema = :ID;";
      $parameters['ID'] = $roomId;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query,$parameters);
      return $this->toArray($this->parseToObject($resultSet));
    }
            
    //SELECT * FROM ROOMS WHERE idActive = 1
    public function getActiveRooms(){
      $query = "SELECT * FROM ".$this->tableNameRooms. " WHERE isActive = :active";
      $parameters['active'] = 1;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query,$parameters);
      $activeRooms = $this->toArray($this->parseToObject($resultSet));
      return $activeRooms;
    }
      
    //SELECT * FROM ROOMS WHERE idCinema
    public function getActiveRoomsByCinema($IDCinema){
      $query = "SELECT * FROM ".$this->tableNameRooms. " WHERE isActive = :active AND idCinema = :IDCinema";
      $parameters['active'] = 1;
      $parameters['IDCinema'] = $IDCinema;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query,$parameters);
      $activeRooms = $this->toArray($this->parseToObject($resultSet));
      return $activeRooms;
    }

    protected function parseToObject($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){

        $DAOCinema = new DAOCinema();
        $cinema = $DAOCinema->getById($p['idCinema']);

          return new Room ($p['roomName'],$p['capacity'],$cinema,$p['price'],$p['roomType'],$p['isActive'], $p['idRoom']);
        }, $value);
        
        if(empty($resp)){
          return $resp;
        }
        else {
          return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
    
    private function toArray($value){
      if(is_array($value))
        return $value;
      else
        return array($value);
    }
}
?>