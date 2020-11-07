<?php
namespace DB\JSON;
use Models\Genre as Genre;

class DAOgenre{
  private $genreList;
  private $fileName = ROOT."Data/genres.json";

  public function add(Genre $genre){
    $this->retrieveData();
    $exist = $this->GetById($genre->getId());
    if (!isset($exist)) {
      array_push($this->genreList, $genre);
      $this->saveData();
    }
  }

  public function getAll(){
    $this->retrieveData();
    return $this->genreList;
  }

  public function getGenresList(){ // returns an array of strings with all movie's genres. (1st revision)
    
    $genres = array();

    $objectsList = $this->getAll();

    foreach($objectsList as $oneGenre){
      array_push($genres,$oneGenre);
    }
    
    return $genres;
  }

  private function retrieveData(){
    $this->genreList = array();
    if(file_exists($this->fileName)){
      $jsonContent = file_get_contents($this->fileName);
      $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
      foreach ($arrayToDecode as $valueArray) {
        
        $genre = new genre($valueArray['name'],$valueArray['id']);
        array_push($this->genreList, $genre);
      }
    }
  }

  private function saveData(){
    $arrayToEncode = array();
    foreach ($this->genreList as $genre) {
      $valueArray['id'] = $genre->getId();
      $valueArray['name'] = $genre->getName();
      
      array_push($arrayToEncode, $valueArray);
    }
    $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
    file_put_contents($this->fileName , $jsonContent);
  }

  public function GetById($id){
    $this->RetrieveData();
    foreach ($this->genreList as $genre){
      if ($genre->getId() == $id) {
        return $genre;
      }
    }
    return null;
  }
}
?>
