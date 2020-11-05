<?php
  namespace DB\PDO;

  use \DateTime as DateTime;
  use \Exception as Exception;
  use Models\Show as Show;
  use DB\PDO\Connection as Connection;


  class DAOShow{
    private $connection;
    private $tableNameShows = "SHOWS";
    private $tableNameCinemas = "CINEMAS";
    private $tableNameRooms = "ROOMS";
    private $tableNameMovies = "MOVIES";

    public function add($show)    {
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
            $parameters['idRoom'] = $show->getIdRoom();
            $parameters['idMovie'] = $show->getIdMovie();
            
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

            /*
            $query = "UPDATE ".$this->tableNameShows."
            SET dateSelected = :date, startsAt = :start, endsAt = :end, spectators = :spectators, idRoom = :idRoom, idMovie = :idMovie 
            WHERE idShow = :idShow;";
            */
            $query = "SELECT * FROM ".$this->tableNameShows;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $this->toArray($this->parseToObjectTime($resultSet));
            }
            catch(Exception $ex){
            throw $ex;
            }
        }

    public function getActiveShows(){
        try{
            $query = "SELECT * FROM ".$this->tableNameShows." WHERE isActive = 1";
            //$parameters['active'] = true;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $this->toArray($this->parseToObjectTime($resultSet));
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
            SET dateSelected = :date, startsAt = :start, endsAt = :end, spectators = :spectators, idRoom = :idRoom, idMovie = :idMovie, isActive = active 
            WHERE idShow = :idShow;";
            $parameters['date'] = $show->getDate();;
            $parameters['start'] = $show->getStart();
            $parameters['end'] = $show->getEnd();
            $parameters['spectators'] = $show->getSpectators();
            $parameters['idRoom'] = $show->getIdRoom();
            $parameters['idMovie'] = $show->getIdMovie();
            $parameters['active'] = $show->getActive();
            $parameters['idShow'] = $show->getIdShow();
            
            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
            return $response;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function removeShow($id){
        try{
            $query = "Update ".$this->tableNameShows. " SET isActive = :active WHERE idShow = :id;";
            
            $parameters['id'] = $id;
            $parameters['active'] = false;
            
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
            
            return $this->parseToObjectTime($resultSet);
        }
        catch(Exception $ex){
            throw $ex;
        }
    }
    
    
    public function getCinemaNameFromShows($idShow){
        try{
            $query = "SELECT ".$this->tableNameCinemas .".cinemaName FROM ". $this->tableNameShows ." INNER JOIN ". $this->tableNameRooms ." ON ". $this->tableNameRooms .".idRoom = ". $this->tableNameShows .".idRoom INNER JOIN ". $this->tableNameCinemas ." ON ". $this->tableNameCinemas .".idCinema = ". $this->tableNameRooms .".idCinema WHERE ". $this->tableNameShows .".idShow = ". $idShow ." ;";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $resultSet[0]['cinemaName'];
            }
            catch(Exception $ex){
            throw $ex;
            }
    }

        //Retorna los shows en donde se esté dando la película
        public function getShowFromMovie($idMovie){
            try{
                $query = "SELECT ". $this->tableNameShows .".* FROM ". $this->tableNameShows ." INNER JOIN " . $this->tableNameRooms ." ON " . $this->tableNameShows .".idRoom = ".$this->tableNameRooms .".idRoom WHERE " . $this->tableNameShows . ".idMovie = :idMovie AND " . $this->tableNameShows .".isActive = 1;";
                $parameters['idMovie'] = $idMovie;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters);
                return $this->toArray($this->parseToObjectTime($resultSet));
                }
                catch(Exception $ex){
                throw $ex;
            }
        }

    //Los valores de la query los vuelve objeto
    protected function parseToObject($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){

            return new Show ($p['dateSelected'],$p['startsAt'],$p['endsAt'],$p['idRoom'],$p['idMovie'],$p['spectators'],$p['idShow']);
            }, $value);

        if(empty($resp)){
            return $resp;
        }
        else {
        return count($resp) > 1 ? $resp : $resp['0'];
        }
    }

    //Los valores de la query los vuelve objeto y formatea los datos de tipo time
    protected function parseToObjectTime($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){
            $aux = new DateTime($p['dateSelected']);
            $p['dateSelected'] = $aux->format('Y-m-d');

            $aux1 = new DateTime($p['startsAt']);
            $p['startsAt'] = $aux1->format('H:i:s');

            $aux2 = new DateTime($p['endsAt']);
            $p['endsAt'] = $aux2->format('H:i:s');
            return new Show ($p['dateSelected'],$p['startsAt'],$p['endsAt'],$p['idRoom'],$p['idMovie'],$p['spectators'],$p['isActive'],$p['idShow']);
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