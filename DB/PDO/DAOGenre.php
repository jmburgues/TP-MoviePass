<?php
  namespace DB\PDO;

  use \Exception as Exception;
  use Models\Genre as Genre;
  use DB\PDO\Connection as Connection;
  use DB\Interfaces\IDAOGenre as IDAOGenre;

  class DAOGenre implements IDAOGenre{
    private $connection;
    private $tableName ='GENRES';
    private $tableNameGenresXMovies = "GENRES_X_MOVIES";
    private $tableNameShows = "SHOWS";
    private $tableNameMovies = "MOVIES";


    //INSERT INTO
    public function add(Genre $genre){
        $query = "INSERT INTO ".$this->tableName." 
        (idGenre,genreName)
        values
        (:id, :name);";

        $parameters['id'] = $genre->getId();
        $parameters['name'] = $genre->getName();

        $this->connection = Connection::GetInstance();

        return $this->connection->ExecuteNonQuery($query, $parameters);
    }
    
    //SELECT * FROM GENRES
    public function getAll(){
      $query = "SELECT * FROM ".$this->tableName;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);
      
      return $this->toArray($this->parseToObject($resultSet));
    }

    //SELECT * FROM GENRES WHERE id
    public function getById($id){
      $query = "SELECT * FROM ".$this->tableName." where idGenre = :id";
      $parameters['id'] = $id;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query,$parameters);
      
      return $this->parseToObject($resultSet);   
    }

    //no se está usando, cambio a objetos
    public function getGenresList(){
      $query = "SELECT genreName FROM ".$this->tableName;
      $this->connection = Connection::GetInstance();
      return $resultSet = $this->connection->Execute($query);

    }

    //JOIN DE GENRES + GXM + SHOWS
    public function getGenresListFromShows(){

        $query = "SELECT GENRES.* FROM ".$this->tableName." LEFT JOIN ".$this->tableNameGenresXMovies." ON ".$this->tableName.".idGenre=".$this->tableNameGenresXMovies.".idGenre INNER JOIN ".$this->tableNameShows." ON ".$this->tableNameGenresXMovies.".idMovie = ".$this->tableNameShows.".idMovie WHERE ".$this->tableNameShows.".isActive = 1 GROUP BY idGenre;";
        $this->connection = Connection::GetInstance();
      
        $resultSet = $this->connection->Execute($query);

        $resultSet =  $this->toArray($this->parseToObject($resultSet));
        return $resultSet;
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