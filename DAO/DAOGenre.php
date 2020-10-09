<?php
namespace DAO;
use models\Genre as Genre;

class DAOgenre{
  private $genreList;
  private $fileName = ROOT."Data/genre.json";

  public function add(Genre $genre){
    $this->retrieveData();
    array_push($this->genreList, $genre);
    $this->saveData();
  }

  public function getAll(){
    $this->retrieveData();
    return $this->genreList;
  }

  private function retrieveData(){
    $this->genreList = array();
    if(file_exists($fileName)){
      $jsonContent = file_get_contents($fileName);
      $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
      foreach ($arrayToDecode as $valueArray) {
        
        $genre = new genre($valueArray['id'],$valueArray['name']);
        array_push($this->genreList, $genre);
      }
    }
  }

  private function saveData(){
    $arrayToEncode = array();
    foreach ($this->genreList as $genre) {
      $valueArray['genreID'] = $genre->getGenreId();
      $valueArray['name'] = $genre->getName();
      
      array_push($arrayToEncode, $valueArray);
    }
    $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
    file_put_contents($fileName , $jsonContent);
  }

}
?>