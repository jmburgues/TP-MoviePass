<?php
    namespace Controllers;
    use DAO\DAOMovie as DAOMovie;
    use Modes\Cinema as Cinema;
    
    class HomeController
    {
        private $daoMovie;
        
        public function __construct(){
            $this->daoMovie = new DAOMovie();
        }
    
        public function Index($message = 1)
        {
            $movies = $this->daoMovie->getAll();

            $total = count($movies);
    
            $articulosXPagina = 5;
            $paginas = ($total / $articulosXPagina );
            $paginas = ceil($paginas);
            $pagina = $message;
            $iniciar = ($message-1)*$articulosXPagina;

            require_once(VIEWS_PATH."home.php");
        }        
    }
?>