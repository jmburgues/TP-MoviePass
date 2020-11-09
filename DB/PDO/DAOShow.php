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
    public function add(Show $show)    {
        try 
        {
            $query = "INSERT INTO ".$this->tableNameShows."
            (dateSelected, startsAt, endsAt, spectators, idRoom, idMovie)
            values
            (:date, :start, :end,:spectators, :idRoom, :idMovie );";
            
            $parameters['date'] = $show->getDate();
            $parameters['start'] = $show->getStart();
            $parameters['end'] = $show->getEnd();
            $parameters['spectators'] = 0;
            $parameters['idRoom'] = $show->getRoom()->getRoomID();
            $parameters['idMovie'] = $show->getMovie()->getMovieID();
            
            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
            return $response;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    //SELECT * FROM SHOWS
    public function getAll(){
        try{
            $query = "SELECT * FROM ".$this->tableNameShows;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $this->toArray($this->parseToObject($resultSet));
            }
            catch(Exception $ex){
            throw $ex;
            }
        }

   //SELECT * FROM SHOWS WHERE idActive = 1
    public function getActiveShows(){
        try{
            $query = "SELECT * FROM ".$this->tableNameShows." WHERE isActive = 1";
            //$parameters['active'] = true;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $this->toArray($this->parseToObject($resultSet));
            }
            catch(Exception $ex){
            throw $ex;
            }
        }
        
        //Devuelve el idMovie sin repetir de los shows. Muestra en el home sin repetir la cartelera.
        public function getBillBoard(){
            try{
                $query = "SELECT DISTINCT idMovie FROM ".$this->tableNameShows;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
                return ($resultSet);
                }
                catch(Exception $ex){
                throw $ex;
                } 
        }

    public function modify(Show $show)    {
        try 
        {
            $query = "UPDATE ".$this->tableNameShows." 
            SET dateSelected = :date, startsAt = :start, endsAt = :end, 
            spectators = :spectators, idRoom = :idRoom, idMovie = :idMovie, 
            isActive = :active 
            WHERE idShow = :idShow; ";
            $parameters['date'] = $show->getDate();
            $parameters['start'] = $show->getStart();
            $parameters['end'] = $show->getEnd();
            $parameters['spectators'] = 0;
            $parameters['idRoom'] = $show->getRoom()->getRoomID();
            $parameters['idMovie'] = $show->getMovie()->getMovieID();
            $parameters['active'] = 1;
            $parameters['idShow'] = $show->getIdShow();
            
            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
            return $response;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function removeShowFromActive($idShow){
        try{
            $query = "Update ".$this->tableNameShows. " SET ".$this->tableNameShows.".isActive = 0 WHERE ".$this->tableNameShows.".idShow = :idShow";
            
            $parameters['idShow'] = $idShow;
            $this->connection = Connection::GetInstance();
            return $this->connection ->ExecuteNonQuery($query,$parameters);
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function getById($id){
        try{
            $query = "SELECT * FROM ".$this->tableNameShows." where idShow = :id";
            $parameters['id'] = $id;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            return $this->parseToObject($resultSet);
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function getByDateAndMovieId($date, $idMovie){
    try{
            $query = "SELECT * FROM ".$this->tableNameShows." where dateSelected = :date and idMovie = :idMovie";
            $parameters['date'] = $date;
            $parameters['idMovie'] = $idMovie;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            return $this->toArray($this->parseToObject($resultSet));
        }
        catch(Exception $ex){
            throw $ex;
        }
    }
    
    //Retorna el nombre del cine dependiendo el show
    public function getCinemaNameFromShows($idShow){
        try {
            $query = "SELECT ".$this->tableNameCinemas .".cinemaName FROM ". $this->tableNameShows ." INNER JOIN ". $this->tableNameRooms ." ON ". $this->tableNameRooms .".idRoom = ". $this->tableNameShows .".idRoom INNER JOIN ". $this->tableNameCinemas ." ON ". $this->tableNameCinemas .".idCinema = ". $this->tableNameRooms .".idCinema WHERE ". $this->tableNameShows .".idShow = ". $idShow ." ;";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $resultSet[0]['cinemaName'];
        } catch (Exception $ex) {
            throw $ex;
        }
    }   
    

    //Retorna los shows en donde se esté dando la película y las salas con al menos 1 espacio disponible
    public function getShowFromMovieRoom($idMovie){
        try{
            $query = "SELECT ". $this->tableNameShows .".* FROM ". $this->tableNameShows ." INNER JOIN " . $this->tableNameRooms ." ON " . $this->tableNameShows .".idRoom = ".$this->tableNameRooms .".idRoom WHERE " . $this->tableNameShows . ".idMovie = :idMovie AND " . $this->tableNameShows .".isActive = 1 AND " . $this->tableNameShows .".spectators < .". $this->tableNameRooms .".capacity;";
            $parameters['idMovie'] = $idMovie;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            return $this->toArray($this->parseToObject($resultSet));
            }
            catch(Exception $ex){
            throw $ex;
        }
    }

        public function getPriceByIdShow($idShow){
            try{
                $query = "SELECT DISTINCT price FROM ". $this->tableNameRooms ." INNER JOIN " . $this->tableNameShows ." ON " . $this->tableNameShows .".idRoom = ".$this->tableNameRooms .".idRoom WHERE " . $this->tableNameShows . ".idShow = :idShow;";
                $parameters['idShow'] = $idShow;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters);
                return $resultSet;
                }
                catch(Exception $ex){
                throw $ex;
            }
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