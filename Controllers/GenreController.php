<?php
    namespace Controllers;
    use DAO\DAOGenre as DAOGenre;
    require_once dirname(__FILE__)."/../DAO/DAOGenre.php";


    class GenreController
    {
        private $DAOGenre;
        private $data;

        public function __construct()
        {
            $this->DAOGenre = new DAOGenre;
            $this->fileName = ROOT."Data/genre.json";
        }
    
        public function requestGenres()
        {
            $this->data = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=601e12bf1e7197e7532eb9c4901b0d3a&language=en-US");
            echo "<pre>";
            echo ($this->data);
            echo "</pre>";
            $this->DAOGenre->SaveData($this->data);
            
        }
        public function showGenres()
        {
            echo "<pre>";
            echo ($this->data);
            echo "</pre>";
        }
        
    }
?>