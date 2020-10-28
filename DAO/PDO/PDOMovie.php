<?php
  namespace DAO\PDO;

  use \Exception as Exception;
  use Models\Movie as Movie;
  use Models\Genre as Genre;
  use DAO\PDO\Connection as Connection;
  use DAO\PDO\PDOGenre as PDOGenre;

  class PDOMovie{
    private $connection;
    private $tableNameGenres ='GENRES';
    private $tableNameMovies ='MOVIES';
    private $tableNameMoviesGenres ='GENRES_X_MOVIES';

    public function add($movie){
      try{
        $query = "INSERT INTO ".$this->tableNameMovies." 
        (idMovie,duration,title,poster,releaseDate,movieDescription)
        values
        (:movieID, :duration, :title,:poster, :releaseDate, :description);";

        $parameters['movieID'] = $movie->getMovieID();
        $parameters['duration'] = $movie->getDuration();
        $parameters['title'] = $movie->getTitle();
        $parameters['poster'] = $movie->getPoster();
        $parameters['releaseDate'] = $movie->getReleaseDate();
        $parameters['description'] = $movie->getDescription();

        $this->connection = Connection::GetInstance();
        $response = $this->connection->ExecuteNonQuery($query, $parameters);

        $parameters = array();
        $genreList = $movie->getGenre();

        foreach ($genreList as $genre) {

          $pdoGenre = new PDOGenre();

          if(!($pdoGenre->getByid($genre->getId()))){
            $pdoGenre->add($genre);
          }

          $query =  "INSERT INTO " . $this->tableNameMoviesGenres . " (idMovie, idGenre) VALUES (:movieID, :genreID);";
          $parameters['movieID'] = $movie->getMovieID();
          $parameters['genreID'] = $genre->getId();

          $this->connection = Connection::GetInstance();
          $this->connection->ExecuteNonQuery($query, $parameters);
        }
        return $response;
      }

      catch(Exception $ex){
        throw $ex;
      }

    }
    public function getAll(){
      try{
        $query = "SELECT * FROM ".$this->tableNameMovies;
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
        $query= "SELECT * FROM ".$this->tableNameMovies." WHERE idMovie = :movieID;";
        $parameters['movieID'] = $id;
      
        $this->connection = Connection::GetInstance();
      
        $resultSet = $this->connection->Execute($query,$parameters);
        
        return $this->parseToObject($resultSet);
      }
      catch(Exception $ex){
          throw $ex;
      }
    }
    #Seguir trabajando en este
    private function parseToObject($value){
			$value = is_array($value) ? $value : [];
      try {
        $resp = array_map(function($p){
        $genres = array();
        
        $query = "SELECT * FROM ".$this->tableNameMoviesGenres." where idMovie = :movieID;";
        $parameters['movieID'] = $p['idMovie'];
         
        $this->connection = Connection::GetInstance();
         
        $genresIdList = $this->connection->Execute($query,$parameters);
         
        $pdoGenre = new PDOGenre();
        
        foreach ($genresIdList as $genreId) {
           
          $genre = $pdoGenre->getById($genreId['idGenre']);
          
          array_push($genres, $genre);
        }
          
          return new Movie($p['duration'],$p['title'],$genres,$p['poster'],$p['releaseDate'], $p['movieDescription'], $p['idMovie']);
        }, $value);
           
        if(empty($resp)){
          return $resp;
        }
        else {
          return count($resp) > 1 ? $resp : $resp['0'];
        }
      } catch (Exception $e) {
          throw $e;
      }  
		}
  }
?>