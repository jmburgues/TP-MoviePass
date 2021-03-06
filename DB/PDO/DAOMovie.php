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

    //INSERT INTO MOVIES
    public function add(Movie $movie){
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

    //SELECT * FROM MOVIES
    public function getAll(){
      $query = "SELECT * FROM ".$this->tableNameMovies." ORDER BY title ASC";
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);
      
      return $this->toArray($this->parseToObject($resultSet));
    }

    //Retorna una película según su ID
    //SELECT * FROM MOVIES WHERE ID = ID
    public function getById($id){
      $query= "SELECT * FROM ".$this->tableNameMovies." WHERE idMovie = :movieID;";
      $parameters['movieID'] = $id;
    
      $this->connection = Connection::GetInstance();
    
      $resultSet = $this->connection->Execute($query,$parameters);
      
      return $this->parseToObject($resultSet);

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
    //INNER JOIN MOVIES + SHOWS
    public function getArrayOfYearsFromShows(){
      $query = "SELECT MOVIES.* FROM ".$this->tableNameMovies." INNER JOIN ".$this->tableNameShows." ON ".$this->tableNameMovies.".idMovie=".$this->tableNameShows.".idMovie WHERE ".$this->tableNameShows.".isActive = 1";
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);
      $moviesList = $this->toArray($this->parseToObject($resultSet));

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
    //INNER JOIN MOVIES + SHOWS
    public function getIdMoviesFromShows(){
      $query = "SELECT MOVIES.* FROM ".$this->tableNameMovies." INNER JOIN ".$this->tableNameShows." ON ".$this->tableNameMovies.".idMovie=".$this->tableNameShows.".idMovie";
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);
      return $this->toArray($this->parseToObject($resultSet));
    }

    //Devuelve las películas según el id de género.
    //INNER JOIN MOVIES + MXG + SHOWS
    public function getMoviesByGenre($idGenre){
      $query = "SELECT * FROM " .$this->tableNameMovies." INNER JOIN ".$this->tableNameMoviesGenres." ON ".$this->tableNameMovies.".idMovie=".$this->tableNameMoviesGenres.".idMovie INNER JOIN ". $this->tableNameShows ." ON ". $this->tableNameShows .".idMovie = ". $this->tableNameMovies .".idMovie WHERE idGenre = ".$idGenre." GROUP BY ".$this->tableNameMovies.".idMovie;";
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);
      return $this->toArray($this->parseToObject($resultSet));
    }

    //Devulve todas las películas según el año
    //SELECT * FROM MOVIES WHERE year
    public function getByYear($year){
      $query = "SELECT * FROM " .$this->tableNameMovies. " WHERE releaseDate LIKE \"". $year."%\"";
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);
      return $this->toArray($this->parseToObject($resultSet));
    }

    //Devulve las películas que tengan un showlos shows según el año

    public function getByYearFromShows($year){
      //SELECT * FROM SHOWS INNER JOIN MOVIES ON SHOWS.idMovie = MOVIES.idMovie WHERE MOVIES.releaseDate LIKE "2020%" GROUP BY SHOWS.idMovie;
      $query = "SELECT ".$this->tableNameMovies.".* FROM ".$this->tableNameShows. " INNER JOIN " . $this->tableNameMovies . " ON " . $this->tableNameShows . ".idMovie = " .$this->tableNameMovies .".idMovie WHERE " .$this->tableNameMovies. ".releaseDate LIKE \"". $year."%\" GROUP BY " .$this->tableNameShows . ".idMovie;";
      //$query = "SELECT MOVIES.* FROM " .$this->tableNameShows. " INNER JOIN " . $this->tableNameMovies . " ON " . $this->tableNameShows . ".idMovie = " .$this->tableNameMovies .".idMovie WHERE " .$this->tableNameMovies. ".releaseDate LIKE ':year%' GROUP BY " .$this->tableNameShows . ".idMovie;";
      // $parameters['year'] = $year;
      $this->connection = Connection::GetInstance();
      //  $resultSet = $this->connection->Execute($query, $parameters);
      $resultSet = $this->connection->Execute($query);
      return $this->toArray($this->parseToObject($resultSet));
      }

    //Retorna la película que se esten dando en ese show
    //INNER JOIN MOVIES + SHOWS idMovie
    public function getMoviesFromShow($idMovie){
      $query = "SELECT DISTINCT ". $this->tableNameMovies .".* FROM ". $this->tableNameShows ." INNER JOIN " . $this->tableNameMovies ." ON " . $this->tableNameShows .".idMovie = ".$this->tableNameMovies .".idMovie WHERE " . $this->tableNameShows . ".idMovie = :idMovie AND " . $this->tableNameShows .".isActive = 1;";
      $parameters['idMovie'] = $idMovie;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query, $parameters);
      return $this->toArray($this->parseToObject($resultSet));
    }

   //Retorna la película que se esten dando en ese show en base al show
   //INNER JOIN MOVIES + SHOWS
    public function getMovieFromShowByIdShow($idShow){
      $query = "SELECT ".$this->tableNameMovies.".* FROM ". $this->tableNameMovies ." INNER JOIN " . $this->tableNameShows ." ON " . $this->tableNameMovies .".idMovie = ".$this->tableNameShows .".idMovie WHERE " . $this->tableNameShows . ".idShow= :idShow AND " . $this->tableNameShows .".isActive = 1;";
      $parameters['idShow'] = $idShow;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query, $parameters);
      return $this->toArray($this->parseToObject($resultSet));
    }

    #Seguir trabajando en este
    private function parseToObject($value){
      $value = is_array($value) ? $value : [];
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
    }

    private function toArray($value){
      if(is_array($value))
        return $value;
      else
        return array($value);
    }
}

?>