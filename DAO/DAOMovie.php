<?php
namespace DAO;
use models\Movie as Movie;
use models\Genre as Genre;

class DAOMovie{
  private $movieList;
  private $fileName = ROOT."Data/students.json";

  public function add(Movie $movie){
    $this->retrieveData();
    array_push($this->movieList, $movie);
    $this->saveData();
  }

  public function getAll(){
    $this->retrieveData();
    return $this->movieList;
  }

  private function retrieveData(){
    $this->movieList = array();
    if(file_exists($fileName)){
      $jsonContent = file_get_contents($fileName);
      $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
      foreach ($arrayToDecode as $valueArray) {
        $genreList = array();
        
        foreach($valueArray['genre'] as $value){
          $genre = new Genre($value['name'],$value['id']);
          array_push($genreList,$genre);
        }
        $movie = new Movie($valueArray['id'],$valueArray['name'],$valueArray['runtime'],
          $valueArray['language'],$genreList,$valueArray['imageURL'] );
        array_push($this->movieList, $movie);
      }
    }
  }

  private function saveData(){
    $arrayToEncode = array();
    foreach ($this->movieList as $movie) {
      $valueArray['movieID'] = $movie->getMovieID();
      $valueArray['title'] = $movie->getTitle();
      $valueArray['duration'] = $movie->getDuration();
      $valueArray['poster'] = $movie->getPoster();
      
      $genreList = $movie->getGenre();
      $genreArrayToEncode = array();
      
      foreach($genreList as $genre){
        $genreArrayValue['name'] = $genre->getName();
        $genreArrayValue['id'] = $genre->getApiKey();
        array_push($genreArrayToEncode,$genreArrayValue);
      }
      $valueArray['genre'] = $genreArrayToEncode;
      
      
      array_push($arrayToEncode, $valueArray);
    }
    $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
    file_put_contents($fileName , $jsonContent);
  }

}
?>