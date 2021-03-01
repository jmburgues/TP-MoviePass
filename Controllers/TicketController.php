<?php
    namespace Controllers;

    use \DateTime as DateTime;
    use \DateTimeZone as DateTimeZone;

    require_once ROOT.'phpmailer/phpmailer/src/Exception.php';
    require_once ROOT.'phpmailer/phpmailer/src/PHPMailer.php';
    require_once ROOT.'phpmailer/phpmailer/src/SMTP.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception as MailException;

    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    use DB\PDO\DAOUser as DAOUser;
    use DB\PDO\DAORoom as DAORoom;
    use DB\PDO\DAOTransaction as DAOTransaction;
    use DB\PDO\DAOTicket as DAOTicket;


    use Models\Transaction as Transaction;   
    use Models\Ticket as Ticket;   
    use Models\Show as Show;   
    use Models\User as User;
use PDOException;

//  use Endroid\QrCode\QrCode;
    class TicketController
    {
        private $DAOMovie;
        private $DAOShow;
        private $DAOUser;
        private $DAORoom;
        private $DAOTransaction;
        private $DAOTicket;

        public function __construct(){
            $this->DAOMovie = new DAOMovie();
            $this->DAOShow = new DAOShow();
            $this->DAORoom = new DAORoom();
            $this->DAOUser = new DAOUser();
            $this->DAOTransaction = new DAOTransaction();
            $this->DAOTicket = new DAOTicket();
        }

        //Invoca la primer vista donde el usuario completa el form con los datos para la entrada
        public function selectShow($movieId)
        {
            try {
                ViewController::navView($genreList = null, $moviesYearList = null, null, null);
                $userName = $_SESSION['loggedUser'];
                $selectedMovie = $this->DAOMovie->getById($movieId);
                $moviesForShows = $this->DAOShow->getShowFromMovieRoom($movieId);
                include VIEWS_PATH.'selectShow.php';
            } 
            catch (PDOException $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::errorView($arrayOfErrors);
            }
        }
        
        //Invocado desde purchase-view, recibe el id del show.
        public function selectAmmount($idShow){
            try{
                ViewController::navView($genreList = null, $moviesYearList = null, null, null);
                $min = 1;
                $max = $this->DAOShow->getById($idShow)->getRoom()->getCapacity() - $this->DAOShow->getById($idShow)->getSpectators();
                include VIEWS_PATH.'selectAmmount.php';
            } 
            catch (PDOException $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::errorView($arrayOfErrors);
            }
        }

        //Invocada desde la vista donde el usuario completa el formulario de Tickets
        //Se implementa la política de descuento
        //Crea la transacción correspondiente y el ticket 
        //Redirige a vista de compra con credito, habiendo elegido anteriormente la tarjeta.
        //Envía a la vista el costo de las entradas
        public function payment($idShow, $ticketAmount, $cardBank)
        {
            try{
                ViewController::navView($genreList = null, $moviesYearList = null, null, null);
                $showSelected = $this->DAOShow->getById($idShow);
                $movieForShows = $this->DAOMovie->getMoviesFromShow($showSelected->getMovie()->getMovieID());
                $costPerTicket = $this->DAOShow->getPriceByIdShow($idShow);
                $costPerTicket= $costPerTicket[0][0];

                //Politica de descuento:
                $actualDate = date('l');
                if ($ticketAmount >= 2) {
                    if ($actualDate == "Tuesday" || $actualDate == "Friday") {
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
                
                $showToString = "STARTS AT: ". substr($showSelected->getStart(), 0, -3)." ENDS AT: ". substr($showSelected->getEnd(), 0, -3);
                include VIEWS_PATH.'payment.php';
            } 
            catch (PDOException $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::errorView($arrayOfErrors);
              }
        }

        public function confirmTicket($costPerTicket, $totalCost, $ticketAmount, $cardNumber, $owner, $cvv,  $date, $year, $idShow, $cardBank)
        {
            #try{
                ViewController::navView($genreList = null, $moviesYearList = null, null, null);

                $show = $this->DAOShow->getById($idShow);
                $user = $this->DAOUser->getByUserName($_SESSION['loggedUser']);              

                $currentTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
                $currentTime = $currentTime->format('Y-m-d H:i:s');
                $transaction = $this->generateNewTransaction($user, $currentTime, $costPerTicket, $ticketAmount);
                $tickets = $this->generateTickets($show,$transaction,$ticketAmount,$idShow);       
                $showCardLast = str_replace(range(0,9), "*", substr($cardNumber, 0, -4)) .  substr($cardNumber, -4);
                $nameString = str_replace(' ', '', $owner);
                $movieFromShow = $this->DAOMovie->getMovieFromShowByIdShow($idShow);
                
                $this->sendMail($owner, $costPerTicket, $totalCost, $ticketAmount, $show,$tickets);
                //AGREGARLE LA DIRECCION Y LA SALA DEL CINE

                include VIEWS_PATH.'ticketInformation.php';
        }

        private function generateNewTransaction($user,$currentTime,$costPerTicket,$ticketAmount){

            $transaction = new Transaction($user);
            $transaction->setDate($currentTime);
            $transaction->setCostPerTicket($costPerTicket);
            $transaction->setTicketAmount($ticketAmount);
        
            $this->DAOTransaction->p_add_transaction($transaction);
            
            $idTransaction = $this->DAOTransaction->call($transaction->getDate(),$transaction->getUser()->getUserName());      

            $transaction->setIdTransaction($idTransaction);

            return $transaction;
        }

        private function generateTickets($show,$transaction,$ticketAmount,$idShow){

            $tickets = array();

            for($i=0;$i<$ticketAmount;$i++){
                
                $qrData = $transaction->getIdTransaction().$idShow.$i.uniqid();
                
                $newTicket = new Ticket($show,$transaction);
                $newTicket->setQRCode($this->generateQR($qrData));            
                
                $this->DAOTicket->add($newTicket);

                array_push($tickets,$newTicket);
            }

            return $tickets;            
        }

        private function sendMail($name, $costPerTicket, $totalCost, $ticketAmount, Show $showData, $tickets){
            
            $userName = $_SESSION['loggedUser'];
            $user = $this->DAOUser->getByUserName($userName);            

            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     // Enable verbose debug output
                $mail->isSMTP();                                             // Send using SMTP
                $mail->Host       = MAIL_SERVER;                             // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
                $mail->Username   = MAIL_USR.'@'.MAIL_DOMAIN;                // SMTP username
                $mail->Password   = MAIL_PASS;                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
                //Recipients
                $mail->setFrom(MAIL_USR.'@'.MAIL_DOMAIN, 'Movie Pass');
                $mail->addAddress($user->getEmail(), $user->getUserName());     // Add a recipient
                $mail->addReplyTo('info@TheMoviePass.com', 'Information');
            
                // Attachments
                $i = 1;
                foreach($tickets as $oneTicket){
                    $attachmentUrl =  $oneTicket->getQRCode();
                    $tempFile = tempnam(sys_get_temp_dir(), 'QRTicket-'.$i.'-'.$oneTicket->getIdTicket()).'.png';  
                    file_put_contents($tempFile, file_get_contents($attachmentUrl));

                    $mail->addAttachment($tempFile);         // Add attachments
                    $i++;
                }
            
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Succes purchase information';
                $mail->Body    = 'Thank you for your purchase ' .$name. '! <br><br> <h2>Purchase details</h2> <br> 
                <ul><li>Ticket cost: '.$costPerTicket.'</li><li>Quantity bought: '.$ticketAmount.'</li><li>Total import: '.$totalCost.'</li></ul>
                <h3>Show details: </h3><br>
                <ul><li>Cinema: '.$showData->getRoom()->getCinema()->getName().'</li><li>Address: '.$showData->getRoom()->getCinema()->getAddress().'</li><li>Room: '.$showData->getRoom()->getName().'</li><li>Movie: '.$showData->getMovie()->getTitle().'</li><li>Starts: '.$showData->getStart().'</li><li>End: '.$showData->getEnd().'</li></ul><br>';
                
                $mail->AltBody = 'Thank you for your purchase ' .$name. '! Purchase details
                Ticket cost: '.$costPerTicket.'Quantity bought: '.$ticketAmount.'Total import: '.$totalCost.'
                Show details: 
                Cinema: '.$showData->getRoom()->getCinema()->getName().'Address: '.$showData->getRoom()->getCinema()->getAddress(). ' '.$showData->getRoom()->getCinema()->getNumber().'Room: '.$showData->getRoom()->getName().'Movie: '.$showData->getMovie()->getTitle().'Starts: '.$showData->getStart().'End: '.$showData->getEnd();
                


                $mail->send();
            } catch (MailException $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }

        private function generateQR($text){
            $data = "http://api.qrserver.com/v1/create-qr-code/?data=".$text."&size=250x250";
            // return "<img src= ".$data."  alt='' title='' />";
            return $data;            
        }
    }