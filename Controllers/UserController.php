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
            $cinemas = $this->DAOCinema->GetAll();  
            include VIEWS_PATH.'adminView.php';
            include_once VIEWS_PATH.'footer.php';
        }
        
        public function showLoginForm()
        {
            include VIEWS_PATH.'login-view.php';
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
            if(session_status() !== PHP_SESSION_ACTIVE)
                session_start();
            $user = $this->DAOUser->getByUserName($userName);

            if($user != null && ($password == $user->getPassword())){
                $_SESSION['loggedUser'] = $user;

                include VIEWS_PATH."index.php";
            }
        }

        public function logout()
        {
            if(session_status() !== PHP_SESSION_ACTIVE)
                session_start();

            if(isset($_SESSION['loggedUser']))
                unset($_SESSION['loggedUser']);
        }
    }
?>