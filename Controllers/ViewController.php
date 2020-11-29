<?php
    namespace Controllers;

    class ViewController{

        public static function homeView($movies,$page,$title){
            $title = "Enjoy latest movies.";
            require_once(VIEWS_PATH.'home.php');
        }

        public static function navView($genresList, $moviesYearList, $sessionUser,$arrayOfErrors){

            require_once(VIEWS_PATH.'nav.php');
        }

        public static function adminView(){
            if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'owner'))
                require_once(VIEWS_PATH.'adminView.php');
            else
                ViewController::errorView("ERROR 403: Forbidden access.");
        }

        public static function ownerView($users){
            if(isset($_SESSION['role']) && $_SESSION['role'] == 'owner')
                require_once(VIEWS_PATH.'ownerView.php');
            else
                ViewController::errorView("ERROR 403: Forbidden access.");
        }

        public static function userView($userName){

            require_once(VIEWS_PATH.'userView.php');
        }

        public static function errorView($arrayOfErrors){
            require_once(VIEWS_PATH.'error.php');
        }

    }


?>