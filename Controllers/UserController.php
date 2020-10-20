<?php
    namespace Controllers;

    use DAO\DAOUser as DAOUser;
    use Models\User as User;
    use DAO\DAOCinema as DAOCinema;
    use Models\Cinema as Cinema;


    class UserController
    {
        private $DAOUser;
        private $DAOCinema;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
            $this->DAOCinema = new DAOCinema();
        }

        public function register()
        {
            include VIEWS_PATH.'register-view.php';
            include_once VIEWS_PATH.'footer.php';
        }

        public function adminView()
        {
            include VIEWS_PATH.'adminView.php';
            include_once VIEWS_PATH.'footer.php';
        }
        
        public function showLoginForm()
        {
            include VIEWS_PATH.'login-view.php';
            include_once VIEWS_PATH.'footer.php';
        }
        public function frontLogin()
        {
            if($_POST){
                $user = $_POST['userName'];
                $pass = $_POST['password'];

                $loggedUser = $this->login($user,$pass);

                if($loggedUser){

                    if(session_status() !== PHP_SESSION_ACTIVE)
                        session_start();
                    
                    $_SESSION['loggedUser'] = $user;                 
                    $_SESSION['isAdmin'] =  ($loggedUser->isAdmin()) ? true : false;

                    header('Location:'.FRONT_ROOT.'index.php');
                }
            }
        }

        public function showPurchase()
        {
            include VIEWS_PATH.'purchase-view.php';
            include_once VIEWS_PATH.'footer.php';
        }
        //ni idea como pero habría que validar

        public function add($userName, $password, $email, $birthDate, $dni, $admin)
        {
            $user = new User($userName, $password, $email, $birthDate, $dni, $admin);
            $this->DAOUser->add($user);
            include VIEWS_PATH.'login-view.php';
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

        public function logout()
        {  
            if(!$this->is_session_started())
	            session_start();
            session_destroy();
            header('Location:'.FRONT_ROOT.'/index.php');          
        }

        private function is_session_started() // verifica estado de sesion dependiendo version PHP
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