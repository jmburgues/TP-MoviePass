<?php
namespace DB\JSON;
use Models\Movie as Movie;
use Models\Genre as Genre;
use \DateTime as DateTime;
use DB\JSON\DAOGenre as DAOGenre;

class DAOMovie{
  private $movieList;
  private $fileName = ROOT."Data/movies.json";

  public function __construct(){
    $this->DAOGenre = new DAOGenre();
  }

  public function add(Movie $movie){
    $this->retrieveData();
    $exist = $this->GetById($movie->getMovieID());
    if (!isset($exist)) {
      array_push($this->movieList, $movie);
      $this->saveData();
      
    }
  }

  public function getAll(){
    $this->retrieveData();
    return $this->movieList;
  }

  private function retrieveData(){
    $this->movieList = array();
    if(file_exists($this->fileName)){
      $jsonContent = file_get_contents($this->fileName);
      
      $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
      foreach ($arrayToDecode as $valueArray) {
        $genreList = array();
        
        foreach($valueArray['genre'] as $value){
          $genre = new Genre($value['name'],$value['id']);
          array_push($genreList,$genre);
        }
        $movie = new Movie($valueArray['duration'],$valueArray['title'],$genreList,$valueArray['poster'],
          $valueArray['releaseDate'],$valueArray['description'],$valueArray['movieID']);
        array_push($this->movieList, $movie);
      }
    }
  }

  private function saveData(){
    $arrayToEncode = array();
    foreach ($this->movieList as $movie) {
      $valueArray['duration'] = $movie->getDuration();
      $valueArray['title'] = $movie->getTitle();
      
      $genreList = $movie->getGenre();
      $genreArrayToEncode = array();
      
      foreach($genreList as $genre){
        $genreArrayValue['id'] = $genre->getId();
        $genreArrayValue['name'] = $genre->getName();
        array_push($genreArrayToEncode,$genreArrayValue);
      }
      $valueArray['genre'] = $genreArrayToEncode;
      
      $valueArray['poster'] = $movie->getPoster();
      $valueArray['releaseDate'] = $movie->getReleaseDate();
      $valueArray['description'] = $movie->getDescription();
      $valueArray['movieID'] = $movie->getMovieID();
      
      array_push($arrayToEncode, $valueArray);
    }
    $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
    $return = file_put_contents($this->fileName , $jsonContent);
  }

  public function getArrayOfYears(){// returns an array of years where different movies were created
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
   
  public function addMoreLatestMovies(){
    $json = $this->getAll();
    if ((count($json) % 20) == 0){
      $page = (count($json) / 20) + 1;
    }
    else{
      $page = round((count($json) / 20), 0);
    }
    $this->callLatestMoviesFromApi($page);
  }
   
   
  /*Función que trae de la API e invoca funciones del DAO para guardar en archivo JSON */
  public function callLatestMoviesFromApi($page=''){
    //Llamada a la API
    $data = file_get_contents("http://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a&page=".$page);
    
    //Convierte el JSON a un arreglo
    $array = ($data) ? json_decode($data, true) : array();

    //Accede a la clave 'results'
    $result = $array["results"];

    //Recorre el arreglo con los resultados
    foreach ($result as $value) {
      if (is_array($value)) {
        //Trae toda la información de cada película
        $movieData = file_get_contents("https://api.themoviedb.org/3/movie/".$value["id"]."?language=en-US&api_key=601e12bf1e7197e7532eb9c4901b0d3a");
        $movie = ($movieData) ? json_decode($movieData, true) : array();
        $genre = array();

        //De cada película se obtienen los generos y se crea un objeto de éste
        foreach ($movie["genres"] as $genreData) {
          $aux = new Genre($genreData["name"], $genreData["id"]);
          array_push($genre, $aux);
          $this->DAOGenre->add($aux);
        }
        //Se crea el objeto Movie y se agrega al arrelgo
        $newMovie = new Movie($movie["runtime"], $movie["title"], $genre, $movie["poster_path"], $movie["release_date"], $movie["overview"], $movie["id"]);
        $this->add($newMovie);
      }
    }
  }


  public function GetById($id){
    $this->RetrieveData();
    foreach ($this->movieList as $movie){
      if ($movie->getMovieID() == $id) {
        return $movie;
      }
    }
    return null;
  }

}
?>