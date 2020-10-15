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
        $cinema->setActive(true);
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
        $toDelete = null;
        foreach($this->cinemasList as $list){
            if($list->getId() == $id){
                $list->setActive(false);
            }
        } 
        $this->SaveData();
    }


    /**Retorna el objeto cine para ponerlo como placeholder en el form de modificar */
    public function placeholderCinemaDAO($id){
        $this->RetrieveData();
        foreach($this->cinemasList as $list){
            if($list->getId() == $id){
                $cinema = $list;
            }
        } 
        return($cinema);
    }

    public function modify( Cinema $cinema){
        $this->RetrieveData();
        foreach($this->cinemasList as &$list){   
            if($list->getId() == $cinema->getId()){
                $list = $cinema;    
                $this->SaveData();
            }
        }
    }


    public function generateID(){
        $this->RetrieveData();
        return count($this->cinemasList) + 1;
    }

    public function getAll()
    {
        $this->RetrieveData();
        return $this->cinemasList;
    }

    public function getActiveCinemas(){
        $cinemasList = array();
        $allCinemas = $this->getAll();
        foreach($allCinemas as $oneCinema){
            if($oneCinema->getActive())
            array_push($cinemasList,$oneCinema);
        }

        return $cinemasList;
    }

    public function SaveData()
    {
        $arrayToEncode = array();
        foreach ($this->cinemasList as $cinema) {
            $valuesArray["id"] = $cinema->getId();
            $valuesArray["name"] = $cinema->getName();
            $valuesArray["address"] = $cinema->getAddress();
            $valuesArray["number"] = $cinema->getNumber();
            $valuesArray["opening"] = $cinema->getOpenning();
            $valuesArray["closing"] = $cinema->getClosing();
            $valuesArray["ticketValue"] = $cinema->getTicketValue();
            $valuesArray["active"] = $cinema->getActive();
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
                $cinema->setNumber($valuesArray["number"]);
                $cinema->setOpenning($valuesArray["opening"]);
                $cinema->setClosing($valuesArray["closing"]);
                $cinema->setTicketValue($valuesArray["ticketValue"]);
                $cinema->setActive($valuesArray["active"]);
                array_push($this->cinemasList, $cinema);
            }
        }
    }
}
