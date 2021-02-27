<?php
    namespace Controllers;
    use Models\User as User;
    use DB\PDO\DAOUser as DAOUser;
    use DB\PDO\DAOGenre as DAOGenre;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    use DB\PDO\DAOTicket as DAOTicket;
    use DB\PDO\DAOTransaction as DAOTransaction;
    use PDOException;

    require_once ROOT.'phpmailer/phpmailer/src/Exception.php';
    require_once ROOT.'phpmailer/phpmailer/src/PHPMailer.php';
    require_once ROOT.'phpmailer/phpmailer/src/SMTP.php';
            
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class UserController
    {
        private $DAOUser;
        private $DAOGenre;
        private $DAOMovie;
        private $DAOShow;
        private $DAOTicket;
        private $DAOTransaction;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
            $this->DAOGenre = new DAOGenre();
            $this->DAOMovie = new DAOMovie();
            $this->DAOShow = new DAOShow();
            $this->DAOTicket = new DAOTicket();
            $this->DAOTransaction = new DAOTransaction();
        }
        
        public function register()
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null, null);
            include VIEWS_PATH.'register-view.php';
        }

        public function adminView()
        {   
            if(AuthController::validate('admin')){
                $genreList = null;
                $moviesYearList = null; // el adminView no espera contenido para filtrar

                ViewController::navView($genreList,$moviesYearList,null,null); // falta implementar SESSION
                
                ViewController::adminView();
            }
        }

        public function ownerView()
        {
            if(AuthController::validate('owner')){
                try {
                    ViewController::navView($genreList = null, $moviesYearList = null, null, null);
                    $users=$this->DAOUser->getAll();
                    ViewController::ownerView($users);
                }
                catch(PDOException $ex)
                {
                    $arrayOfErrors [] = $ex->getMessage();
                    ViewController::errorView($arrayOfErrors);
                }
            }    
        }
        
        public function userView()
        {
            if(AuthController::validate('user')){
                try{
                    ViewController::navView($genreList = null, $moviesYearList = null, null, null);
                    $userName = $_SESSION['loggedUser'];
                    $user = $this->DAOUser->getByUserName($userName);
                    $transaction = $this->DAOTransaction->getTransactionsByUser($user);
                    $ticketsPerTT = array();
                    foreach($transaction as $oneTransaction){
                        $ticketsPerTT[$oneTransaction->getIdTransaction()] = $this->DAOTicket->getTicketsByTransaction($oneTransaction->getIdTransaction());
                    }
                    include VIEWS_PATH.'userView.php';
                } 

                catch(PDOException $ex)
                {
                    $arrayOfErrors [] = $ex->getMessage();
                    ViewController::errorView($arrayOfErrors);
                }
             }
        }
        
        public function showLoginForm()
        {
            ViewController::navView($genreList = null,$moviesYearList = null, null, null);
            include VIEWS_PATH.'login-view.php';
        }

        public function frontLogin($userName, $pass)
        {
            try{
                $loggedUser = $this->login($userName,$pass);

                if($loggedUser){
                    
                    $this->setSession($loggedUser);

                    $genreList = $this->DAOGenre->getGenresListFromShows();
                    $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
        
                    ViewController::navView($genreList,$moviesYearList,null,null);

                    $movieIds = $this->DAOShow->getBillBoard();
                    if (is_array($movieIds)){
                        $shows = $movieIds;
                    }else{
                        $shows[0] = $movieIds;
                    }

                    $movies = array();
                    #pasar luego a una QUERY del DAO
                    foreach ($movieIds as $key => $value) {
                        array_push($movies, $this->DAOMovie->getById($value['idMovie']));
                    }
                    $page = 1;
                    $title = "LATEST MOVIES IN PROJECTION";
                    
                    ViewController::homeView($movies,$page,$title);
                }
                else{
                    $genreList = $this->DAOGenre->getGenresListFromShows();
                    $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
        
                    ViewController::navView($genreList,$moviesYearList,null,null);
                    $error = "Invalid user/password!";
                    include_once VIEWS_PATH . 'login-view.php';
                }
            } 
            catch(PDOException $ex)
            {
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::errorView($arrayOfErrors);
            }
        }

        public function frontRegister($userName,$password,$email,$birthDate,$dni)
        {
            try{
                $newUser = $this->add($userName,$password,$email,$birthDate,$dni);
                
                if($newUser){
                    
                    $this->setSession($newUser);

                    ViewController::navView($genreList = null, $moviesYearList = null, null, null);

                    $movieIds = $this->DAOShow->getBillBoard();
                    if (is_array($movieIds)){
                        $shows = $movieIds;
                    }else{
                        $shows[0] = $movieIds;
                    }

                    $movies = array();
                #pasar luego a una QUERY del DAO
                foreach ($movieIds as $key => $value) {
                    array_push($movies, $this->DAOMovie->getById($value['idMovie']));
                }
                    $page = 1;
                    $title = "LATEST MOVIES IN PROJECTION";
                    
                    ViewController::homeView($movies,$page,$title);
                }
                else{
                    $error = "Username or Email already exists!";
                    include VIEWS_PATH.'register-view.php';
                }
            } 
            catch(PDOException $ex)
            {
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::errorView($arrayOfErrors);
            }
        }

        private function add($userName, $password, $email, $birthDate, $dni)
        {
            try{             
                $newUserObject = null;
                $existentUser = $this->DAOUser->getByUserName($userName);
                $existentEmail = $this->DAOUser->getByEmail($email);
                
                if(!$existentUser && !$existentEmail){
                    $newUserObject = new User($userName, $password, $email, $birthDate, $dni, 'user');
                    $this->DAOUser->add($newUserObject);
                    $this->sendWelcomeEmail($userName, $email);   
                }
            } 
            catch(PDOException $ex)
            {
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::errorView($arrayOfErrors);
            }
            return $newUserObject;
        }

        private function sendWelcomeEmail($name, $email){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                             // Send using SMTP
                $mail->Host       = MAIL_SERVER;                             // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
                $mail->Username   = MAIL_USR.'@'.MAIL_DOMAIN;                // SMTP username
                $mail->Password   = MAIL_PASS;                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
                //Recipients
                $mail->setFrom(MAIL_USR.'@'.MAIL_DOMAIN, 'Movie Pass');
                $mail->addAddress($email, $name);     // Add a recipient
                $mail->addReplyTo('info@TheMoviePass.com', 'Information');
        
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Welcome to MoviePass!';
                $mail->Body    = 'We are glad you have join us, ' . $name .  '. Hope you enjoy our latest movie collection! <br> The MoviePass team. '; 
                $mail->AltBody = 'Congratulations on joining Movie Pass ' . $name . '!'; 
                $mail->send();
            } catch (Exception $e) {
                $arrayOfErrors [] = $e->getMessage();
                $arrayOfErrors [] = $mail->ErrorInfo;
                ViewController::errorView($arrayOfErrors);
            }
        }

        public function login($userName, $password)
        {
            $user = $this->DAOUser->getByUserName($userName);

            if($user != null && ($password == $user->getPassword())){
                return $user;
            } else {
                return false;
            }
        }

        public function changeRole($userName){
            if(AuthController::validate('owner')){
                try{
                    $oneUserObj = $this->DAOUser->getByUserName($userName);
                    
                    if($oneUserObj->getRole() == 'admin'){
                        $this->DAOUser->changeRole($userName,'user');
                    }
                    elseif($oneUserObj->getRole() == 'user'){
                        $this->DAOUser->changeRole($userName,'admin');   
                    }

                    ViewController::navView($genreList = null, $moviesYearList = null,null,null);
                    
                    $users = $this->DAOUser->getAll();
                    ViewController::ownerView($users);
                } 
                catch(PDOException $ex)
                {
                    $arrayOfErrors [] = $ex->getMessage();
                    ViewController::errorView($arrayOfErrors);
                }
            }
        }

        public function setSession($user){ // Starts a session for a certain user

            if(!$this->is_session_started())
                session_start();

            $_SESSION['loggedUser'] = $user->getUserName();                
            $_SESSION['role'] =  $user->getRole();
 
        }

        public function logout() // Terminates a user's session
        {  
            if(!$this->is_session_started())
                session_start();

            session_destroy();
            session_start();

            $genreList = $this->DAOGenre->getGenresListFromShows();
            $moviesYearList = $this->DAOMovie->getArrayOfYearsFromShows();
            
            ViewController::navView($genreList,$moviesYearList,null,null); // falta implementar SESSION
            
            $movieIds = $this->DAOShow->getBillBoard();
            if (is_array($movieIds)){
                $shows = $movieIds;
            }else{
                $shows[0] = $movieIds;
            }

            $movies = array();
            #pasar luego a una QUERY del DAO
            foreach ($movieIds as $key => $value) {
                array_push($movies, $this->DAOMovie->getById($value['idMovie']));
            }

            $page = 1;
            $title = "LATEST MOVIES";
            
            ViewController::homeView($movies,$page,$title);
        }

        private function is_session_started() // Check session status (for all PHP versions)
        {
            if ( php_sapi_name() !== 'cli' ) {
                if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                    return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
                } else {
                    return session_id() === '' ? FALSE : TRUE;
                }
            }
            return FALSE;
        }      
    }
?>