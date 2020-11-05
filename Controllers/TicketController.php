<?php
    namespace Controllers;
  //  use PHPMailer\PHPMailer\PHPMailer;
    use Models\User as User;
    use DB\PDO\DAOUser as DAOUser;
    use DB\PDO\DAOGenre as DAOGenre;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    use DB\PDO\DAORoom as DAORoom;
    
  //  use Endroid\QrCode\QrCode;
    class TicketController
    {
        private $DAOUser;
        private $DAOGenre;
        private $DAOMovie;
        private $DAOShow;
        private $DAORoom;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
            $this->DAOGenre = new DAOGenre();
            $this->DAOMovie = new DAOMovie();
            $this->DAOShow = new DAOShow();
            $this->DAORoom = new DAORoom();
        }

        //Invoca la vista donde el usuario completa el form con los datos para la entrada
        public function showPurchase($movieId)
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            $userName = $_SESSION['loggedUser'];
            $selectedMovie = $this->DAOMovie->getById($movieId);
            $moviesForShows = $this->DAOShow->getShowFromMovie($movieId);
            include VIEWS_PATH.'purchase-view.php';
        }  

        //Invocada desde la vista donde el usuario completa el formulario de Tickets
        //Redirige a vista de usuario.
        public function addTicket($movie, $show, $ticket)
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            
            //Debería crear el ticket
            ViewController::userView($userName, $movie, $show, $ticket);
        }

        //Invocado desde purchase-view, recibe el id del show.
        public function getMinMax($idShow){
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            $min = 1;
            $max = 2;
            include VIEWS_PATH.'numberTickets.php';
            //$max = ($this->DAORoom->getById($value->getIdRoom())->getCapacity()) - $value->getSpectators();    
        }

        public function confirmTicket(){
            echo "Confirmado";
        }

        
        public function generateQR(){
            $aux = "THE%20GAME";
            $data = "http://api.qrserver.com/v1/create-qr-code/?data=".$aux."&size=250x250";
            echo "<img src= ".$data."  alt='' title='' />";
            
        }
    
    }