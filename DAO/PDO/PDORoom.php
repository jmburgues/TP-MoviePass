<?php
  namespace DAO\PDO;

  use \Exception as Exception;
  use Models\Room as Room;
  use Models\Cinema as Cinema;
  use DAO\PDO\Connection as Connection;


  class PDOShow{
    private $connection;
    private $tableNameRooms ='ROOMS';
    private $tableNameCinemas ='CINEMAS';
    private $tableNameRoomType ='ROOM_TYPE';

    public function add($room){
        try{
            $query = "INSERT INTO ".$this->tableNameRooms."
            (idRoom, roomName, capacity, idCinema, price, roomType)
            values
            (:ID, :name, :capacity, :IDCinema, :price, :roomType);";

            $parameters['ID'] = $room->getRoomID();
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
                
        public function getByType($id){
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


        private function parseToObject($value){
	
		}



}
?>