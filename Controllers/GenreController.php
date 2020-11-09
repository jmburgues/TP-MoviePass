<?php
    namespace Controllers;
    use DB\PDO\DAOGenre as DAOGenre;
    require_once dirname(__FILE__)."/../DAO/DAOGenre.php";


    class GenreController
    {
        private $DAOGenre;

        public function __construct()
        {
            $this->DAOGenre = new DAOGenre;
        }
    
        
    }
?>