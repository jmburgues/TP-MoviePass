<?php namespace DAO; 
    require_once dirname(__FILE__)."/../Models/Cinema.php";
use Models\Cinema as Cinema;

class DAOCinema {
    private $cinemasList = array();
    private $fileName;

    public function __construct(){
        $this->fileName = dirname(__DIR__) . "/DAO/Data/cinemas.json";
    }

    public function Add($cinema){
        $this->RetrieveData();
        array_push($this->cinemasList, $cinema);
        $this->SaveData();
    }

    /*Función para eliminar un cine.
    * Por el momento lo manejaremos con un borrado total del JSON, cuando comencemos con la base de datos se hará un borrado lógico
    */
    public function Remove($cinema){
        $this->RetrieveData();
        //array_search — Busca un valor determinado en un array y devuelve la primera clave correspondiente en caso de éxito
      //  $key = array_search($cinema, $this->cinemasList, true);
        $key = array_search($cinema, $this->cinemasList);
        unset($this->cinemasList[$key]);
    }

    public function GetAll(){
        $this->RetrieveData();
        return $this->cinemasList;
    }

    private function SaveData(){
        $arrayToEncode = array();
        foreach($this->cinemasList as $cinema){
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

    private function RetrieveData(){
        $this->cinemasList = array();
        if(file_exists($this->fileName))        {
            $jsonContent = file_get_contents($this->fileName);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach($arrayToDecode as $valuesArray)            {
                $cinema = new Cinema($valuesArray["name"], 
                                    $valuesArray["address"], 
                                    $valuesArray["opening"], 
                                    $valuesArray["closing"], 
                                    $valuesArray["ticketValue"]
                                );    
                array_push($this->cinemasList, $cinema);
            }
        }
    }
}