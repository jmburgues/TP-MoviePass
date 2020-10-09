<?php
    namespace Controllers;
    use DAO\DAOGenre as DAOGenre;

    class GenreController{
        private $DAOGenre;
        public function __construct(){
            $this->DAOGenre = new DAOGenre;
            $this->fileName = dirname(__DIR__) . "/DAO/Data/genres.json";
        }
        public function requestGenres(){   
            
            $data = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=601e12bf1e7197e7532eb9c4901b0d3a&language=en-US");
            echo "<pre>";
            echo "</pre>";
            $this->DAOGenre->SaveData($data);
            $this->DAOGenre->GetAll();

        }
    }
?>