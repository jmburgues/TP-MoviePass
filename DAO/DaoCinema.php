<?php namespace DAO; // PUEDE QUE ESTE REPOSITORIO LUEGO SEA MODIFICADO POR UNA BASE DE DATOS

use Models\Cinema as Cinema;

class DAOCinema {
    private $cinemasList = array();
    private $fileName;

    public function __construct(){
        $this->fileName = dirname(__DIR__) . "/data/cinemas.json";
    }

    public function Add($cinemaObject){
        $this->RetrieveData();

        array_push($this->cinemasList,$cinemaObject);

        $this->SaveData();
    }

    public function Remove($cinemaObject){
        $this->RetrieveData();

        $objectKey = array_search($cinemaObject,$this->cinemasList,true);
        unset($this->cinemasList[$objectKey]);

        // Hay que decidir si borrar el elemento o modificar el valor "active" a false.
        // si se modifica a false, hay que repensar el Add.
    }

    public function GetAll(){
        $this->RetrieveData();

        return $this->cinemasList;
    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach($this->cinemasList as $cinemaObject)
        {
            $valuesArray["name"] = $cinemaObject->getName();
            $valuesArray["adress"] = $cinemaObject->getAdress();
            $valuesArray["opening"] = $cinemaObject->getOpenning();
            $valuesArray["closing"] = $cinemaObject->getClosing();
            $valuesArray["ticketValue"] = $cinemaObject->getTicketValue();
            $valuesArray["active"] = $cinemaObject->getActive();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents($this->fileName, $jsonContent);
    }

    private function RetrieveData()
    {
        $this->cinemasList = array();

        if(file_exists($this->fileName))
        {
            $jsonContent = file_get_contents($this->fileName);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $cinemaObject = new Cinema($valuesArray["name"], $valuesArray["adress"], 
                                            $valuesArray["opening"], $valuesArray["closing"], 
                                            $valuesArray["ticketValue"], $valuesArray["active"]);
                
                array_push($this->cinemasList, $cinemaObject);
            }
        }
    }
}