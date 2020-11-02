<?php
  namespace DB\PDO;

  use \Exception as Exception;
  use Models\Room as Room;
  use DB\PDO\Connection as Connection;


  class DAORoom{
    private $connection;
    private $tableNameRooms ='ROOMS';

    public function add($room){
        try{
            $query = "INSERT INTO ".$this->tableNameRooms."
            (roomName, capacity, idCinema, price, roomType)
            values
            (:name, :capacity, :IDCinema, :price, :roomType);";

            $parameters['name'] = $room->getName();
            $parameters['capacity'] = $room->getCapacity();
            $parameters['IDCinema'] = $room->getIDCinema();
            $parameters['price'] = $room->getPrice();
            $parameters['roomType'] = $room->getRoomType();
            
            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
            return $response;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function getAll(){
        try{
            $query = "SELECT * FROM ".$this->tableNameRooms;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $this->toArray($this->parseToObject($resultSet));
            }
            catch(Exception $ex){
            throw $ex;
            }
        }    

        public function removeRoom($id){
            try{
              $query = "Update ".$this->tableNameRooms. " SET isActive = :active WHERE idRoom = :id;";
              
              $parameters['id'] = $id;
              $parameters['active'] = false;
              
              $this->connection = Connection::GetInstance();
              return $this->connection ->ExecuteNonQuery($query,$parameters);
            }
      
            catch(Exception $ex){
                throw $ex;
            }
          }
      
          public function modify(Room $room){
            //print_r($room);
            try{
              $query = "UPDATE ".$this->tableNameRooms. " SET roomName = :name, capacity = :capacity, idCinema = :IDCinema ,
              price = :price , roomType = :roomType, isActive = :active 
              WHERE idRoom = :id;";
              
              $parameters['id'] = $room->getRoomID();
              $parameters['name'] = $room->getName();
              $parameters['capacity'] = $room->getCapacity();
              $parameters['IDCinema'] = $room->getIDCinema();
              $parameters['price'] = $room->getPrice();
              $parameters['roomType'] = $room->getRoomType();
              $parameters['active'] = $room->getActive();
              $this->connection = Connection::GetInstance(); 
              return $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $ex)
            {
              throw $ex;
            }
          }
        
        public function getById($id){
            try{
                $query= "SELECT * FROM ".$this->tableNameRooms." WHERE idRoom = :ID;";
                $parameters['ID'] = $id;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query,$parameters);
                return $this->parseToObject($resultSet);
                }
                catch(Exception $ex){
                    throw $ex;
                }
            }

        public function getByCinema($roomId){
            try{
                $query= "SELECT * FROM ".$this->tableNameRooms." WHERE idCinema = :ID;";
                $parameters['ID'] = $roomId;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query,$parameters);
                return $this->toArray($this->parseToObject($resultSet));
                }
                catch(Exception $ex){
                    throw $ex;
                }
            }
                
          public function getActiveRooms(){
            try{
              $query = "SELECT * FROM ".$this->tableNameRooms. " WHERE isActive = :active";
              $parameters['active'] = true;
              $this->connection = Connection::GetInstance();
              $resultSet = $this->connection->Execute($query,$parameters);
              $activeRooms = $this->toArray($this->parseToObject($resultSet));
              return $activeRooms;
            }
            catch(Exception $ex){
              throw $ex;
            }
          }
          
          public function getActiveRoomsByCinema($IDCinema){
            try{
              $query = "SELECT * FROM ".$this->tableNameRooms. " WHERE isActive = :active AND idCinema = :IDCinema";
              $parameters['active'] = true;
              $parameters['IDCinema'] = $IDCinema;
              $this->connection = Connection::GetInstance();
              $resultSet = $this->connection->Execute($query,$parameters);
              $activeRooms = $this->toArray($this->parseToObject($resultSet));
              return $activeRooms;
            }
            catch(Exception $ex){
              throw $ex;
            }
          }



        protected function parseToObject($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
        
                return new Room ($p['roomName'],$p['capacity'],$p['idCinema'],$p['price'],$p['roomType'],$p['isActive'], $p['idRoom']);
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