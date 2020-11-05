<?php
namespace DAO;
use Models\Show as Show;

class DAOShow{
    private $showList;
    private $fileName = ROOT."Data/shows.json";

  
    public function add($show){
        $this->retrieveData();
        $show->setIdShow($this->generateID());
       // $exist = $this->GetById($show->getshowID());
       // if (!isset($exist)) {
        array_push($this->showList, $show);
        $this->saveData();
       // }
    }

    public function generateID(){
      $this->RetrieveData();
      return count($this->showList) + 1;
  }

    public function getAll(){
        $this->retrieveData();
        return $this->showList;
    }

    private function RetrieveData(){
        $this->showList = array();
        if (file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                $show = new show();
                $show->setIdShow($valuesArray["idShow"]);
                $show->setDate($valuesArray["date"]);
                $show->setHour($valuesArray["hour"]);
                $show->setIdRoom($valuesArray["idRoom"]);
                $show->setSpectators($valuesArray["spectators"]);
                array_push($this->showList, $show);
            }
        }
    }

    public function removeshow($idshow)
    {
        $this->RetrieveData();
        $toDelete = null;
        foreach($this->showList as $list){
            if($list->getshowID() == $idshow){
                unset($this->showList, $list);
            }
        } 
        $this->SaveData();
    }

    public function SaveData(){
        $arrayToEncode = array();
        foreach ($this->showList as $show) {
            $valuesArray["idShow"] = $show->getIdShow();
            $valuesArray["date"] = $show->getDate();
            $valuesArray["hour"] = $show->getHour();
            $valuesArray["idRoom"] = $show->getRoom()->getRoomID();
            $valuesArray["spectators"] = $show->getSpectators();
            array_push($arrayToEncode, $valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

  public function GetById($id){
    $this->RetrieveData();
    foreach ($this->showList as $show){
      if ($show->getshowID() == $id) {
        return $show;
      }
    }
    return null;
  }

}
?>