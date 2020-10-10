<?php
namespace DAO;
use models\Movie as Movie;
use models\Genre as Genre;

class DAOMovie{
  private $movieList;
  private $fileName = ROOT."Data/movies.json";

  public function add(Movie $movie){
    $this->retrieveData();
    $exist = $this->GetById($movie->getMovieID());
    if (!isset($exist)) {
      $this->saveData();
      array_push($this->movieList, $movie);
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
          $genre = new Genre($value['id'],$value['name']);
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
    file_put_contents($this->fileName , $jsonContent);
  }

  public function GetById($id){
    $this->RetrieveData();
    foreach ($this->movieList as $movie){
      if ($movie->getId() == $id) {
        return $movie;
      }
    }
    return null;
  }

}
?>