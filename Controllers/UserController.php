<?php
    namespace Controllers;
  //  use PHPMailer\PHPMailer\PHPMailer;
    use Models\User as User;
    use DB\PDO\DAOUser as DAOUser;
    use DB\PDO\DAOGenre as DAOGenre;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;
    
  //  use Endroid\QrCode\QrCode;
    class UserController
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

            ViewController::navView($genreList = null, $moviesYearList = null, null, null);

            $users=$this->DAOUser->getAll();
            ViewController::ownerView($users);
        }
        

        public function userView()
        {

            ViewController::navView($genreList = null, $moviesYearList = null, null, null);
        $userName = $_SESSION['loggedUser'];
            ViewController::userView($userName);
        }
        
    

        public function showLoginForm()
        {
            ViewController::navView($genreList = null,$moviesYearList = null, null, null);
            include VIEWS_PATH.'login-view.php';
        }
        public function frontLogin($userName, $pass)
        {
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

        public function frontRegister($userName,$password,$email,$birthDate,$dni)
        {
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


        public function add($userName, $password, $email, $birthDate, $dni, $admin)
        {
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

                return $user;
            }
            else{
                return false;
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
    

        public function sendMail(){
            ini_set( 'display_errors', 1 );
            error_reporting( E_ALL );

            $from = "briascojazmin@gmail.com";
            $to = "nikolasv1994@gmail.com";
            $subject = "Hola bb";
            $message = "Este es un mensaje automático de Movie Pass, gracias por formar parte de esta maravillosa familia. PD: THE GAME";
            $headers = "From:" . $from;
            mail($to,$subject,$message, $headers);
            echo "The email message was sent.";

        }

        public function generateQR(){
            $textqr = 100;
            $sizeqr = 100;
            $qrCode = new QrCode($textqr);
            $qrCode->setSize($sizeqr);
            $image= $qrCode->writeString();//Salida en formato de texto 
            $imageData = base64_encode($image);//Codifico la imagen usando base64_encode
            echo '<img src="data:image/png;base64,'.$imageData.'">';
        }

    
    }
?>