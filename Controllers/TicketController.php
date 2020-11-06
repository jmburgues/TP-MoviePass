<?php
    namespace Controllers;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require ROOT.'phpmailer/phpmailer/src/Exception.php';
    require 'phpmailer/phpmailer/src/PHPMailer.php';
    require 'phpmailer/phpmailer/src/SMTP.php';

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
        public function addTicket()
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            
            //Debería crear el ticket
            ViewController::userView("Hola", "hola", "hoa", "aloh");
        }

        //Invocado desde purchase-view, recibe el id del show.
        public function getMinMax($idShow){
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            $min = 1;
            $max = $this->DAORoom->getById($this->DAOShow->getById($idShow)->getRoom()->getRoomID())->getCapacity()-$this->DAOShow->getById($idShow)->getSpectators();
            print_r($max); 
            include VIEWS_PATH.'numberTickets.php';
            //$max = ($this->DAORoom->getById($value->getRoom()->getRoomID())->getCapacity()) - $value->getSpectators();    
        }

        public function confirmTicket(){
            echo "Confirmado";


            $mail = new PHPMailer;

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'postmaster@sandbox00c09636e3954aa49f6a407b0ee3720b.mailgun.org';   // SMTP username
            $mail->Password = '3381f526aa06ee0c8214076113e90d63-ea44b6dc-201841de';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted

            $mail->From = 'postmaster@sandbox00c09636e3954aa49f6a407b0ee3720b.mailgun.org';
            $mail->FromName = 'MoviePass TEST';
            $mail->addAddress('burgues.jm@gmail.com');                 // Add a recipient

            $mail->WordWrap = 50;                                 // Set word wrap to 50 characters

            $mail->Subject = 'TESTING';
            $mail->Body    = 'Testing some Mailgun awesomness';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }

        }

        
        public function generateQR(){
            $aux = "THE%20GAME";
            $data = "http://api.qrserver.com/v1/create-qr-code/?data=".$aux."&size=250x250";
            echo "<img src= ".$data."  alt='' title='' />";
            
        }
    
    }