<?php
    namespace Controllers;
  //  use PHPMailer\PHPMailer\PHPMailer;
    use Models\User as User;
    use DB\PDO\DAOUser as DAOUser;
    use DB\PDO\DAOGenre as DAOGenre;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    
  //  use Endroid\QrCode\QrCode;
    class TicketController
    {
        private $DAOUser;
        private $DAOGenre;
        private $DAOMovie;
        private $DAOShow;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
            $this->DAOGenre = new DAOGenre();
            $this->DAOMovie = new DAOMovie();
            $this->DAOShow = new DAOShow();
        }
        
        //Invoca la vista donde el usuario completa el form con los datos para la entrada
        public function addTicket($movie, $roomName, $tickets)
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            print_r($movie);
            print_r($roomName);
            print_r($tickets);

        }
    }