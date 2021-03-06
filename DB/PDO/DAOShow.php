<?php
  namespace DB\PDO;

  use \DateTime as DateTime;
  use \DateTimeZone as DateTimeZone;
  use \Exception as Exception;
  use Models\Show as Show;
  use Models\Room as Room;
  use DB\PDO\DAORoom as DAORoom;
  use Models\Movie as Movie;
  use DB\PDO\DAOMovie as DAOMovie;
  use DB\Interfaces\IDAOShow as IDAOShow;
  use DB\PDO\Connection as Connection;


  class DAOShow implements IDAOShow{
    private $connection;
    private $tableNameShows = "SHOWS";
    private $tableNameCinemas = "CINEMAS";
    private $tableNameRooms = "ROOMS";

    
    //INSERT INTO SHOWS
    public function add(Show $show){
        $query = "INSERT INTO ".$this->tableNameShows."
        (dateSelected, startsAt, endsAt, spectators, idRoom, idMovie)
        values
        (:date, :start, :end,:spectators, :idRoom, :idMovie );";
        
        $parameters['date'] = $show->getDate();
        $parameters['start'] = $show->getStart();
        $parameters['end'] = $show->getEnd();
        $parameters['spectators'] = 0;
        $parameters['idRoom'] = $show->getRoom()->getId();
        $parameters['idMovie'] = $show->getMovie()->getMovieID();
        
        $this->connection = Connection::GetInstance();
        $response = $this->connection->ExecuteNonQuery($query, $parameters);
        return $response;
    }

    //SELECT * FROM SHOWS
    public function getAll(){
        $query = "SELECT * FROM ".$this->tableNameShows;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);
        return $this->toArray($this->parseToObject($resultSet));
    }

   //SELECT * FROM SHOWS WHERE idActive = 1
    public function getActiveShows(){
        $query = "SELECT * FROM ".$this->tableNameShows." WHERE isActive = 1 ORDER BY ".$this->tableNameShows.".startsAt DESC";
        //$parameters['active'] = true;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);
        return $this->toArray($this->parseToObject($resultSet));
    }
        
    //Devuelve los idMovie sin repetir de shows,rooms y cinemas que se encuentren activos.
    public function getBillBoard(){
            $query = "SELECT DISTINCT idMovie FROM ".$this->tableNameShows." S INNER JOIN ".$this->tableNameRooms." R ON S.idRoom = R.idRoom INNER JOIN ".$this->tableNameCinemas." C ON R.idCinema = C.idCinema WHERE S.isActive = 1 AND R.isActive = 1 AND C.isActive = 1;";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return ($resultSet);
    }


    public function modify(Show $show)    {
        $query = "UPDATE ".$this->tableNameShows." 
        SET dateSelected = :date, startsAt = :start, endsAt = :end, 
        spectators = :spectators, idRoom = :idRoom, idMovie = :idMovie, 
        isActive = :active 
        WHERE idShow = :idShow; ";
        $parameters['date'] = $show->getDate();
        $parameters['start'] = $show->getStart();
        $parameters['end'] = $show->getEnd();
        $parameters['spectators'] = 0;
        $parameters['idRoom'] = $show->getRoom()->getId();
        $parameters['idMovie'] = $show->getMovie()->getMovieID();
        $parameters['active'] = 1;
        $parameters['idShow'] = $show->getIdShow();
        
        $this->connection = Connection::GetInstance();
        $response = $this->connection->ExecuteNonQuery($query, $parameters);
        return $response;
    }

    public function removeShowFromActive($idShow){
        $query = "Update ".$this->tableNameShows. " SET ".$this->tableNameShows.".isActive = 0 WHERE ".$this->tableNameShows.".idShow = :idShow";         
        $parameters['idShow'] = $idShow;
        $this->connection = Connection::GetInstance();
        return $this->connection ->ExecuteNonQuery($query,$parameters);
    }

    public function getById($id){
        $query = "SELECT * FROM ".$this->tableNameShows." where idShow = :id";
        $parameters['id'] = $id;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $this->parseToObject($resultSet);
    }

    public function getByDateAndMovieId($date, $idMovie){
        $query = "SELECT * FROM ".$this->tableNameShows." where dateSelected = :date and idMovie = :idMovie AND isActive = true;";
        $parameters['date'] = $date;
        $parameters['idMovie'] = $idMovie;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $this->toArray($this->parseToObject($resultSet));
    }

    public function getShowsByRoomAndDate($roomID, $date){
        $query = "SELECT * FROM ".$this->tableNameShows." where dateSelected = :date and idRoom = :idRoom";
        $parameters['date'] = $date;
        $parameters['idRoom'] = $roomID;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $this->toArray($this->parseToObject($resultSet));
    }

    #select ifnull(sum(rooms.capacity), 0) as unsold from shows inner join rooms on shows.idRoom = rooms.idRoom 
    #where shows.idRoom = 3 and shows.dateSelected BETWEEN '2020-11-10' AND '2020-11-12'
    
    public function getCapacityByRoom($idRoom){
        $query = "SELECT IFNULL(SUM(".$this->tableNameRooms.".capacity),0) as unsold FROM ".$this->tableNameShows." 
        inner join ".$this->tableNameRooms." on ".$this->tableNameShows.".idRoom = ".$this->tableNameRooms.".idRoom 
        where ".$this->tableNameShows.".idRoom = :idRoom";
        $parameters['idRoom'] = $idRoom;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        return $resultSet[0]["unsold"];
    }

    public function getCapacityByRoomBetween($idRoom, $firstDate, $lastDate){
        $query = "SELECT IFNULL(SUM(".$this->tableNameRooms.".capacity),0) as unsold FROM ".$this->tableNameShows." 
        inner join ".$this->tableNameRooms." on ".$this->tableNameShows.".idRoom = ".$this->tableNameRooms.".idRoom 
        where ".$this->tableNameShows.".idRoom = :idRoom AND ".$this->tableNameShows.".dateselected BETWEEN \"".$firstDate."\" AND \"".$lastDate."\"";
        $parameters['idRoom'] = $idRoom;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $resultSet[0]["unsold"];
    }

    public function getCapacityByCinema($idCinema){
            $query = "SELECT IFNULL(SUM(".$this->tableNameRooms.".capacity),0) as unsold FROM ".$this->tableNameShows." 
            inner join ".$this->tableNameRooms." on ".$this->tableNameShows.".idRoom = ".$this->tableNameRooms.".idRoom 
            inner join ".$this->tableNameCinemas." on ".$this->tableNameRooms.".idCinema = ".$this->tableNameCinemas.".idCinema 
            where ".$this->tableNameRooms.".idCinema = :idCinema";
            $parameters['idCinema'] = $idCinema;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);

            return $resultSet[0]["unsold"];
        }
    

    public function getCapacityByCinemaBetween($idCinema, $firstDate, $lastDate){
        $query = "SELECT IFNULL(SUM(".$this->tableNameRooms.".capacity),0) as unsold FROM ".$this->tableNameShows." 
        inner join ".$this->tableNameRooms." on ".$this->tableNameShows.".idRoom = ".$this->tableNameRooms.".idRoom 
        inner join ".$this->tableNameCinemas." on ".$this->tableNameRooms.".idCinema = ".$this->tableNameCinemas.".idCinema 
        where ".$this->tableNameRooms.".idCinema = :idCinema AND ".$this->tableNameShows.".dateselected BETWEEN \"".$firstDate."\" AND \"".$lastDate."\"";
        $parameters['idCinema'] = $idCinema;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $resultSet[0]["unsold"];
    }

    //Retorna el nombre del cine dependiendo el show
    public function getCinemaNameFromShows($idShow){
            $query = "SELECT ".$this->tableNameCinemas .".cinemaName FROM ". $this->tableNameShows ." INNER JOIN ". $this->tableNameRooms ." ON ". $this->tableNameRooms .".idRoom = ". $this->tableNameShows .".idRoom INNER JOIN ". $this->tableNameCinemas ." ON ". $this->tableNameCinemas .".idCinema = ". $this->tableNameRooms .".idCinema WHERE ". $this->tableNameShows .".idShow = ". $idShow ." ;";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $resultSet[0]['cinemaName'];
    }   
    

    //Retorna los shows en donde se esté dando la película y las salas con al menos 1 espacio disponible
    public function getShowFromMovieRoom($idMovie){
            $query = "SELECT ". $this->tableNameShows .".* FROM ". $this->tableNameShows ." INNER JOIN " . $this->tableNameRooms ." ON " . $this->tableNameShows .".idRoom = ".$this->tableNameRooms .".idRoom WHERE " . $this->tableNameShows . ".idMovie = :idMovie AND " . $this->tableNameShows .".isActive = 1 AND " . $this->tableNameShows .".spectators < .". $this->tableNameRooms .".capacity;";
            $parameters['idMovie'] = $idMovie;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            return $this->toArray($this->parseToObject($resultSet));
    }

    public function getPriceByIdShow($idShow){
        $query = "SELECT DISTINCT price FROM ". $this->tableNameRooms ." INNER JOIN " . $this->tableNameShows ." ON " . $this->tableNameShows .".idRoom = ".$this->tableNameRooms .".idRoom WHERE " . $this->tableNameShows . ".idShow = :idShow;";
        $parameters['idShow'] = $idShow;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query, $parameters);
        return $resultSet;
    }

    public function getShowsInTimeLapse($roomId,$date,$startingHour,$endingHour){
        
        $query = "SELECT ". $this->tableNameShows .".* FROM ". $this->tableNameShows ." WHERE idRoom = :roomId AND dateSelected = :date AND endsAt >= :startingHour AND startsAt <= :endingHour AND isActive = :isActive;";
        $parameters['isActive'] = true;
        $parameters['roomId'] = $roomId;
        $parameters['date'] = $date;
        $parameters['startingHour'] = $startingHour;
        $parameters['endingHour'] = $endingHour;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query, $parameters);
        return $this->toArray($this->parseToObject($resultSet));

    }

    //Retorna los shows de una sala específica
    public function getIfActiveShows($idRoom){
        $query = "SELECT * FROM ".$this->tableNameShows. " WHERE isActive = :active AND idRoom = :idRoom";
        $parameters['active'] = 1;
        $parameters['idRoom'] = $idRoom;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        $activeRooms = $this->toArray($this->parseToObject($resultSet));
        return $activeRooms;
    }
    

    protected function parseToObject($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){

            $DAOMovie = new DAOMovie();
            $movie = $DAOMovie->getById($p['idMovie']);
            
            $DAORoom = new DAORoom();
            $room = $DAORoom->getById($p['idRoom']);

            $aux = new DateTime($p['dateSelected']);
            $p['dateSelected'] = $aux->format('Y-m-d');

            $aux1 = new DateTime($p['startsAt']);
            $p['startsAt'] = $aux1->format('H:i:s');

            $aux2 = new DateTime($p['endsAt']);
            $p['endsAt'] = $aux2->format('H:i:s');
            return new Show ($p['dateSelected'],$p['startsAt'],$p['endsAt'],$room,$movie,$p['spectators'],$p['isActive'],$p['idShow']);
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