<?php
  namespace DB\PDO;

  use \Exception as Exception;
  use Models\Genre as Genre;
  use DB\PDO\Connection as Connection;

  class DAOGenre{
    private $connection;
    private $tableName ='GENRES';
    private $tableNameGenresXMovies = "GENRES_X_MOVIES";
    private $tableNameShows = "SHOWS";

    public function add($genre){
      try{
        $query = "INSERT INTO ".$this->tableName." 
        (idGenre,genreName)
        values
        (:id, :name);";

        $parameters['id'] = $genre->getId();
        $parameters['name'] = $genre->getName();

        $this->connection = Connection::GetInstance();

        return $this->connection->ExecuteNonQuery($query, $parameters);
      }

      catch(Exception $ex){
        throw $ex;
      }
    }
    //este
    public function getAll(){
      try{
        $query = "SELECT * FROM ".$this->tableName;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);
        
        return $this->toArray($this->parseToObject($resultSet));
      }

      catch(Exception $ex){
        throw $ex;
      }

    }

    public function getById($id){
      try{
        $query = "SELECT * FROM ".$this->tableName." where idGenre = :id";
        $parameters['id'] = $id;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $this->parseToObject($resultSet);
      }

      catch(Exception $ex){
        throw $ex;
      }
      
    }

    //no se está usando
    public function getGenresList(){
      try {
        $query = "SELECT genreName FROM ".$this->tableName;
        $this->connection = Connection::GetInstance();
        return $resultSet = $this->connection->Execute($query);
      } 
      catch (Exception $ex) {
        throw $ex;
      }

    }

    public function getGenresListFromShows(){
      try{
        $query = "SELECT GENRES.* FROM ".$this->tableName." LEFT JOIN ".$this->tableNameGenresXMovies." ON ".$this->tableName.".idGenre=".$this->tableNameGenresXMovies.".idGenre INNER JOIN ".$this->tableNameShows." ON ".$this->tableNameGenresXMovies.".idMovie = ".$this->tableNameShows.".idMovie GROUP BY idGenre";
        $this->connection = Connection::GetInstance();
       
        $resultSet = $this->connection->Execute($query);
       //print_r($resultSet);
        $resultSet =  $this->toArray($this->parseToObject($resultSet));
        return $resultSet;

      }

      catch(Exception $ex){
        throw $ex;
      }


    }

    protected function parseToObject($value) {
			$value = is_array($value) ? $value : [];
			$resp = array_map(function($p){
      
				return new Genre ($p['genreName'],$p['idGenre']);
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