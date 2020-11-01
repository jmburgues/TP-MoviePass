<?php
    namespace Controllers;

    use Models\User as User;
    use DB\PDO\DAOUser as DAOUser;
    use DB\PDO\DAOGenre as DAOGenre;
    use DB\PDO\DAOMovie as DAOMovie;
    use DB\PDO\DAOShow as DAOShow;

    class UserController
    {
        private $DAOUser;
        private $DAOGenre;
        private $DAOMovie;

        public function __construct()
        {
            $this->DAOUser = new DAOUser();
            $this->DAOGenre = new DAOGenre();
            $this->DAOMovie = new DAOMovie();
        }

        public function register()
        {
            include VIEWS_PATH.'register-view.php';
        }

        public function adminView()
        {   
            $genreList = null;
            $moviesYearList = null; // el adminView no espera contenido para filtrar

            ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION
            
            ViewController::adminView();

        }

        public function ownerView()
        {

            ViewController::navView($genreList = null, $moviesYearList = null, null);

            $users=$this->DAOUser->getAll();
            ViewController::ownerView($users);
        }
        
        public function showLoginForm()
        {
            ViewController::navView($genreList = null,$moviesYearList = null, null);
            include VIEWS_PATH.'login-view.php';
        }
        public function frontLogin($userName, $pass)
        {
                $loggedUser = $this->login($userName,$pass);

                if($loggedUser){
                    
                    $this->setSession($loggedUser);

                    $genreList = $this->DAOGenre->getAll();
                    $moviesYearList = $this->DAOMovie->getArrayOfYears();
        
                    ViewController::navView($genreList,$moviesYearList,null);

                    $movies = $this->corn();
                    $page = 1;
                    $title = "LATEST MOVIES IN PROYECTION";
                    
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

                ViewController::navView($genreList = null, $moviesYearList = null, null);

                $movies = $this->corn();
                $page = 1;
                $title = "LATEST MOVIES IN PROYECTION";
                
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

        public function changeRole($userName){
            $oneUserObj = $this->DAOUser->getByUserName($userName);
            
            if($oneUserObj->getRole() == 'admin'){
                $this->DAOUser->changeRole($userName,'user');
            }
            elseif($oneUserObj->getRole() == 'user'){
                $this->DAOUser->changeRole($userName,'admin');   
            }

            ViewController::navView($genreList = null, $moviesYearList = null,null);
            
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

            $genreList = $this->DAOGenre->getAll();
            $moviesYearList = $this->DAOMovie->getArrayOfYears();
            
            ViewController::navView($genreList,$moviesYearList,null); // falta implementar SESSION

            ViewController::navView($genreList,$moviesYearList,null);

            $movies = $this->corn();
            $page = 1;
            $title = "LATEST MOVIES IN PROYECTION";
            
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
    
    
    
    function corn(){
        $auxShow = new DAOShow();
        $shows = array();
        $aux = $auxShow->getAll();
        if (is_array($aux)){
            $shows = $aux;
        }else{
            $shows[0] = $aux;
        }
        
        $movies = array();
        #pasar luego a una QUERY del pdo
        $aux = array();
        foreach ($shows as $show) {
            if(!(in_array($show->getIdMovie(),$aux))){
                array_push($aux,$show->getIdMovie());
                array_push($movies, $this->DAOMovie->getById($show->getIdMovie()));
            }
        }
        return $movies; 
    }  
    
    
    
    
    }
?>