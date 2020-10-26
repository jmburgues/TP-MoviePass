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
            (idShow, startsAt, dateSelected, spectators, idRoom, idMovie)
            values
            (:idShow, :hour, :date, :spectators, :idshow, :idMovie);";

            $parameters['idShow'] = $show->getIdShow();
            $parameters['hour'] = $show->getHour();
            $parameters['date'] = $show->getDate();
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


    public function update($show)    {
        try 
        {
            $query = "UPDATE ".$this->tableNameShows."
            SET dateSelected = :date, startsAt = :hour, spectators = :spectators, idshow = :idshow idMovie = :idMovie, WHERE idShow = :idShow;";
            $parameters['hour'] = $show->getHour();
            $parameters['date'] = $show->getDate();
            $parameters['spectators'] = $show->getSpectators();
            $parameters['idshow'] = $show->getIdshow();
            $parameters['idMovie'] = $show->getIdMovie();
            
            $this->connection = Connection::GetInstance();
            $response = $this->connection->ExecuteNonQuery($query, $parameters);
            return $response;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

}
?>