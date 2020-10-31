<?php
namespace DAO;
use Models\Movie as Movie;
use Models\Genre as Genre;
use \DateTime as DateTime;

class DAOMovie{
  private $movieList;
  private $fileName = ROOT."Data/movies.json";

  
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

  public function getArrayOfYears(){// returns an array of years where different movies where created
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