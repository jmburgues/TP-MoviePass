<?php
    namespace Controllers;

    use Models\User as User;
    use DAO\PDO\PDOUser as DAOUser;
    use DAO\PDO\PDOGenre as DAOGenre;
    use DAO\PDO\PDOMovie as DAOMovie;

    class UserController
    {
        private $DAOUser;
        private $DAOGenre;
        private $DAOMovie;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
            $this->DAOCinema = new DAOGenre();
            $this->DAOMovie = new DAOMovie();
        }

        public function register()
        {
            include VIEWS_PATH.'register-view.php';
            //include_once VIEWS_PATH.'footer.php';
        }

        public function adminView()
        {
            $genreList = $this->DAOGenre->getGenresList();
            $moviesYearList = $this->DAOMovie->getArrayOfYears();

            ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION
            
            ViewController::adminView();

        }

        public function ownerView()
        {
            $users=$this->DAOUser->getAll();
            ViewController::ownerView($users);
        }
        
        public function showLoginForm()
        {
            include VIEWS_PATH.'login-view.php';
            //include_once VIEWS_PATH.'footer.php';
        }
        public function frontLogin($userName, $pass)
        {
                $loggedUser = $this->login($userName,$pass);

                if($loggedUser){
                    
                    $this->setSession($loggedUser);

                    $genreList = $this->DAOGenre->getGenresList();
                    $moviesYearList = $this->DAOMovie->getArrayOfYears();
        
                    ViewController::navView($genreList,$moviesYearList,null);

                    $movies = $this->DAOMovie->getAll();
                    $page = 1;
                    $title = "LATEST MOVIES";
                    
                    ViewController::homeView($movies,$page,$title);
                }
                else{
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

                $movies = $this->DAOMovie->getAll();
                $page = 1;
                $title = "LATEST MOVIES";
                
                ViewController::homeView($movies,$page,$title);
            }
            else{
                $error = "Username or Email already exists!";
                include VIEWS_PATH.'register-view.php';
            }
        }

        public function showPurchase()
        {
            include VIEWS_PATH.'purchase-view.php';
            //include_once VIEWS_PATH.'footer.php';
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

            $genreList = $this->DAOGenre->getGenresList();
            $moviesYearList = $this->DAOMovie->getArrayOfYears();
            
            ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION

            ViewController::navView($genreList,$moviesYearList,null);

            $movies = $this->DAOMovie->getAll();
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