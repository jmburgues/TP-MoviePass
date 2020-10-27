<?php
  namespace DAO\PDO;

  use \Exception as Exception;
  use Models\Show as Show;
  use Models\Movie as Movie;
  use DAO\PDO\Connection as Connection;


  class PDOShow{
    private $connection;
    private $tableNameShows = "SHOWS";

    public function add($show)    {
        try 
        {
            $query = "INSERT INTO ".$this->tableNameShows."
            (dateSelected, startsAt, endsAt, spectators, idRoom, idMovie)
            values
            (:date, :start, :end,:spectators, :idRoom, :idMovie);";
            
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
            $query = "SELECT * FROM ".$this->tableNameShows;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $this->parseToObject($resultSet);
            }
            catch(Exception $ex){
            throw $ex;
            }
        }

    public function getActiveShows(){
        try{
            $query = "SELECT * FROM ".$this->tableNameShows " WHERE isActive = :active";
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

            return new Show ($p['dateSelected'],$p['startsAt'],$p['endsAt'],$p['idRoom'],$p['idMovie'],$p['spectators'],$p['isActive'],$p['idShow']);
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