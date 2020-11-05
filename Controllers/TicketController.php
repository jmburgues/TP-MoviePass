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
        //Se implementa la política de descuento
        //Redirige a vista de compra con credito, habiendo elegido anteriormente la tarjeta.
        //Envía a la vista el costo de las entradas
        public function addTicket($idShow, $ticketAmount, $card)
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            $showSelected = $this->DAOShow->getById($idShow);
            $movieForShows = $this->DAOMovie->getMoviesFromShow($showSelected->getIdMovie());
            $costPerTicket = $this->DAOShow->getPriceByIdShow($idShow);
            $costPerTicket= $costPerTicket[0][0];
            $patern;
            //Politica de descuento:
            $actualDate = date('l');
            if ($ticketAmount >= 2) {
                if ($actualDate == "Tuesday" || $actualDate == "Wednesday") {
                    $costPerTicket = $costPerTicket -(((25 * $costPerTicket)/100));
                }
            }
            if ($card == "Master") {
                $pattern = "[51-55]{2}[00-99]{2}[0000-9999]{4}[0000-9999]{4}[0000-9999]{4}";
            } else {
                if ($card == "Visa") {
                    $pattern = "[41-49]{2}[00-99]{2}[0000-9999]{4}[0000-9999]{4}[0000-9999]{4}";
                } else {
                    if ($card == "American") {
                        $pattern = "[34-37]{2}[00-99]{2}[0000-9999]{4}[0000-9999]{4}[0000-9999]{4}";
                    }
                }
            }

            $totalCost = $costPerTicket * $ticketAmount;
            $showToString = "STARTS AT: ".$showSelected->getStart()." ENDS AT: ".$showSelected->getEnd();
            include VIEWS_PATH.'confirmPurchase.php';
        }

        //Invocado desde purchase-view, recibe el id del show.
        public function getMinMax($idShow){
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            $min = 1;
            $max = $this->DAORoom->getById($this->DAOShow->getById($idShow)->getIdRoom())->getCapacity()-$this->DAOShow->getById($idShow)->getSpectators();
            print_r($max); 
            include VIEWS_PATH.'numberTickets.php';
        }

        
        public function confirmTicket($creditNumber, $name, $cvc,  $expirationDate, $expirationYear, $idShow, $cardBank){
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            print_r($idShow);
            print_r($cardBank);
            $showCardLast = str_replace(range(0,9), "*", substr($creditNumber, 0, -4)) .  substr($creditNumber, -4);

            $name = str_replace(' ', '', $name);
            $dataForQR = $name."%.".$cvc."%".$creditNumber."%".$expirationDate."%".$expirationYear."%".$cardBank;
            $qr = $this->generateQR($dataForQR);
            
            $userName = $_SESSION['loggedUser'];
            include VIEWS_PATH.'userView.php';
        }

        
        public function generateQR($text){
            //$aux = "THE%20GAME";
            $data = "http://api.qrserver.com/v1/create-qr-code/?data=".$text."&size=250x250";
            return "<img src= ".$data."  alt='' title='' />";
            
        }
    
    }