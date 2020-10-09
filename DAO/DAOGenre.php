<?php namespace DAO; 

class DAOGenre
{
    private $genresList = array();
    private $fileName;
    
    public function __construct()
    {
        $this->fileName = dirname(__DIR__) . "/DAO/Data/genres.json";
    }
    
    
    public function GetAll()
    {
        echo "<pre>";
        print_r($this->genresList);
        echo "</pre>";

    }
    
    public function SaveData($data)
    {
        file_put_contents($this->fileName, $data);
        $this->genresList = json_decode($data);
    }
}
    ?>


