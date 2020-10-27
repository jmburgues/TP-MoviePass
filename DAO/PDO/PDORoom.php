<?php
  namespace DAO\PDO;

  use \Exception as Exception;
  use Models\Room as Room;
  #use Models\Cinema as Cinema;
  use DAO\PDO\Connection as Connection;


  class PDOShow{
    private $connection;
    private $tableNameRooms ='ROOMS';
    #private $tableNameCinemas ='CINEMAS';
    #private $tableNameRoomType ='ROOM_TYPE';

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
            $parameters['roomType'] = $room->getPoster();
            
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
            return $this->parseToObject($resultSet);
            }
            catch(Exception $ex){
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

        public function getByCinema($cinemaId){
            try{
                $query= "SELECT * FROM ".$this->tableNameRooms." WHERE idCinema = :ID;";
                $parameters['ID'] = $id;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query,$parameters);
                return $this->parseToObject($resultSet);
                }
                catch(Exception $ex){
                    throw $ex;
                }
            }
                

        protected function parseToObject($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
        
                return new Room ($p['roomName'],$p['capacity'],$p['idCinema'],$p['price'],$p['roomType'],$p['isActive']);
            }, $value);
            
            if(empty($resp)){
            return $resp;
            }
            else {
            return count($resp) > 1 ? $resp : $resp['0'];
            }
        }
        
        
      }



}
?>