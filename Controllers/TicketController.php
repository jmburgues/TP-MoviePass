<?php
    namespace Controllers;

    use \DateTime as DateTime;
    use \DateTimeZone as DateTimeZone;

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
    use DB\PDO\DAOTransaction as DAOTransaction;
    use DB\PDO\DAOTicket as DAOTicket;

    use Models\Transaction as Transaction;   
    use Models\Ticket as Ticket;   


    
  //  use Endroid\QrCode\QrCode;
    class TicketController
    {

        private $DAOMovie;
        private $DAOShow;
        private $DAORoom;
        private $DAOTransaction;
        private $DAOTicket;

        public function __construct(){

            $this->DAOMovie = new DAOMovie();
            $this->DAOShow = new DAOShow();
            $this->DAORoom = new DAORoom();
            $this->DAOTransaction = new DAOTransaction();
            $this->DAOTicket = new DAOTicket();
        }

        //Invoca la primer vista donde el usuario completa el form con los datos para la entrada
        public function showPurchase($movieId)
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            $userName = $_SESSION['loggedUser'];
            $selectedMovie = $this->DAOMovie->getById($movieId);
            $moviesForShows = $this->DAOShow->getShowFromMovie($movieId);
            include VIEWS_PATH.'purchase-view.php';
        }
        
        //Invocado desde purchase-view, recibe el id del show.
        public function getMinMax($idShow){
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            $min = 1;
            $max = $this->DAOshow->getById($idShow)->getRoom()->getCapacity() - $this->DAOshow->getById($idShow)->getSpectators();
            include VIEWS_PATH.'numberTickets.php';
        }

        //Invocada desde la vista donde el usuario completa el formulario de Tickets
        //Se implementa la política de descuento
        //Crea la transacción correspondiente y el ticket 
        //Redirige a vista de compra con credito, habiendo elegido anteriormente la tarjeta.
        //Envía a la vista el costo de las entradas
        public function addTicket($idShow, $ticketAmount, $cardBank)
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null);
            $showSelected = $this->DAOShow->getById($idShow);
            $movieForShows = $this->DAOMovie->getMoviesFromShow($showSelected->getMovie()->getMovieID());
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
            if ($cardBank == "Master") {
                $pattern = "[51-55]{2}[00-99]{2}[0000-9999]{4}[0000-9999]{4}[0000-9999]{4}";
            } else {
                if ($cardBank == "Visa") {
                    $pattern = "[41-49]{2}[00-99]{2}[0000-9999]{4}[0000-9999]{4}[0000-9999]{4}";
                } else {
                    if ($cardBank == "American") {
                        $pattern = "[34-37]{2}[00-99]{2}[0000-9999]{4}[0000-9999]{4}[0000-9999]{4}";
                    }
                }
            }
            $totalCost = $costPerTicket * $ticketAmount;
            $showToString = "STARTS AT: ".$showSelected->getStart()." ENDS AT: ".$showSelected->getEnd();
            include VIEWS_PATH.'confirmPurchase.php';
        }

    

        
        public function confirmTicket($creditNumber, $name, $cvc,  $expirationDate, $expirationYear, $idShow, $cardBank){
            ViewController::navView($genreList = null, $moviesYearList = null, null);

            $showCardLast = str_replace(range(0,9), "*", substr($creditNumber, 0, -4)) .  substr($creditNumber, -4);

            $name = str_replace(' ', '', $name);
            
            $movieFromShow = $this->DAOMovie->getMovieFromShowByIdShow($idShow);
            $showData = $this->DAOShow->getById($idShow);
            $cinema = $this->DAOShow->getCinemaNameFromShows($idShow);
            
            $dataForQR = $name." ".$movieFromShow[0]->getTitle()." ".$showData->getStart()." ".$showData->getEnd()." ".$showData->getDate()." ".$cinema;

            $d = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
            $time = $d->format('Y-m-d H:i:s');

            $transaction = new Transaction();
            $transaction->setUserName($_SESSION['loggedUser']);
            $transaction->setDate($time);
        
            $this->DAOTransaction->p_add_transaction($transaction);
            $idTransaction = $this->DAOTransaction->call();      

            $dataForQR = str_replace(' ', '%20', $dataForQR);
            $qr = $this->generateQR($dataForQR);            
            
            $ticket = new Ticket();
            $ticket->setQRCode($qr);
            $ticket->setIdShow($idShow);
            $ticket->setTdTransaction($idTransaction);
            
            $this->DAOTicket->add($ticket);

             //AGREGARLE LA DIRECCION Y LA SALA DEL CINE
            $userName = $_SESSION['loggedUser'];
            include VIEWS_PATH.'userView.php';

        protected function sendMail(){

            $userName = $_SESSION['loggedUser'];
            $user = $this->DAOUser->getByUserName($userName);

            

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

        
        public function generateQR($text){
            //$aux = "THE%20GAME";
            $data = "http://api.qrserver.com/v1/create-qr-code/?data=".$text."&size=250x250";
            return "<img src= ".$data."  alt='' title='' />";
            
        }
    
    }