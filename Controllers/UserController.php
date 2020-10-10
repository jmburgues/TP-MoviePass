<?php
    namespace Controllers;

    use Models\User as User;
    use DAO\DAOUser as DAOUser;

    class UserController
    {
        private $DAOUser;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
        }

        public function register()
        {
            include VIEWS_PATH.'register-view.php';
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