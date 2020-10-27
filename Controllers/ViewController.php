<?php
    namespace Controllers;

    class ViewController{

        public static function homeView($movies,$page,$title){
            
            require_once(VIEWS_PATH.'nav.php');
            require_once(VIEWS_PATH.'home.php');
        }

        public static function ownerView($usersList){
                
            include(VIEWS_PATH.'ownerView.php');
        }

    }


?>