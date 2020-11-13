<?php
    namespace Controllers;
    use Models\User as User;
    use DB\PDO\DAOUser as DAOUser;
    use DB\PDO\DAOGenre as DAOGenre;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    use DB\PDO\DAOTransaction as DAOTransaction;
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
        private $DAOTransaction;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
            $this->DAOGenre = new DAOGenre();
            $this->DAOMovie = new DAOMovie();
            $this->DAOShow = new DAOShow();
            $this->DAOTransaction = new DAOTransaction();
        }
        

        public function register()
        {
            ViewController::navView($genreList = null, $moviesYearList = null, null, null);
            include VIEWS_PATH.'register-view.php';
        }

        public function adminView()
        {   
            $genreList = null;
            $moviesYearList = null; // el adminView no espera contenido para filtrar

            ViewController::navView($genreList,$moviesYearList,null,null); // falta implementar SESSION
            
            ViewController::adminView();

        }

        public function ownerView()
        {
            try {
                ViewController::navView($genreList = null, $moviesYearList = null, null, null);
                $users=$this->DAOUser->getAll();
                ViewController::ownerView($users);
            } 

            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                ViewController::homeView($movies,$page,$title);
            }
            
        }
        

        public function userView()
        {
            try{
                ViewController::navView($genreList = null, $moviesYearList = null, null, null);
                $userName = $_SESSION['loggedUser'];
                $user = $this->DAOUser->getByUserName($userName);
                $transaction = $this->DAOTransaction->getTransactionsByUser($user);
                include VIEWS_PATH.'userView.php';
            } 

            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                ViewController::homeView($movies,$page,$title);
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

            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                ViewController::homeView($movies,$page,$title);
            }
        }

        public function frontRegister($userName,$password,$email,$birthDate,$dni)
        {
            try{
                $role = "user";
                $newUser = $this->add($userName,$password,$email,$birthDate,$dni,$role);
                
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

            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                ViewController::homeView($movies,$page,$title);
            }
        }





        public function add($userName, $password, $email, $birthDate, $dni, $admin)
        {
            try{
                $existentUser = false;
                $existentEmail = false;

                $userList = $this->DAOUser->getAll(); // buscar ese usuario en particular o email en particular

                foreach($userList as $oneUser){
                    if($oneUser->getUserName() == $userName)
                        $existentUser = true;
                    if($oneUser->getEmail() == $email)
                        $existentEmail = true;
                }
                if(!$existentUser && !$existentEmail){
                    $user = new User($userName, $password, $email, $birthDate, $dni, $admin);
                    $this->DAOUser->add($user);
                    $this->sendMail($userName, $email);

                    return $user;
                }
                else{
                    return false;
                }
            } 

            catch (Exception $ex){
                throw $ex;
            }
        }


        private function sendMail($name, $email){

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
                $mail->Subject = 'Succes register';
                $mail->Body    = 'Congratulations on joining Movie Pass ' . $name . '!'; 
                $mail->AltBody = 'Congratulations on joining Movie Pass ' . $name . '!'; 
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

            catch (Exception $ex){
                $arrayOfErrors [] = $ex->getMessage();
                ViewController::navView($genreList=null,$moviesYearList=null,null,$arrayOfErrors);
                ViewController::ownerView($users);
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