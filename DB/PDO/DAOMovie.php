<?php
  namespace DB\PDO;

  use \Exception as Exception;
  use Models\Movie as Movie;
  use Models\Genre as Genre;
  use DB\PDO\Connection as Connection;
  use DB\PDO\DAOGenre as DAOGenre;
  use DB\Interfaces\IDAOMovie as IDAOMovie;
  use \DateTime as DateTime;

  class DAOMovie implements IDAOMovie{
    private $connection;
    private $tableNameGenres ='GENRES';
    private $tableNameShows = 'SHOWS';
    private $tableNameMovies ='MOVIES';
    private $tableNameMoviesGenres ='GENRES_X_MOVIES';

    public function add(Movie $movie){
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

          $DAOGenre = new DAOGenre();

          if(!($DAOGenre->getByid($genre->getId()))){
            $DAOGenre->add($genre);
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
        
        return $this->toArray($this->parseToObject($resultSet));
      }

      catch(Exception $ex){
        throw $ex;
      }

    }

      //Retorna una película según su ID
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

    //Retorna un arrelgo de strings con los años de todas las películas
    public function getArrayOfYears(){
      $moviesList = $this->getAll();
      $years = array();

      foreach ($moviesList as $oneMovie) {
        $releaseDate = $oneMovie->getReleaseDate();
        
        $releaseYear = DateTime::createFromFormat('Y-m-d', $releaseDate)->format('Y'); 
        
        if (!in_array($releaseYear, $years)) {
          array_push($years, $releaseYear);
        }
      }
      return $years; 
    }


    //Retorna un arrelgo de strings con los años de todas las películas según los shows
    public function getArrayOfYearsFromShows(){
      try{
        $query = "SELECT MOVIES.* FROM ".$this->tableNameMovies." INNER JOIN ".$this->tableNameShows." ON ".$this->tableNameMovies.".idMovie=".$this->tableNameShows.".idMovie";
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);
        $moviesList = $this->toArray($this->parseToObject($resultSet));
      }

      catch(Exception $ex){
        throw $ex;
      }

      $years = array();

      foreach ($moviesList as $oneMovie) {
        $releaseDate = $oneMovie->getReleaseDate();
        
        $releaseYear = DateTime::createFromFormat('Y-m-d', $releaseDate)->format('Y'); 
        
        if (!in_array($releaseYear, $years)) {
          array_push($years, $releaseYear);
        }
      }
      return $years;
    }


    //Retorna las películas que se encuentrn en un Shows, (no solo el ID)
    public function getIdMoviesFromShows(){
      try{

          $query = "SELECT MOVIES.* FROM ".$this->tableNameMovies." INNER JOIN ".$this->tableNameShows." ON ".$this->tableNameMovies.".idMovie=".$this->tableNameShows.".idMovie";
          $this->connection = Connection::GetInstance();
          $resultSet = $this->connection->Execute($query);
          return $this->toArray($this->parseToObject($resultSet));
          }
          catch(Exception $ex){
          throw $ex;
      }
    }

    //Devuelve las películas según el id de género.
    public function getMoviesByGenre($idGenre){
      try{
        $query = "SELECT * FROM " .$this->tableNameMovies." INNER JOIN ".$this->tableNameMoviesGenres." ON ".$this->tableNameMovies.".idMovie=".$this->tableNameMoviesGenres.".idMovie INNER JOIN ". $this->tableNameShows ." ON ". $this->tableNameShows .".idMovie = ". $this->tableNameMovies .".idMovie WHERE idGenre = ".$idGenre." GROUP BY ".$this->tableNameMovies.".idMovie;";
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);
        return $this->toArray($this->parseToObject($resultSet));
        }
        catch(Exception $ex){
        throw $ex;
        }
    }

    //Devulve todas las películas según el año
    public function getByYear($year){
      try{        
        $query = "SELECT * FROM " .$this->tableNameMovies. " WHERE releaseDate LIKE \"". $year."%\"";
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);
        return $this->toArray($this->parseToObject($resultSet));
        }
        catch(Exception $ex){
        throw $ex;
        }
    }

    //Devulve las películas que tengan un showlos shows según el año
    public function getByYearFromShows($year){
      try{        
          //SELECT * FROM SHOWS INNER JOIN MOVIES ON SHOWS.idMovie = MOVIES.idMovie WHERE MOVIES.releaseDate LIKE "2020%" GROUP BY SHOWS.idMovie;
          $query = "SELECT MOVIES.* FROM " .$this->tableNameShows. " INNER JOIN " . $this->tableNameMovies . " ON " . $this->tableNameShows . ".idMovie = " .$this->tableNameMovies .".idMovie WHERE " .$this->tableNameMovies. ".releaseDate LIKE \"". $year."%\" GROUP BY " .$this->tableNameShows . ".idMovie;";
          //$query = "SELECT MOVIES.* FROM " .$this->tableNameShows. " INNER JOIN " . $this->tableNameMovies . " ON " . $this->tableNameShows . ".idMovie = " .$this->tableNameMovies .".idMovie WHERE " .$this->tableNameMovies. ".releaseDate LIKE ':year%' GROUP BY " .$this->tableNameShows . ".idMovie;";
         // $parameters['year'] = $year;
          $this->connection = Connection::GetInstance();
        //  $resultSet = $this->connection->Execute($query, $parameters);
        $resultSet = $this->connection->Execute($query);
          return $this->toArray($this->parseToObject($resultSet));
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
         
        $DAOGenre = new DAOGenre();
        
        foreach ($genresIdList as $genreId) {
           
          $genre = $DAOGenre->getById($genreId['idGenre']);
          
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
    private function toArray($value){
      if(is_array($value))
        return $value;
      else
        return array($value);
    }
  }
?>