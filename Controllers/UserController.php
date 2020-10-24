<?php
    namespace Controllers;

    use DAO\DAOUser as DAOUser;
    use Models\User as User;
    use DAO\DAOCinema as DAOCinema;
    use Models\Cinema as Cinema;
    use Models\Movie as Movie;
    use DAO\DAOMovie as DAOMovie;

    class UserController
    {
        private $DAOUser;
        private $DAOCinema;
        private $DAOMovie;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
            $this->DAOCinema = new DAOCinema();
            $this->DAOMovie = new DAOMovie();
        }

        public function register()
        {
            include VIEWS_PATH.'register-view.php';
            include_once VIEWS_PATH.'footer.php';
        }

        public function adminView()
        {
            $movies=$this->DAOMovie->GetAll();
            include VIEWS_PATH.'adminView.php';
            include_once VIEWS_PATH.'footer.php';
        }
        
        public function showLoginForm()
        {
            include VIEWS_PATH.'login-view.php';
            include_once VIEWS_PATH.'footer.php';
        }
        public function frontLogin($userName, $pass)
        {
                $loggedUser = $this->login($userName,$pass);

                if($loggedUser){

                    $this->setSession($loggedUser);

                    header('Location:'.FRONT_ROOT.'index.php');
                }
                else{
                    $error = "Invalid user/password!";
                    include_once VIEWS_PATH . 'login-view.php';
                }
        }

        public function frontRegister($userName,$password,$email,$birthDate,$dni)
        {
            $isAdmin = false;
            $newUser = $this->add($userName,$password,$email,$birthDate,$dni,$isAdmin);
            
            if($newUser){
                
                $this->setSession($newUser);

                header('Location:'.FRONT_ROOT.'index.php');
            }
            else{
                $error = "Username or Email already exists!";
                include VIEWS_PATH.'register-view.php';
            }
        }

        public function showPurchase()
        {
            include VIEWS_PATH.'purchase-view.php';
            include_once VIEWS_PATH.'footer.php';
        }
        
        public function add($userName, $password, $email, $birthDate, $dni, $admin)
        {
            $existentUser = false;
            $existentEmail = false;

            $userList = $this->DAOUser->getAll();

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

        public function setSession($user){ // Starts a session for a certain user

            if(!$this->is_session_started())
                session_start();

            $_SESSION['loggedUser'] = $user->getUserName();                
            $_SESSION['isAdmin'] =  ($user->isAdmin()) ? true : false;
        }

        public function logout() // Terminates a user's session
        {  
            if(!$this->is_session_started())
	            session_start();
            session_destroy();
            header('Location:'.FRONT_ROOT.'/index.php');          
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