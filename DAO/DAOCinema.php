<?php namespace DAO;

    require_once dirname(__FILE__)."/../Models/Cinema.php";
    
    use Models\Cinema as Cinema;

class DAOCinema
{
    private $cinemasList = array();
    private $fileName;

    public function __construct()
    {
        $this->fileName = ROOT."Data/cinemas.json";
    }

    public function Add($cinema)
    {
        $this->RetrieveData();
        $cinema->setId($this->generateID());
        array_push($this->cinemasList, $cinema);
        $this->SaveData();
    }

    /**
     * Remove
     * Trae el arreglo del JSON, busca el cine según su id, lo elimina y vuelve a guardar el JSON
     */
    public function removeCinema($id)
    {
        $this->RetrieveData();
        print_r($this->cinemasList);
        echo ($id);
        $toDelete;
        foreach($this->cinemasList as $list){
            if($list->getId() == $id){
                $toDelete = $list;
            }
        } 
        $key = array_search($toDelete, $this->cinemasList);
        unset($this->cinemasList[$key]);
        $this->SaveData();
    }


    /**Retorna el objeto cine para ponerlo como placeholder en el form de modificar */
    public function modifyCinema($id){
        $this->RetrieveData();
        foreach($this->cinemasList as $list){
            if($list->getId() == $id){
                $cinema = $list;
            }
        } 
        return($list);
    }


    public function modify($cinema){
        echo "<br>";
        echo "Print de modify, lo que llega";
        print_r($cinema);
        echo $cinema["id"];
        echo "<br>";
        $this->RetrieveData();
        foreach($this->cinemasList as $list){
            if($list->getId() == $cinema["id"]){
                echo "<br>";
                echo "get id";
                echo $list->getId();
                echo "id";
                echo  $cinema["id"];
                echo "<br>";
                $list = $cinema;
                //$this->cinemaList = array_replace($this->cinemaList, array());
                $this->SaveData();
            }
        } 
        
    }



    public function generateID(){
        $this->RetrieveData();
        return count($this->cinemasList) + 1;
    }

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->cinemasList;
    }


    public function SaveData()
    {
        $arrayToEncode = array();
        foreach ($this->cinemasList as $cinema) {
            $valuesArray["id"] = $cinema->getId();
            $valuesArray["name"] = $cinema->getName();
            $valuesArray["address"] = $cinema->getAddress();
            $valuesArray["opening"] = $cinema->getOpenning();
            $valuesArray["closing"] = $cinema->getClosing();
            $valuesArray["ticketValue"] = $cinema->getTicketValue();
            array_push($arrayToEncode, $valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

    private function RetrieveData()
    {
        $this->cinemasList = array();
        if (file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                $cinema = new Cinema();
                $cinema->setId($valuesArray["id"]);
                $cinema->setName($valuesArray["name"]);
                $cinema->setAddress($valuesArray["address"]);
                $cinema->setOpenning($valuesArray["opening"]);
                $cinema->setClosing($valuesArray["closing"]);
                $cinema->setTicketValue($valuesArray["ticketValue"]);
                array_push($this->cinemasList, $cinema);
            }
        }
    }
}
