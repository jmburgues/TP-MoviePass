<?php
    namespace Controllers;

    require_once ROOT.'phpmailer/phpmailer/src/Exception.php';
    require_once ROOT.'phpmailer/phpmailer/src/PHPMailer.php';
    require_once ROOT.'phpmailer/phpmailer/src/SMTP.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

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

            $userName = $_SESSION['loggedUser'];
            $user = $this->DAOUser->getByUserName($userName);

            echo "Confirmado";

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = MAIL_SERVER;                         // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = MAIL_USR.'@'.MAIL_DOMAIN;                     // SMTP username
                $mail->Password   = MAIL_PASS;                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
                //Recipients
                $mail->setFrom(MAIL_USR.'@'.MAIL_DOMAIN, 'Mailer');
                $mail->addAddress($user->getEmail(), $user->getName());     // Add a recipient
                $mail->addReplyTo('info@TheMoviePass.com', 'Information');
            
                // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }

        
        public function generateQR(){
            $aux = "THE%20GAME";
            $data = "http://api.qrserver.com/v1/create-qr-code/?data=".$aux."&size=250x250";
            echo "<img src= ".$data."  alt='' title='' />";
            
        }
    
    }