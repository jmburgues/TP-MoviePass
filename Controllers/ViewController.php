<?php
    namespace Controllers;

    class ViewController{

        public static function homeView($movies,$page,$title){
            
            require_once(VIEWS_PATH.'home.php');
        }

        public static function navView($genresList, $moviesYearList, $sessionUser){

            require_once(VIEWS_PATH.'nav.php');
        }

        public static function adminView(){
                
            require_once(VIEWS_PATH.'adminView.php');
        }

        public static function ownerView($users){
                
            require_once(VIEWS_PATH.'ownerView.php');
        }

        public static function userView($userName){

            require_once(VIEWS_PATH.'userView.php');
        }

    }


?>