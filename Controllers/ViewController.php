<?php
    namespace Controllers;

    class ViewController{

        public static function homeView($movies,$page,$title){
            
            require_once(VIEWS_PATH.'home.php');
        }

        public static function navView($genresList, $moviesYearList, $sessionUser){

            require_once(VIEWS_PATH.'nav.php');
        }

        public static function ownerView($usersList){
                
            require_once(VIEWS_PATH.'ownerView.php');
        }

    }


?>