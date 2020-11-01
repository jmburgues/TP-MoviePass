<?php
  namespace DB\PDO;

  use \DateTime as DateTime;
  use \Exception as Exception;
  use Models\Show as Show;
  use DB\PDO\Connection as Connection;


  class DAOShow{
    private $connection;
    private $tableNameShows = "SHOWS";

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
            $parameters['spectators'] = $show->getSpectators();
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
            return $this->parseToObjectTime($resultSet);
            }
            catch(Exception $ex){
            throw $ex;
            }
        }

    public function getActiveShows(){
        try{
            $query = "SELECT * FROM ".$this->tableNameShows. " WHERE isActive = :active";
            $parameters['active'] = true;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $this->parseToObject($resultSet);
            }
            catch(Exception $ex){
            throw $ex;
            }
        }

    public function modify($show)    {
        try 
        {
            $query = "UPDATE ".$this->tableNameShows."
            SET dateSelected = :date, startsAt = :start, endsAt = :end, spectators = :spectators, idRoom = :idRoom, idMovie = :idMovie 
            WHERE idShow = :idShow;";

            $parameters['idShow'] = $show->getIdShow();
            $parameters['date'] = $show->getDate();;
            $parameters['start'] = $show->getStart();
            $parameters['end'] = $show->getEnd();
            $parameters['spectators'] = $show->getSpectators();
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

    protected function parseToObjectTime($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){
            $aux = new DateTime($p['dateSelected']);
            $p['dateSelected'] = $aux->format('Y-m-d');

            $aux1 = new DateTime($p['startsAt']);
            $p['startsAt'] = $aux1->format('H:i:s');

            $aux2 = new DateTime($p['endsAt']);
            $p['endsAt'] = $aux2->format('H:i:s');
            return new Show ($p['dateSelected'],$p['startsAt'],$p['endsAt'],$p['idRoom'],$p['idMovie'],$p['spectators'],$p['idShow']);
            }, $value);

        if(empty($resp)){
            return $resp;
        }
        else {
        return count($resp) > 1 ? $resp : $resp['0'];
        }
    }

}
?>